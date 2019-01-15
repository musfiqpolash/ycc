<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Information;
use App\Model\Product;
use App\Model\ProductImage;
use App\Model\ProductPrice;
use App\Model\Setting;
use App\Model\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Mail\Send_mail;
use App\Mail\Newsletter;
use Gloudemans\Shoppingcart\Facades\Cart;

class FrontendController extends Controller
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
        $tmp = Product::all();
     //   foreach ($tmp as $val) {
           // $ptbl['main_image']='main_image_'.$val->id.'.jpg';
            //Product::where('id',$val->id)->update($ptbl);
           // $tmp=ProductImage::where('product_id',$val->id)->orderBy('id')->first();
          //  if($tmp){
           //     $tmp->p_main_image='main_image_'.$val->id.'.jpg';
           //     $tmp->save();
           // }
            //$sd = new ProductPrice();
            //$sd->product_id = $val->id;
            //$sd->min_quantity = 1;
            //$sd->max_quantity = 1;
            //$sd->price = $val->price;
            //$sd->created_at = date('Y-m-d');
            //$sd->save();
       // }
//        $tmp=ProductImage::all();
//        foreach ($tmp as $val){
//
//        }
        
        
        $data = $this->commonData('Home');
        $product = Product::with('hasPrice')
            ->where('status', 1)
            ->where('is_accessories', 1)
			->orderBy('name')
            ->get();
