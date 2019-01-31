<?php

namespace App\Http\Controllers;

use App\Additional;
use Illuminate\Http\Request;

class AdditionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_data']=Additional::orderBy('priority', 'desc')->orderBy('created_at', 'desc')->paginate(2);

        return view('additional', $data);
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
            'title'=>'required|string',
            'description'=>'required|string',
            'priority'=>'nullable|numeric'
        ]);

        $add=new Additional();
        $add->title=$request->title;
        $add->description=$request->description;
        $request->filled('priority')?$add->priority=$request->priority:'';

        $add->save();

        return redirect()->back()->with('success', 'Information Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Additional  $additional
     * @return \Illuminate\Http\Response
     */
    public function show(Additional $additional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Additional  $additional
     * @return \Illuminate\Http\Response
     */
    public function edit(Additional $additional)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Additional  $additional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Additional $additional)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Additional  $additional
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $add=Additional::findOrFail($id);
        $add->delete();

        return redirect()->back()->with('success', 'item deleted');
    }
}
