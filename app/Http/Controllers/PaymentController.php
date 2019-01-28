<?php

namespace App\Http\Controllers;

use App\Model\OrderDetails;
use App\Model\OrderInfo;
use App\Model\PaymentInfo;
use App\Model\Product;
use App\Model\Setting;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Mockery\Exception;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/

use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;

class PaymentController extends Controller
{
    private $_api_context;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(
            new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret']
        )
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function index()
    {
        return view('paywithpaypal');
    }

    public function payWithpaypal(Request $request)
    {
        //dd($request->all());
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $allItem = array();

        $tmpPname = $request->input('p_name');
        $tmpPamnt = $request->input('p_amount');
        $tmpPqty = $request->input('p_qty');
        $tmpPclr = $request->input('p_clr');
        $tmpPsize = $request->input('p_size');
        $tmpPid = $request->input('p_code');
        $total = 0;
        foreach ($tmpPamnt as $k => $val) {
            $item_1 = new Item();
            $item_1->setName($tmpPname[$k])
                ->setCurrency('USD')
                ->setDescription('Color: ' . $tmpPclr[$k] . ' Size: ' . $tmpPsize[$k])
                ->setQuantity($tmpPqty[$k])
                ->setPrice($tmpPamnt[$k])
                ->setSku($tmpPid[$k]);
            array_push($allItem, $item_1);
            $total += $val * $tmpPqty[$k];
        }
        $details = new Details();
        $details->setShipping(15)
            ->setSubtotal($total);
        $total += 15;
        $item_list = new ItemList();
        $item_list->setItems($allItem);


        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($total)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($request->input('note'));

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('status'))/** Specify return URL **/
        ->setCancelUrl(URL::to('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);
            //dd($payment->getLinks());
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::flash('error', 'Connection timeout');
                return Redirect::to('/cart');
            } else {
                \Session::flash('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/cart');
            }
        } catch (Exception $e) {
            dd($e);
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {

            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }

        \Session::flash('error', 'Unknown error occurred');
        return Redirect::to('/cart');
    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::flash('error', 'Payment failed');
            return Redirect::to('/cart');
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            //dd($result);
            DB::transaction(function () use ($result) {
                $tmpTrn = $result->transactions[0]->item_list;
                $tmpItm = $tmpTrn->items;
                $tmpPayer = $result->payer->payer_info;
                $shpaddrs['recipient_name'] = $tmpTrn->shipping_address->recipient_name;
                $shpaddrs['line1'] = $tmpTrn->shipping_address->line1;
                $shpaddrs['city'] = $tmpTrn->shipping_address->city;
                $shpaddrs['state'] = $tmpTrn->shipping_address->state;
                $shpaddrs['postal_code'] = $tmpTrn->shipping_address->postal_code;
                $shpaddrs['country_code'] = $tmpTrn->shipping_address->country_code;

                $pymnt = new PaymentInfo();
                $pymnt->email = $tmpPayer->email;
                $pymnt->first_name = $tmpPayer->first_name;
                $pymnt->last_name = $tmpPayer->last_name;
                $pymnt->payer_id = $tmpPayer->payer_id;
                $pymnt->payment_method = $result->payer->payment_method;
                $pymnt->status = 1;
                $pymnt->created_at = date('Y-m-d');
                $pymnt->save();

                $odr = new OrderInfo();
                do {
                    $tmpSlug = substr(uniqid(), 0, 7);
                    $tmpOrdrSlug = OrderInfo::where('slug', $tmpSlug)->get(['slug']);
                } while (sizeof($tmpOrdrSlug) != 0);
                $odr->slug = $tmpSlug;
                $odr->client_id = auth('client')->user()->id;
                $odr->d_date = date('Y-m-d');
                $odr->payment_id = $pymnt->id;
                $odr->transaction_id = $result->id;
                $odr->shipping_point = json_encode($shpaddrs);
                $odr->comment = '';
                $odr->shipping_cost = Setting::where('id', 1)->first()->shipping_cost;
                $odr->order_amount = $result->transactions[0]->amount->total;
                $odr->status = 1;
                $odr->created_at = date('Y-m-d');
                $odr->save();

                foreach ($tmpItm as $itm) {
                    $tmpItmId = Product::where('p_code', $itm->sku)->first();
                    if (empty($tmpItmId)) {
                    }
                    $ordrDtls = new OrderDetails();
                    $ordrDtls->order_id = $odr->id;
                    $ordrDtls->p_id = $tmpItmId->id;
                    $ordrDtls->p_qty = $itm->quantity;
                    $ordrDtls->p_sell_price = $itm->price;
                    $ordrDtls->is_discount = $tmpItmId->is_discount;
                    $ordrDtls->main_price = $tmpItmId->hasPrice[0]->price;
                    $ordrDtls->created_at = date('Y-m-d');
                    $ordrDtls->save();
                }
                Cart::destroy();
            });

            \Session::flash('success', 'Thank You For Using Our Service.');
            return Redirect::to('/cart');
        }

        \Session::flash('error', 'Payment failed');
        return Redirect::to('/cart');
    }
}