//        dd($product->all());
        $data['products'] = $product->groupBy('group_name');

        $accessory = Product::with('hasSinglePrice')
			->where('status', 1)
            ->where('is_accessories', 0)
			->orderBy('name')
            ->get();
        $data['accessories'] = $accessory->groupBy('group_name');

        //dd($data);
        return view('frontend.home', $data);
    }

    protected function product_details($name, $id)
    {
        $data = $this->commonData('Prodict Details');
        $data['info'] = Information::get();

        $tmpProduct = Product::with('hasImage')
            ->where('group_name', $id)
            ->where('status', 1)
            ->get();
        $tmpCondition = $tmpProduct->groupBy('product_condition');
        $data['condList'] = array();
        foreach ($tmpCondition as $k => $v) {
            array_push($data['condList'], $k);
        }

        $tmpSize = $tmpProduct->groupBy('size');
        $data['sizeList'] = array();
        foreach ($tmpSize as $k => $v) {
            array_push($data['sizeList'], $k);
        }

        $tmpColor = $tmpProduct->groupBy('color');
        $data['colorList'] = array();
        foreach ($tmpColor as $k => $v) {
            $tmpVAL['color'] = $k;
            $tmpVAL['color_img'] = $v[0]->hasImage[0]->color_img;
            array_push($data['colorList'], $tmpVAL);
        }


        $retData = $this->getPrdctInfo($id, $data['condList'][0], $data['sizeList'][0], $data['colorList'][0], 'cond', 1);

        $data['activeGrade'] = $retData['activeGrade'];
        $data['activeSize'] = $retData['activeSize'];
        $data['activeColor'] = $retData['activeColor'];
        $data['prdctInfo'] = $retData['prdctInfo'];

        $accessory = Product::where('status', 1)
            ->with('hasSinglePrice')
            ->where('is_accessories', 0)
            ->where('category', $data['prdctInfo'][0]->name)
            ->get();
        $data['accessories'] = $accessory->groupBy('group_name')->take(4);

        return view('frontend.product_details', $data);
    }

    public function getProductJson(Request $r)
    {
        $grp = $r->input('grp');
        $grade = $r->input('cnd');
        $size = $r->input('size');
        $color = $r->input('color');
        $wise = $r->input('wise');
        $qty = $r->input('qty');
        $value = $this->getPrdctInfo($grp, $grade, $size, $color, $wise, $qty);
        return $value;
    }

    protected function getPrdctInfo($grp, $grade, $size, $color, $wise, $qty)
    {
        if ($wise == 'cond') {
            $tmpProduct = Product::with('hasImage')
                ->with('hasSinglePrice')
                ->with('hasPriceList')
                ->with(['hasPrice' => function ($q) use ($qty) {
                    $q->where('min_quantity', '<=', $qty);
                    $q->where('max_quantity', '>=', $qty);
                }])
                ->where('group_name', $grp)
                ->where('status', 1)
                ->where('product_condition', $grade)
                ->get();
            $data['activeGrade'] = $grade;

            $tmpSizePrdct = $tmpProduct->where('size', $size);
            if (sizeof($tmpSizePrdct) == 0) {
                $tmpSizePrdct = $tmpProduct;
            } else {
                $data['activeSize'] = $size;
            }
            $tmpColorPrdct = $tmpSizePrdct->where('color', $color);
            if (sizeof($tmpColorPrdct) == 0) {
                $tmpColorPrdct = $tmpSizePrdct;

                $data['activeSize'] = $tmpColorPrdct[0]->size;
                $data['activeColor'] = $tmpColorPrdct[0]->color;
            } else {
                $data['activeColor'] = $color;
            }
            $data['prdctInfo'] = $tmpColorPrdct;
        } elseif ($wise == 'size') {
            $tmpProduct = Product::with('hasImage')
                ->with('hasSinglePrice')
                ->with('hasPriceList')
                ->with(['hasPrice' => function ($q) use ($qty) {
                    $q->where('min_quantity', '<=', $qty);
                    $q->where('max_quantity', '>=', $qty);
                }])
                ->where('group_name', $grp)
                ->where('status', 1)
                ->where('size', $size)
                ->get();
            $data['activeSize'] = $size;

            $tmpCondPrdct = $tmpProduct->where('product_condition', $grade);
            if (sizeof($tmpCondPrdct) == 0) {
                $tmpCondPrdct = $tmpProduct;
            } else {
                $data['activeGrade'] = $grade;
            }
            $tmpColorPrdct = $tmpCondPrdct->where('color', $color);
            if (sizeof($tmpColorPrdct) == 0) {
                $tmpColorPrdct = $tmpCondPrdct;

                $data['activeGrade'] = $tmpColorPrdct[0]->product_condition;
                $data['activeColor'] = $tmpColorPrdct[0]->color;
            } else {
                $data['activeColor'] = $color;
            }
            $data['prdctInfo'] = $tmpColorPrdct;
        } elseif ($wise == 'color') {
            $tmpProduct = Product::with('hasImage')
                ->with('hasSinglePrice')
                ->with('hasPriceList')
                ->with(['hasPrice' => function ($q) use ($qty) {
                    $q->where('min_quantity', '<=', $qty);
                    $q->where('max_quantity', '>=', $qty);
                }])
                ->where('group_name', $grp)
                ->where('status', 1)
                ->where('color', $color)
                ->get();
            $data['activeColor'] = $color;

            $tmpCondPrdct = $tmpProduct->where('product_condition', $grade);
            if (sizeof($tmpCondPrdct) == 0) {
                $tmpCondPrdct = $tmpProduct;
            } else {
                $data['activeGrade'] = $grade;
            }
            $tmpSizePrdct = $tmpCondPrdct->where('size', $size);
            if (sizeof($tmpSizePrdct) == 0) {
                $tmpSizePrdct = $tmpCondPrdct;

                $data['activeGrade'] = $tmpSizePrdct[0]->product_condition;
                $data['activeSize'] = $tmpSizePrdct[0]->size;
            } else {
                $data['activeSize'] = $size;
            }
            $data['prdctInfo'] = $tmpSizePrdct;
        }
//        dd($data);
        return $data;
    }

    protected function getPriceListLoad(){
        $tmp=Input::get('priceInfo');
        $tmp2=json_decode($tmp[0]);
        $data['priceInfo']=$tmp2;
        $data['qty']=Input::get('qty');
        return view('includes.wholesale', $data);
    }
    public function getSize($name, $color)
    {
        $data = Product::where('name', $name)->where('color', $color)->select('color', 'size', 'id', 'price', 'name')->get();
        return json_encode($data);
        //print_r($_GET) ;
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
        $product = Product::with('hasSinglePrice')
            ->with(['hasPrice' => function ($q) use ($qty) {
                $q->where('min_quantity', '<=', $qty);
                $q->where('max_quantity', '>=', $qty);
            }])
            ->where('id', $id)->get();
//        dd($product);
        $tmpPrice = $product[0]->hasSinglePrice->price;
        if (sizeof($product[0]->hasPrice) != 0 && $product[0]->hasPrice[0]->price) {
            $tmpPrice = $product[0]->hasPrice[0]->price;
        }
        //dd($product);
        $a = Cart::add(['id' => $product[0]->id, 'name' => $product[0]->name, 'qty' => $qty, 'price' => $tmpPrice, 'options' => ['size' => $product[0]->size, 'color' => $product[0]->color, 'p_code' => $product[0]->p_code, 'image' => $product[0]->main_image]]);
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

        $product = Product::with('hasSinglePrice')
            ->with(['hasPrice' => function ($q) use ($qty) {
                $q->where('min_quantity', '<=', $qty);
                $q->where('max_quantity', '>=', $qty);
            }])
            ->where('id', $id)->get();
        $tmpPrice = $product[0]->hasSinglePrice->price;
        if (sizeof($product[0]->hasPrice) != 0 && $product[0]->hasPrice[0]->price) {
            $tmpPrice = $product[0]->hasPrice[0]->price;
        }

        if ($qty > $qu[0]->quantity) {
            $data['status'] = 'false';
            $data1 = Cart::get($rowId);
            $data['qty'] = $data1->qty;
            $data['stock'] = $qu[0]->quantity;
        } else {
            if ($qty > 0) {
//                Cart::update($rowId, $qty);
                Cart::update($rowId, [
                    'qty' => $qty,
                    'price' => $tmpPrice,
                ]);
                $data1 = Cart::get($rowId);
                $data['status'] = 'true';
                $data['total'] = $data1->price * $data1->qty;
                $data['new_price'] = $data1->price;
                $data['count'] = sprintf("%'.02d", Cart::count());
                $data['subTotal'] = Cart::subtotal();
                $data['tTotal'] = number_format((float)implode('', explode(',', Cart::subtotal())) + 15, 2);
            } else {
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
