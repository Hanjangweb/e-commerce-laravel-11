<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $coupons = Coupon::orderBy("expiry_date","desc")->paginate(10);
        return view("admin.coupons.index", compact("coupons"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $coupons = Coupon::all();
        return view("admin.coupons.create", compact("coupons"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         $request->validate([
            "code"=> "required",
            "value"=> "required|numeric",
            "cart_value" => "required|numeric",

         ]);
         $coupons = new Coupon();
         $coupons->code = $request->code;
         $coupons->type = $request->type;
         $coupons->value = $request->value;
         $coupons->cart_value = $request->cart_value;
         $coupons->expiry_date = $request->expiry_date;
         $coupons->save();

         return redirect()->route('coupon.index')->with("success","Coupon Added Successfully");
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
        $coupons = Coupon::findOrFail($id);
        return view("admin.coupons.edit", compact("coupons"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            "code"=> "required",
            "value"=> "required|numeric",
            "cart_value" => "required|numeric",

         ]);
         $coupons = Coupon::findOrFail($id);
         $coupons->code = $request->code;
         $coupons->type = $request->type;
         $coupons->value = $request->value;
         $coupons->cart_value = $request->cart_value;
         $coupons->expiry_date = $request->expiry_date;
         $coupons->save();

         return redirect()->route('coupon.index')->with("success","Coupon Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $coupons = Coupon::findOrFail($id);
        $coupons->delete();
        return redirect()->route('coupon.index')->with("success","Deleted Successfully");
    }
}
