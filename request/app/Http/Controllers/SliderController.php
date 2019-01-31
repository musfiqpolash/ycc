<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sliders= Slider::all();

        return view('sliders', compact('sliders'));
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
            'image'=>'required|base64image'
        ]);

        $img_arr_1=explode(';', $request->image);

        $img_arr_2=explode(',', $img_arr_1[1]);

        $img=base64_decode($img_arr_2[1]);

        $img_name=time().'.png';

        if (file_put_contents(public_path()."/uploads/".$img_name, $img)) {
            $sli=new Slider();
            $sli->name=$img_name;
            $sli->save();
        } else {
            return response()->json(['status'=>'error','message'=>'something went wrong']);
        }


        return response()->json([
            'status'=>'success',
            'message'=>'Slider Uploaded',
            'slider'=>$sli
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sli=Slider::findOrFail($id);

        if (file_exists(public_path()."/uploads/".$sli->name)) {
            unlink(public_path()."/uploads/".$sli->name);
        }
        $sli->delete();

        return response()->json([
                    'status'=>'success',
                    'message'=>'Slider Deleted'
                ]);
    }
}
