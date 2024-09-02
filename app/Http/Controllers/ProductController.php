<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Laravel\Facades\Image;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::with('category','brand')->orderBy("id","asc")->paginate(10);
       
     
        return view("admin.product.index", compact("products"));
    }  

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::all();
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get();
        return view("admin.product.create", compact("products","categories","brands"));

    }

    /**
     * Store a newly created resource in storage.
     */
   
    
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'SKU' => 'required|string|max:255',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'boolean',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
        ]);
    
        // Store the product in the database
        $products = new Product();
        $products->name = $request->name;
        $products->slug = Str::slug($request->slug);
        $products->short_description = $request->short_description;
        $products->description = $request->description;
        $products->regular_price = $request->regular_price;
        $products->sale_price = $request->sale_price;
        $products->SKU = $request->SKU;
        $products->stock_status = $request->stock_status;
        $products->featured = $request->featured ?? false;
        $products->quantity = $request->quantity;
        $products->category_id = $request->category_id; // Ensure this is set
        $products->brand_id = $request->brand_id; // Ensure this is set
    
        $current_timestamp = Carbon::now()->timestamp;
    
        // Handle main image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp.'.'.$image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $products->image = $imageName;
        }
    
        // Handle gallery images
        $gallery_arr = [];
        $gallery_images = "";
        $counter = 1;
    
        if ($request->hasFile('images')) {
            $allowfileExtion = ['jpg', 'jpeg', 'png'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                if (in_array($gextension, $allowfileExtion)) {
                    $gfileName = $current_timestamp."-".$counter.".".$gextension;
                    $this->GenerateProductThumbnailImage($file, $gfileName);
                    $gallery_arr[] = $gfileName;
                    $counter++;
                }
            }
            $gallery_images = implode(",", $gallery_arr);
        }
    
        $products->images = $gallery_images;
        $products->save();
    
        return redirect()->route('product.index')->with("success", "Product Has been added Successfully");
    }

    //
    public function GenerateProductThumbnailImage($image, $imageName)
    {
        // Ensure directories exist
        $destinationPath = public_path('uploads/products');
        $destinationPathThumbnail = public_path('uploads/products/thumbnail');
    
        // Create the directories if they don't exist
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }
    
        if (!File::exists($destinationPathThumbnail)) {
            File::makeDirectory($destinationPathThumbnail, 0777, true, true);
        }
  

       // Path to your image file
        $imagePath = $image->path(); // Replace with actual path

        // Process the main image
        $img = Image::read($imagePath); // Create an instance
        $img->resize(540, 658, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($destinationPath.'/'.$imageName);
                
        

        // Process the thumbnail image
        $img = Image::read($image->path()); // Recreate the instance for the thumbnail
        $img->resize(104, 104, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->crop(104, 104)->save($destinationPathThumbnail.'/'.$imageName);
        

    }
    
    
    // public function GenerateProductThumbnailImage($image, $imageName)
    // {
    //     // Ensure directories exist
    //     $destinationPath = public_path('uploads/products');
    //     $destinationPathThumnail = public_path('uploads/products/thumbnail');
    
    //     if (!File::exists($destinationPath)) {
    //         File::makeDirectory($destinationPath, 0777, true, true);
    //     }
    
    //     if (!File::exists($destinationPathThumnail)) {
    //         File::makeDirectory($destinationPathThumnail, 0777, true, true);
    //     }
    
    //     $img = Image::read($image->path());
       
    //    // Resize main image while maintaining aspect ratio
    //     $img->resize(540, 658, function ($constraint) {
    //         $constraint->aspectRatio();
    //         $constraint->upsize();
    //     })->save($destinationPath.'/'.$imageName);

    //     // Resize and crop thumbnail image
    //     $img = Image::read($image->path()); // Recreate the instance for the thumbnail
    //     $img->resize(104, 104, function ($constraint) {
    //         $constraint->aspectRatio();
    //         $constraint->upsize();
    //     })->crop(104, 104)->save($destinationPathThumnail.'/'.$imageName);
    // }
    

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
        $products = Product::findOrFail($id);
        $categories = Category::select('id','name')->orderBy('name')->get();
        $brands = Brand::select('id','name')->orderBy('name')->get();

        return view('admin.product.edit', compact('products','categories','brands'));

         
    
     
    
      

    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $products = Product::findOrFail($id);
       
         // Validate the request data
         $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'SKU' => 'required|string|max:255',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'boolean',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
        ]);
       
        // Update the product in the database
        $products->name = $request->name;
        $products->slug = Str::slug($request->slug);
        $products->short_description = $request->short_description;
        $products->description = $request->description;
        $products->regular_price = $request->regular_price;
        $products->sale_price = $request->sale_price;
        $products->SKU = $request->SKU;
        $products->stock_status = $request->stock_status;
        $products->featured = $request->featured ?? false;
        $products->quantity = $request->quantity;
        $products->category_id = $request->category_id; // Ensure this is set
        $products->brand_id = $request->brand_id; // Ensure this is set
    
        $current_timestamp = Carbon::now()->timestamp;

         // Handle main image
         if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp.'.'.$image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $products->image = $imageName;
        }
    
        // Handle gallery images
        $gallery_arr = [];
        $gallery_images = "";
        $counter = 1;
    
        if ($request->hasFile('images')) {
            $allowfileExtion = ['jpg', 'jpeg', 'png'];
            $files = $request->file('images');
            foreach ($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                if (in_array($gextension, $allowfileExtion)) {
                    $gfileName = $current_timestamp."-".$counter.".".$gextension;
                    $this->GenerateProductThumbnailImage($file, $gfileName);
                    $gallery_arr[] = $gfileName;
                    $counter++;
                }
            }
            $gallery_images = implode(",", $gallery_arr);
        }
    
        $products->images = $gallery_images;
        $products->save();

        return redirect()->route("product.index")->with("success","Updated Product Successfull");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
