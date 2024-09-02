<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //
        $categories = Category::orderBy("id","desc")->paginate(5);
        return view("admin.category.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("admin.category.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rules = [
            "name"=> "required",
            "slug"=> "required|unique:brands,slug",
            "image"=> "mimes:png,jpg,jpeg|max:2048",
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return redirect()->route('category.create')->withErrors($validator)->withInput();
        }

        if(!empty($request->image)){
            $rules['image'] = 'image';
        }

        $categories = new Category();
        $categories->name = $request->name;
        $categories->slug = Str::Slug($request->slug);
        $categories->save();

        //upload image
        if(!empty($request->image)){
            //delete folder
            File::delete(public_path('uploads/category/'.$request->image));

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move(public_path('/uploads/category/').$imageName);
            $categories->image = $imageName;
            dd($categories->image);
            $categories->save();
        }

        return redirect()->route('category.index')->with('success','Your"re  Categories Added Successfuly');

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
        $categories = Category::find($id);
        return view('admin.category.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $categories = Category::findOrFail($id);
        $rules = [
            "name"=> "required",
            "slug"=> "required|unique:brands,slug",
            "image"=> "mimes:png,jpg,jpeg|max:2048",
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return redirect()->route('category.edit')->withErrors($validator)->withInput();
        }

        if(!empty($request->image)){
            $rules['image'] = 'image';
        }

        $categories->name = $request->name;
        $categories->slug = Str::Slug($request->slug);
        $categories->save();

        //upload image
        // Check if there is a new image being uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if (!empty($categories->image) && File::exists(public_path('uploads/category/'.$categories->image))) {
                File::delete(public_path('uploads/category/'.$categories->image));
            }

            // Get the new image and its extension
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;

            // Move the new image to the desired location
            $image->move(public_path('uploads/category'), $imageName);
            
            // Save the new image name in the database
            $categories->image = $imageName;
            $categories->save();
        }

        return redirect()->route('category.index')->with('success','Updated  Categories  Successfuly');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $categories = Category::findOrFail($id);
        File::delete(public_path('uploads/category/'.$id));
        if(!$categories){
            return redirect()->route('category.index')->with('error','Categories Not Found');
        }else{
            $categories->delete();
            return redirect()->route('category.index')->with('success','Deleted Successfully');
        }
    }
}
