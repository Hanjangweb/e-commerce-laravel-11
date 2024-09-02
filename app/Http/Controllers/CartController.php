<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    //
    public function index()
    {
        $items = Cart::instance('cart')->content();

        foreach ($items as $item) {
            // Log item details to help debug
            \Log::info('Cart Item:', [
                'id' => $item->id,
                'name' => $item->name,
                'model' => $item->model ? 'Exists' : 'Null',
            ]);
        }

        return view('cart', compact('items'));
    }


    public function add_to_cart(Request $request)
    {
        // Add the product to the cart
        Cart::instance('cart')->add(
            $request->id,
            $request->name,
            $request->quantity,  // Correcting the order: quantity first, then price
            $request->price
        )->associate(Product::class);

        return redirect()->back()->with('success', 'Item Added Successfully');
    }

    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;

        // Ensure the quantity does not go below 1
        if ($qty < 1) {
            $qty = 1;
        }

        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    //revove item from cart
    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    //Apply Coupons
    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->coupon_code;

        if (isset($coupon_code)) {
            $coupons = Coupon::where('code', $coupon_code)
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', Cart::instance('cart')->subtotal())->first();

            if (!$coupons) {
                return redirect()->back()->with('error', 'Coupon Invalid Code');
            } else {
                Session::put('coupons', [
                    'code' => $coupons->code,
                    'type' => $coupons->code,
                    'value' => $coupons->value,
                    'cart_value' => $coupons->cart_value,
                ]);
                $this->CalculateDiscount();
                return redirect()->back()->with('success','Coupon has been applied');
            }
        }
    }

    //Calculate coupon  discount
    public function CalculateDiscount()
    {
        $discount = 0;
        if (Session::has('coupons')) {
            if (Session::get('coupons')['type'] == 'fixed') {
                $discount = Session::get('coupons')['value'];

            } else {
                $discount = (Cart::instance('cart')->subtotal() * Session::get('coupons')['value']) / 100;
            }

            $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
            $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
            $totalAfterDiscount = ($subtotalAfterDiscount + $taxAfterDiscount);


            Session::put('discounts', [
                'discount' => number_format(floatval($discount),2,'.',''),
                'subtotal' => number_format(floatval($subtotalAfterDiscount),2,'.',),
                'tax'=> number_format(floatval($taxAfterDiscount),2,'.',''),
                'total'=> number_format(floatval($totalAfterDiscount),2,'.','')

            ]);



        }

    }

    //removal of coupon
    public function remove_coupon_code(){
        Session::forget('coupons');
        Session::forget('discounts');
        return redirect()->back()->with('success','Coupon has been removed');
    }

    //checkout
    public function checkout()
    {
        // Check if the user is NOT authenticated
        if (!Auth::check()) {
            // Redirect to the login page if not authenticated
            return redirect()->route('login');
        }
    
        // Proceed to checkout if authenticated
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        return view('checkout', compact('address'));
    }
    
    //place an order
    public function place_an_order(Request $request){
        $user_id = Auth::user()->id;
        $address = Address::where('user_id',$user_id)->where('isdefault',true)->first();

        if(!$address)
        {
            $request->validate([
                'name'=> 'required|max:100',
                'phone'=> 'required|numeric|digits:10',
                'zip'=> 'required|numeric|digits:6',
                'state'=> 'required',
                'city'=> 'required|',
                'address'=> 'required',
                'locality'=> 'required',
                'landmark'=> 'required',
            ]);

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
        }
        $this->setAmountforCheckout();
        //order save
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = (float)str_replace(',', '', Session::get('checkout')['subtotal']);
        $order->discount = (float)Session::get('checkout')['discount'];
        $order->tax = (float)Session::get('checkout')['tax'];
        $order->total = (float)str_replace(',', '', Session::get('checkout')['total']);
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->save();
        

        //orderItem
        foreach(Cart::instance('cart')->content() as $item)
        {
        $orderItem = new OrderItem();
        $orderItem->product_id = $item->id;
        $orderItem->order_id = $order->id;
        $orderItem->price = $item->price;
        $orderItem->quantity = $item->qty;
        $orderItem->save();
        }

        if($request->mode == 'card')
        {
            //
        }
        else if($request->mode == 'paypal')
        {
            //
        }
        else if($request->mode == 'cod')
        {
            //transaction
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = 'pending';
            $transaction->save();
        }
        //destroy
        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('coupons');
        Session::forget('discounts');
        Session::put('order_id', $order->id);

        return redirect()->route('cart.order_confirmation');

    }

    //amount for check out
    public function setAmountforCheckout()
    {
        if(!Cart::instance('cart')->content()->count() > 0 ){
            Session::forget('checkout');
            return;
        }
        if(Session::has('coupons'))
        {
            Session::put('checkout',[
                'discount' => Session::get('discounts')['discount'],
                'subtotal'=> Session::get('discounts')['subtotal'],
                'tax'=> Session::get('discounts')['tax'],
                'total'=> Session::get('discounts')['total'],
            ]);
        }else
        {
            Session::put('checkout',[
                'discount'=> 0, 
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax'=> Cart::instance('cart')->tax(),
                'total'=> Cart::instance('cart')->total(),
            ]);
        }
    }

    //order Confirmed
    public function order_confirmation()
    {
        if(Session::has('order_id'))
        {
            $order = Order::find(Session::get('order_id'));
            return view('order-confirmation',compact('order'));
        }
        return redirect()->route('cart.index');
    }

}
