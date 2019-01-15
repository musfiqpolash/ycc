<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class sspController extends Controller
{
    //
    public function index(){
        Cart::add(['id' => '293ad', 'name' => 'Product 1', 'qty' => 1, 'price' => 9.99, 'options' => ['size' => 'large']]);
//        Cart::destroy();
        //dd(Cart::content());
        $num=sprintf("%'.02d", Cart::count());
        return view('index',compact('num'));
    }
    public function contact_us(){
        Cart::destroy();
        $num=sprintf("%'.02d", Cart::count());
        return view('contact',compact('num'));
    }

    public function details(){
        $num=sprintf("%'.02d", Cart::count());
        return view('details',compact('num'));
    }
    public function cart(){
        $num=sprintf("%'.02d", Cart::count());
        return view('cart',compact('num'));
    }
    public function checkout(){
        $num=sprintf("%'.02d", Cart::count());
        return view('checkout',compact('num'));
    }
}
