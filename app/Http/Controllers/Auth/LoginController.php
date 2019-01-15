<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated($request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'),'status'=>1])) {
            $tmpEmp = Auth::user()->emp_id;
            Session::put('login_id', Auth::user()->id);
            Session::put('name',Auth::user()->name);
            return redirect()->intended('admin');
        }else{
            return redirect()->intended('/logout');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function logout(Request $request)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $request->session()->flush();
        return redirect('/login');
    }
}
