<?php

namespace App\Http\Controllers;

use App\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners=Banner::isBanner()->get();
        return view('backend.pages.banner.list', compact('banners'));
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
            'image'=>'required|file|image|max:1024'
        ]);
        $name=time().'.'.$request->image->getClientOriginalExtension();
        \Image::make($request->image)->resize(1024, 350)->save(public_path('uploads/banner/').$name);
        $banner=new Banner();
        $banner->name=$name;
        $banner->type='banner';
        $banner->save();

        return redirect()->back()->with('success', 'banner added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner=Banner::findOrFail($id);
        if (file_exists(public_path('uploads/banner/'.$banner->name))) {
            unlink(public_path('uploads/banner/'.$banner->name));
        }
        $banner->delete();

        return redirect()->back()->with('success', 'Banner Deleted');
    }

    public function brands()
    {
        $brands=Banner::isBrand()->get();
        return view('backend.pages.brand.list', compact('brands'));
    }

    public function brand_store(Request $request)
    {
        $request->validate([
            'image'=>'required|file|image|max:1024'
        ]);
        $name=time().'.'.$request->image->getClientOriginalExtension();
        \Image::make($request->image)->resize(130, 100)->save(public_path('uploads/banner/').$name);
        $brand=new Banner();
        $brand->name=$name;
        $brand->type='brand';
        $brand->save();

        return redirect()->back()->with('success', 'banner added');
    }

    public function request_brands()
    {
        $brands=Banner::isRequestBrand()->get();
        return view('backend.pages.request_brand.list', compact('brands'));
    }

    public function request_brand_store(Request $request)
    {
        $request->validate([
            'image'=>'required|file|image|max:1024'
        ]);
        $name=time().'.'.$request->image->getClientOriginalExtension();
        \Image::make($request->image)->resize(130, 100)->save(public_path('uploads/banner/').$name);
        $brand=new Banner();
        $brand->name=$name;
        $brand->type='request_brand';
        $brand->save();

        return redirect()->back()->with('success', 'banner added');
    }
}
