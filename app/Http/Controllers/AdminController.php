<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    public function index(){
        return view("admin.index");
    }

    public function orders(){
        $orders = Order::orderBy("created_at","asc")->paginate(10);
        return view("admin.orders.show",compact("orders"));
    }

    public function order_details(string $order_id){
        $orders = Order::findOrFail($order_id);
        $orderItems = OrderItem::where("order_id",$order_id)->orderBy('id')->paginate(10);
        $transaction = Transaction::where("order_id", $order_id)->first();
        return view("admin.orders.show-details",compact("orders","orderItems","transaction"));
    }
    public function admin_setting(){
        $admin_setting = Auth::user();
        return view("admin.setting.index",compact("admin_setting"));
         
    }

    public function profile_update(Request $request)
    {
        $admin = User::findOrFail(Auth::user()->id);
       
     
        $rules = [
            "name" => "required|string|max:255",
            "email" => "required|email",
            "mobile" => "required|string|max:15",
            "old_password" => "required_with:new_password|current_password", // Ensure this validation matches your needs
            "new_password" => "nullable|confirmed|min:6",
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
           return redirect()->back()->withErrors($validator)->withInput();
        }
    
        
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->mobile = $request->mobile;
    
        if ($request->filled('new_password')) {
            $admin->password = Hash::make($request->new_password);
        }
    
        $admin->save();
    
        return redirect()->route('admin.setting')->with('success','Updated successfully');
    }
    

    public function admin_user()
    {
        $admin_user = Auth::user();
        
        // Fetch only users who are not admins and eager load their orders
        $users = User::where('role', '1')
                     ->with('orders')
                     ->orderBy('id', 'asc')
                     ->paginate(10);
        
        // Debugging output to see what users are being fetched
        if ($users->isEmpty()) {
            dd("No users found with role 'user'.", $users);
        }
        
        return view("admin.users.index", compact("users"));
    }
    
    
    
    

}
