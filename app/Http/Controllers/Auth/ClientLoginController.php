<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:client', ['except'=>['logout']]);
    }
    
    public function loginVerify(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|string',
        ]);
        return response()->json(['status'=>1,'message'=>'validated']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password'=>'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput($request->only('email', 'remember'));
        }

        //attempt to log the user
        if (Auth::guard('client')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'),'status'=>1], $request->remember)) {
            //success redirect
            return redirect()->back();
        }
        
        //unsuccess redirect
        $validator->errors()->add('email', 'These credentials do not match our records.');
        return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors($validator);
    }

    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        return redirect('/');
    }
}
