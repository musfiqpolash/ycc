<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Information;
use App\Model\Product;
use App\Model\Setting;
use App\Model\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Mail\Send_mail;
use App\Mail\Newsletter;
use Gloudemans\Shoppingcart\Facades\Cart;

class BAKFrontendController extends Controller
{
    protected function countVisitor()
    {
        $tmp = Visitor::where('d_date', date('Y-m-d'))->get();
        //dd($tmp);
        if (sizeof($tmp) == 0) {
            $dTmp = new Visitor();
            $dTmp->d_date = date('Y-m-d');
            $dTmp->total_count = 1;
            $dTmp->created_at = date('Y-m-d');
            $dTmp->save();
        } else {
            $tNum = $tmp[0]->total_count + 1;
            Visitor::where('id', $tmp[0]->id)->update(['total_count' => $tNum]);
        }
    }

    protected function getTodayVisitor()
    {
        $this->countVisitor();
        $res = Visitor::where('d_date', date('Y-m-d'))->get(['total_count'])->first();
        if (empty($res)) {
            return 0;
        } else
            return $res->total_count;
    }

    protected function commonData($title)
    {
        $data['title'] = $title;
        $data['page_data'] = Setting::first();
        $data['visitor'] = sprintf("%09s", $this->getTodayVisitor());
        return $data;
    }

    protected function index()
    {
        $data = $this->commonData('Home');
        $product = Product::where('status', 1)
            ->where('is_accessories', 1)
            ->orderBy('category')
            ->get();
        $data['products'] = $product->groupBy('group_name');

        $accessory = Product::where('status', 1)
            ->where('is_accessories', 0)
            ->orderBy('category')
            ->get();
        $data['accessories'] = $accessory->groupBy('group_name');

        //dd($data);
        return view('frontend.home', $data);
    }

    protected function product_details($name, $id)
    {
        $data = $this->commonData('Prodict Details');

        $data['product_details'] = Product::with('hasImage')
            ->where('group_name', $id)
            ->where('status', 1)
            ->get();
        $getPrdctClrWise=$data['product_details']->groupBy('color');
        $data['product_size']=Product::where('name',$data['product_details'][0]->name)->where('color',$data['product_details'][0]->color)
        					->select('color','size','id','price','name')->get();
        //dd($getPrdctClrWise);
        if (empty($data['product_details'])) {

        } else {
            $accessory = Product::where('status', 1)
                ->where('is_accessories', 0)
                ->where('category', $data['product_details'][0]->category)
                ->get();
            $data['accessories'] = $accessory->groupBy('group_name')->take(4);

            $data['info']=Information::get();
            //dd($data);
            return view('frontend.product_details', $data);
        }

    }

    public function getSize($name,$color){
        $data=Product::where('name',$name)->where('color',$color)->select('color','size','id','price','name')->get();
        return json_encode($data);
        //print_r($_GET) ;
    }




    protected function getPrdctInfo(Request $r)
    {

    }


    protected function contact_us()
    {
        $data = $this->commonData('Contact Us');
        return view('frontend.contact_us', $data);
    }

    public function send_mail(Request $r)
    {
        $data['email'] = $r->input('email');
        $data['name'] = $r->input('name');
        $data['subject'] = $r->input('subject');
        $data['messages'] = $r->input('message');
        //echo '<pre>'; print_r($data); die();

        Mail::to('support@greensomobaybazar.com')->send(new Send_mail($data));
        return redirect('/contact_us')->with('success', 'Message has been send.');
    }

    public function newsletter(Request $r)
    {
        $data['email'] = $r->input('email');
        $data['subject'] = 'Newsletter';
        //echo '<pre>'; print_r($data); die();

        Mail::to('support@greensomobaybazar.com')->send(new Newsletter($data));
        return redirect('/')->with('success', 'কার্যক্রমটি সফল হয়েছে');
    }

    public function addToCart(Request $r)
    {
        $qty = $r->input('quantity');
        $id = $r->input('product_id');
        $product = Product::where('id', $id)->get();
        //dd($product);
        $a = Cart::add(['id' => $product[0]->id, 'name' => $product[0]->name, 'qty' => $qty, 'price' => $product[0]->price, 'options' => ['size' => $product[0]->size, 'color' => $product[0]->color, 'p_code' => $product[0]->p_code, 'image' => $product[0]->main_image]]);
        if ($a->qty > $product[0]->quantity) {
            Cart::update($a->rowId, $product[0]->quantity);
            $data['message'] = 'Only ' . $product[0]->quantity . ' products are available at this moment';
        } else {
            $data['message'] = 'item added to cart successfully';

        }
        $data['count'] = sprintf("%'.02d", Cart::count());
        echo json_encode($data);

    }

    public function cart()
    {
        $data = $this->commonData('Cart');

        return view('frontend.cart', $data);
    }

    public function removeFromCart($rowId)
    {
        Cart::remove($rowId);
        return back();
    }

    public function updateCart($rowId, $id, $qty)
    {
        $data['a'] = $rowId;
        $data['b'] = $id;
        $data['c'] = $qty;
        $qu = Product::where('id', $id)->select('quantity')->get();
        if ($qty > $qu[0]->quantity) {
            $data['status'] = 'false';
            $data1 = Cart::get($rowId);
            $data['qty'] = $data1->qty;
            $data['stock'] = $qu[0]->quantity;
        } else {
            if($qty>0){
               Cart::update($rowId, $qty);
               $data1 = Cart::get($rowId);
               $data['status'] = 'true';
               $data['total'] = $data1->price * $data1->qty;
               $data['count'] = sprintf("%'.02d", Cart::count());
               $data['subTotal'] = Cart::subtotal();
               $data['tTotal'] = number_format((float)implode('', explode(',', Cart::subtotal())) + 15, 2);
            }else {
               $data['status'] = 'reload';
               Cart::remove($rowId);
            }
        }
        echo json_encode($data);
    }

    public function checkout()
    {
        $data = $this->commonData('Checkout');
        return view('frontend.checkout', $data);
    }

    public function payPal()
    {
        $data = $this->commonData('payPal checkout');
        return view('frontend.payPal', $data);
    }
}
