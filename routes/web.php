<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CookiesController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Auth::routes();

// Forgot Password
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Reset Password
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('shops', [ShopController::class,'index'])->name('shops.index');

Route::get('/shops/{product_slug}', [ShopController::class, 'details'])->name('shops.details');


//Cart Route
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class,'add_to_cart'])->name('cart.add');
Route::put('cart/increase-quantity/{rowId}', [CartController::class,'increase_cart_quantity'])->name('cart.qty.increase');
Route::put('cart/decrease-quantity/{rowId}', [CartController::class,'decrease_cart_quantity'])->name('cart.qty.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class,'remove_item'])->name('cart.item.remove');
Route::delete('/cart/clear', [CartController::class,'empty_cart'])->name('cart.empty');


//wishlist
Route::get('/wishlist', [WishlistController::class,'index'])->name('wishlist.index');
Route::post('/wishlist/add', [WishlistController::class,'add_to_wishlist'])->name('wishlist.add');
Route::delete('/wishlist/remove/{rowId}', [WishlistController::class,'remove_wishlist'])->name('wishlist.item.remove');
Route::delete('/wishlist/clear', [WishlistController::class,'empty_wishlist'])->name('wishlist.empty');
Route::post('wishlist/move_to_cart/{rowId}', [WishlistController::class, 'move_to_cart'])->name('wishlist.move_to_cart');

//Coupon Apply
Route::post('cart/apply-coupon', [CartController::class,'apply_coupon_code'])->name('cart.apply_coupon_code');
Route::delete('cart/remove-coupon', [CartController::class,'remove_coupon_code'])->name('cart.remove_coupon_code');

//checkout
Route::post('/place_an_order', [CartController::class,'place_an_order'])->name('cart.place_an_order');
Route::get('/order-confirmation', [CartController::class,'order_confirmation'])->name('cart.order_confirmation');

//contact us
Route::get('/contact', [UserController::class,'contact_form'])->name('contact');
Route::post('/contact-add',[UserController::class,'contact_store'])->name('contact.store');

//Cookies 
Route::get('/set-cookie', [CookiesController::class,'setCookie']);
Route::get('/get-cookie', [CookiesController::class,'getCookie']);
Route::get('/delete-cookie', [CookiesController::class,'deleteCookie']);

// User Route
Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
    Route::get('/checkout', [CartController::class,'checkout'])->name('cart.checkout');
    Route::resource('address', AddressController::class);
    Route::get('/orders', [UserController::class,'orders'])->name('user.orders');
    Route::get('/account-setting', [UserController::class,'personal_details'])->name('account.details');
    Route::get('/orders-detail/{order_id}', [UserController::class,'order_details'])->name('order.order-details');
    Route::patch('/password-update', [UserController::class,'change_password'])->name('account.change_password');

});


// Admin Route
Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::prefix('admin')->group(function () {
        Route::resource('brands', BrandController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('product', ProductController::class);
        Route::resource('coupon', CouponController::class);
        Route::get('/orders', [AdminController::class,'orders'])->name('admin.orders');
        Route::get('/orders-details/{order_id}', [AdminController::class,'order_details'])->name('admin.orders-details');
        Route::get('/setting', [AdminController::class,'admin_setting'])->name('admin.setting');
        Route::get('/user', [AdminController::class,'admin_user'])->name('admin.user');
        Route::patch('/profile/update', [AdminController::class, 'profile_update'])->name('admin.profile.update');

    });
});


//logout user
Route::post('/logout',function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

