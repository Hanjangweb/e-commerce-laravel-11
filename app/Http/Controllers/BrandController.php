<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //brands
        $brands = Brand::orderBy("id","desc")->paginate(5);
        return view("admin.brands", compact("brands"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $brands = Brand::all();
        return view("admin.brands.create", compact("brands"));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rules =[
            "name"=> "required",
            "slug"=> "required|unique:brands,slug",
            "image"=>"mimes:png,jpg,jpeg|max:2048"
        ];

        $validator = Validator::make($request->all(), $rules);

        if(!empty($request->image)){
            $rules['image'] = 'image';
        }

        if ($validator->fails()){
            return redirect()->route('brands.create')->withErrors($validator)->withInput();
        }

        $brands = new Brand();
        $brands->name = $request->name;
        $brands->slug = Str::slug($request->name);
        $brands->save();

       
       //upload book image
       if(!empty($request->image)){
         //delete old image
            File::delete(public_path('uploads/brands/'.$brands->image));
            $image = $request->image;
            
            $ext =$image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move(public_path('/uploads/brands'), $imageName);
            
            $brands->image = $imageName;
            $brands->save();
       }

    
        return redirect()->route('brands.index')->with('success','Brand has added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $brands = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $brands = Brand::findOrFail($id);
        $rules =[
            "name"=> "required",
            "slug"=> "required|unique:brands,slug",
            "image"=>"mimes:png,jpg,jpeg|max:2048"
        ];

        $validator = Validator::make($request->all(), $rules);

        if(!empty($request->image)){
            $rules['image'] = 'image';
        }

        if ($validator->fails()){
            return redirect()->route('brands.edit',$brands->id)->withErrors($validator)->withInput();
        }

       //update
        $brands->name = $request->name;
        $brands->slug = Str::slug($request->slug);
        $brands->save();

        //For Image
        //upload book image
       if(!empty($request->image)){
        //delete old image
           File::delete(public_path('uploads/brands/'.$brands->image));
           $image = $request->image;
           
           $ext =$image->getClientOriginalExtension();
           $imageName = time().'.'.$ext;
           $image->move(public_path('/uploads/brands'), $imageName);
           
           $brands->image = $imageName;
           $brands->save();
      }

        return redirect()->route('brands.index')->with('success','Brand Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $brands = Brand::find($id);

        if (!$brands) {
            return redirect()->route('brands.index')->with('error', 'Brand not found.');
        }else{

            $brands->delete();
            return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
        }


    }
}
