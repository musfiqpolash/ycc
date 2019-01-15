<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected function get_product(Request $r)
    {
        $res = Product::where('group_name', $r->input('group'))->get(['main_image']);

        return response()->json($res);
    }
    protected function product_details($name,$id){
        
        
    }

}
