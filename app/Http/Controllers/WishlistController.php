<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
    //
    
    public function index(){

        $items = Cart::instance('wishlist')->content();
       
        return view('wishlist',compact('items'));
    }
 
    public function add_to_wishlist(Request $request)
    {
       
    Cart::instance('wishlist')->add(
        $request->id,
        $request->name,
        $request->price,
        $request->quantity,
       
    )->associate(Product::class);

    return redirect()->back();
    }

    //remove public function remove_wishlist($rowId)
    public function remove_wishlist($rowId)
    {
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back()->with('success', 'Item removed from wishlist!');
    }

    //empty Wishlist
    public function empty_wishlist(){
        Cart::instance('wishlist')->destroy();
        return redirect()->back()->with('success', 'Item Clear from wishlist!');
    }

    //move to Card
    public function move_to_cart(Request $request, $rowId)
    {
        // Logic to move item to cart
        $item = Cart::instance('wishlist')->get($rowId);
        Cart::instance('wishlist')->remove($rowId);
        Cart::instance('cart')->add($item->id, $item->name,$item->price, $item->qty)->associate(Product::class);
    
        return redirect()->back()->with('success', 'Item moved to cart!');
    }
    
}
