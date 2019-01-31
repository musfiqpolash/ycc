<?php

namespace App\Http\Controllers;

use App\ProductRequest;
use Illuminate\Http\Request;

class ProductRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $p_req= ProductRequest::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.pages.product_request', compact('p_req'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'url'=>'required|active_url',
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required|numeric',
            'address'=>'nullable|string',
        ]);
        $req=new ProductRequest();
        $req->url=$request->url;
        $req->name=$request->name;
        $req->email=$request->email;
        $req->phone=$request->phone;
        $req->address=$request->address;
        $req->save();

        return response()->json(['status'=>1,'message'=>'Your Order Has Been Palced, We Will Contact With You Shortly.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRequest $productRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRequest $productRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductRequest $productRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRequest $productRequest)
    {
        //
    }
}
