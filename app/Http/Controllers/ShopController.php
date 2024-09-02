<?php

namespace App\Http\Controllers;


use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //
    public function index(Request $request)
    {
        $size = $request->query("size", 10); // Default to 10 if size is not provided
    
        $o_column = "id"; // Default column to order by
        $o_order = "DESC"; // Default order direction
        $order = $request->query("order", -1);
        $f_brands = $request->query("brands");
        $f_categories = $request->query("categories");
        $searchText = $request->query("search_text", '');
        $min_price = $request->query('min') ? $request->query('min') : 1;
        $max_price = $request->query('max') ? $request->query('max') :500;
        switch ($order) {
            case 1:
                $o_column = 'created_at';
                $o_order = 'DESC';
                break;
            case 2:
                $o_column = 'created_at';
                $o_order = 'ASC';
                break;
            case 3:
                $o_column = 'regular_price';
                $o_order = 'ASC';
                break;
            case 4:
                $o_column = 'regular_price';
                $o_order = 'DESC';
                break;
            default:
                $o_column = 'id';
                $o_order = 'DESC';
                break;
        }
    
        // Ensure order direction is either 'asc' or 'desc'
        if (!in_array(strtolower($o_order), ['asc', 'desc'])) {
            $o_order = 'DESC'; // Default to DESC if invalid value found
        }
        $brands = Brand::orderBy('name','ASC')->get();
        $categories = Category::orderBy('name','ASC')->get();
        // $shops = Product::when($f_brands, function ($query) use ($f_brands) {
          
        //     $brandIds = explode(',', $f_brands);
        //     if (!empty($brandIds)) {
        //         $query->whereIn('brand_id', $brandIds);
        //     }
            
        // })->when($f_categories, function ($query) use ($f_categories) {
        //     $categoryId = explode(',', $f_categories);
        //     if (!empty($categoryId)) {
        //         $query->whereIn('category_id', $categoryId);
        //     }
        // })->when($min_price !== null && $max_price !== null, function ($query) use ($min_price, $max_price) {
        //     $query->whereBetween('regular_price', [$min_price, $max_price])
        //           ->orWhereBetween('sale_price', [$min_price, $max_price]);
        // })->when($searchText, function ($query) use ($searchText) {
        //     $query->where('name', 'LIKE', "%{$searchText}%");
        // })->orderBy($o_column, $o_order)->paginate($size);
       $shops = Product::orderBy('name','ASC')->paginate(10);
        return view("shop", compact("shops", "size", "order","brands","f_brands","searchText","categories","f_categories","min_price","max_price"));
    }
    
    //Product Details
    public function details($product_slug){

        $shops = Product::with('category','brand')->where("slug",$product_slug)->first();
        $products = Product::where("slug","<>",$product_slug)->get()->take(8);
        
       
        return view("details",compact("shops","products"));
    }
}
