<?php

namespace App\Http\Controllers;

use App\Model\Information;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show_info($name)
    {
        if ($name == 'return_policy') {
            $data['page_name'] = 'Return Policy';
            $data['page_data'] = Information::where('id',1)->first();
            return view('backend.pages.settings.details', $data);
        } elseif ($name == 'shipping_info') {
            $data['page_name'] = 'Shipping Info';
            $data['page_data'] = Information::where('id',2)->first();
            return view('backend.pages.settings.details', $data);
        } else {
            $data['page_name'] = '';
            $data['msg'] = 'Something Went Wrong. Please try properly.';
            return view('includes.err_show', $data);
        }
    }

    public function update_info(Request $r)
    {
        Information::where('id',$r->input('id'))->update(['description'=>$r->input('description')]);
        return back()->with('success','Information Updated');
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
	