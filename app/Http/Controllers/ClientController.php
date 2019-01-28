<?php

namespace App\Http\Controllers;

use App\Model\OrderInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    public function showProfile()
    {
        return view('frontend.client_profile');
    }
    public function showDashboard()
    {
        // dd(auth('client')->user()->orders);
        return view('frontend.client_dashboard');
    }
    public function showOrders()
    {
        return view('frontend.client_orders');
    }

    public function changePasswordRequest(Request $request)
    {
        $request->validate([
            'current_password'=>'required',
            'new_password'=>'required|different:current_password|confirmed|min:6',
        ]);
        if (!(Hash::check($request->input('current_password'), auth('client')->user()->password))) {
            return response()->json(['errors'=>['current_password_error'=>['Your current password does not matches with the password you provided. Please try again.']]], 422);
        }
        return response()->json(['status'=>1], 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'=>'required',
            'new_password'=>'required|different:current_password|confirmed|min:6',
        ]);
        if (!(Hash::check($request->input('current_password'), auth('client')->user()->password))) {
            return redirect()->back()->with('danger', 'Your current password does not matches with the password you provided. Please try again.');
        }
        auth('client')->user()->password=bcrypt($request->input('new_password'));
        auth('client')->user()->save();

        return redirect()->back()->with('success', 'Your Password Changed');
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name'=>'required|string|max:191',
            'last_name'=>'required|string|max:191',
            'phone'=>'required',
        ]);

        $cl= auth('client')->user();
        $cl->first_name=$request->input('first_name');
        $cl->last_name=$request->input('last_name');
        $cl->phone=$request->input('phone');
        $cl->save();

        return redirect()->back()->with('success', 'Profile Information Updated');
    }

    public function orderDetails($id)
    {
        $order=OrderInfo::where('client_id', auth('client')->user()->id)->findOrFail($id);
        
        return view('frontend.order_details', compact('order'));
    }
}
