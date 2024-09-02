<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function index(){
        return view("user.index");
    }

    //orders
    public function orders(){
        $orders = Order::orderBy("created_at","asc")->paginate(10);
        return view("user.orders.index",compact("orders"));
    }

    public function order_details($order_id){
        $orders = Order::find($order_id);
        return view("user.orders.order-details",compact("orders"));
    }

    //personal setting
    public function personal_details(){
        $users = Auth::user();
        
        return view("user.account-detail.detail",compact("users"));
    }

    //change password
    public function change_password(Request $request){

        $users = User::find(Auth::user()->id);
        $rules = [
            "email" => "required|email",
            "old_password" => "required_with:new_password|current_password",
            "new_password" =>"nullable|confirmed|min:6",
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $users->name = $request->name;
        $users->mobile = $request->mobile;
        $users->email = $request->email;
        if($request->filled("new_password")){
            $users->password = Hash::make($request->new_password);
        }
        $users->save();

        return redirect()->route('account.details')->with("success","Updated Successfully");
        

    }

    //contact
    public function contact_form(){
        return view("contact_form");
    }
   
    public function contact_store(Request $request){
      
        $rules =[
            "name" => "required",
            "phone" => "required|numeric:12",
            "email"=> "required|email",

        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $contacts = new Contact();
        $contacts->name = $request->name;
        $contacts->phone = $request->phone;
        $contacts->email = $request->email;
        $contacts->message = $request->message;
        $contacts->save();

        return redirect()->route('contact')->with("success","Submitted Successfuly. Will Contact YOu Shortly!!");
    }
}
