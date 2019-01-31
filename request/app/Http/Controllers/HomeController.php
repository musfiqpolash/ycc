<?php

namespace App\Http\Controllers;

use App\Slider;
use App\Additional;
use App\ProductRequest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['welcome']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['req']=ProductRequest::count('id');
        $data['slider']=Slider::count('id');
        return view('home', $data);
    }

    public function welcome()
    {
        $data['sliders']=Slider::all();
        $data['additionals']=Additional::orderBy('priority', 'desc')->orderBy('created_at', 'desc')->get();
        return view('welcome', $data);
    }
}
