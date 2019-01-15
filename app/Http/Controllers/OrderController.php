<?php

namespace App\Http\Controllers;

use App\Model\OrderDetails;
use App\Model\OrderInfo;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $data['page_name'] = 'Order List';
        $data['page_data'] = OrderInfo::where('status', 1)->get();
        return view('backend.pages.order.list', $data);        
    }

    public function details($id)
    {
        $data['page_name'] = 'Order Details';
        $data['page_data'] = OrderInfo::with('hasOrderDetails.hasProduct', 'hasPayment')
            ->where('status', 1)
            ->where('id', $id)
            ->first();

       // dd($data);
        if (empty($data['page_data'])) {
            $data['msg'] = 'Something Went Wrong. Please try properly.';
            return view('includes.err_show', $data);
        } else {
            return view('backend.pages.order.details', $data);
        }
    }

    public function destroy(Request $r)
    {
        $upD['status'] = 0;
        OrderInfo::where('id', $r->input('orderId'))
            ->update($upD);
        OrderDetails::where('order_id', $r->input('orderId'))
            ->update($upD);

        return back()->with('success', 'Order Has Been Deleted');
    }
}
	