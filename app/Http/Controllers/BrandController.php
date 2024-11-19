<?php

namespace App\Http\Controllers;
use App\Models\Brand;

use Illuminate\Http\Request;

class BrandController extends Controller
{
     /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $brands = Brand::orderBy('id','desc')->paginate(10);
        return view('brands.index', compact('brands'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('brands.create');
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
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);

        Brand::create($request->post());

        return redirect()->route('brands.index')->with('success','Brand has been created successfully.');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Brand  $brand
    * @return \Illuminate\Http\Response
    */
    public function show(Brand $brand)
    {
        return view('brands.show',compact('brand'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Brand $brand
    * @return \Illuminate\Http\Response
    */
    public function edit(Brand $brand)
    {
        return view('brands.edit',compact('brand'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Brand  $brand
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);

        $brand->fill($request->post())->save();

        return redirect()->route('brands.index')->with('success','Brand Has Been updated successfully');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Brand $brand
    * @return \Illuminate\Http\Response
    */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success','Brand has been deleted successfully');
    }
}
