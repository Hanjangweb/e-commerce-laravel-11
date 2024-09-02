<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $address = Address::orderBy("id","asc")->paginate(10);
        return view("user.address.index", compact("address"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $address = Address::all();
        return view("user.address.create", compact("address"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user_id = Auth::user()->id;
       
        $rules=[
            'name'=> 'required|max:100',
            'phone'=> 'required|numeric|digits:10',
            'zip'=> 'required|numeric|digits:6',
            'state'=> 'required',
            'city'=> 'required|',
            'address'=> 'required',
            'locality'=> 'required',
            'landmark'=> 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
       
        $address = new Address();
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->state = $request->state;
        $address->zip = $request->zip;
        $address->country = $request->country;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->user_id = $user_id;
        $address->isdefault = true;
        $address->save();

        return redirect()->route('address.index')->with('success','Address Save Successfully');
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
        $address = Address::findOrFail($id);
        return view('user.address.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user_id = Auth::user()->id;
        $address = Address::findOrFail($id);
        $rules=[
            'name'=> 'required|max:100',
            'phone'=> 'required|numeric|digits:10',
            'zip'=> 'required|numeric|digits:6',
            'state'=> 'required',
            'city'=> 'required|',
            'address'=> 'required',
            'locality'=> 'required',
            'landmark'=> 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
       
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->state = $request->state;
        $address->zip = $request->zip;
        $address->country = $request->country;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->user_id = $user_id;
        $address->isdefault = true;
        $address->save();

        return redirect()->route('address.index')->with('success','Address Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $address = Address::findOrFail($id);

        if(!$address){
            return redirect()->route('address.index')->with('error','Address not found');
        }else{
            $address->delete();
            return redirect()->route('address.index')->with('success','Deleted Successfully');
        }
    }
}
