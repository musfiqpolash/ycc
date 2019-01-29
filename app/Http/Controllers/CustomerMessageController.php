<?php

namespace App\Http\Controllers;

use App\CustomerMessage;
use Illuminate\Http\Request;

class CustomerMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages=CustomerMessage::all();
        return view('backend.pages.customer_message', compact('messages'));
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
            'name'=>'required|string|max:191',
            'email'=>'required|email',
            'subject'=>'required|string|max:191',
            'message'=>'required|string',
        ]);

        CustomerMessage::create($request->only(['name','email','subject','message']));

        return redirect()->back()->with('msg', 'Message Received, We Will Contact You Shortly');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerMessage  $customerMessage
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerMessage $customerMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerMessage  $customerMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerMessage $customerMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerMessage  $customerMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerMessage $customerMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerMessage  $customerMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerMessage $customerMessage)
    {
        //
    }
}
