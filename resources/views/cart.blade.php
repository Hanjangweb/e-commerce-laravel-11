@extends('layouts.app')
@section('content')

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
       <h2 class="page-title">Cart</h2>
       @include('layouts.message')
        <div class="shopping-cart">
            @if ($items->count()>0)
            <div class="cart-table__wrapper">
                <table class="cart-table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th></th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    
                        @foreach ( $items as $item)

                    
                        <tr>
                        
                            <td>
                                @if($item->model)
                                    <img loading="lazy" src="{{ asset('uploads/products/' . $item->model->image) }}" width="120" height="120" alt="{{ $item->name }}" />
                                @else
                                    <p>Product not found</p>
                                @endif
                            </td>
                            <td>
                            <div class="shopping-cart__product-item__detail">
                                <h4>{{$item->name}}</h4>
                            
                                <ul class="shopping-cart__product-item__options">
                                <li>Color: Yellow</li>
                                <li>Size: L</li>
                                </ul>
                            </div>
                            </td>
                        
                            <td>
                            <span class="shopping-cart__product-price">{{$item->price}}</span>
                            </td>
                            <td>
                            <div class="qty-control position-relative">
                            <input type="number" name="quantity" value="{{$item->qty}}" min="1" class="qty-control__number text-center">
                                <form action="{{route('cart.qty.decrease',['rowId'=>$item->rowId])}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="qty-control__reduce">-</div>
                                </form>
                                
                                <form action="{{route('cart.qty.increase',['rowId'=>$item->rowId])}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="qty-control__increase">+</div>
                                </form>
                                
                            </div>
                            </td>
                            <td>
                            <span class="shopping-cart__subtotal">{{$item->subTotal()}}</span>
                            </td>
                            <td>
                                <form action="{{ route('cart.item.remove', ['rowId' => $item->rowId]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:void(0)" class="remove-cart" onclick="this.closest('form').submit();">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                            <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                        </svg>
                                    </a>
                                </form>
                            
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
          
                <div class="cart-table-footer">
                    @if (!Session::has('coupons'))
                        <form action="{{route('cart.apply_coupon_code')}}" method="POST" class="position-relative bg-body">
                            @csrf
                            <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code" value="">
                            <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                                value="APPLY COUPON">
                        </form>
                    @else
                        <form action="{{route('cart.remove_coupon_code')}}" method="POST" class="position-relative bg-body">
                            @csrf
                            @method('DELETE')
                            <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code" value="@if(Session::has('coupons')) {{Session::get('coupons')['code']}}   Applied! @endif">
                            <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                                value="REMOVE COUPON">
                        </form>
                    @endif
                  
                   
                    <form action="{{route('cart.empty')}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-light">CLEAR CART</button>
                    </form>
                   
                </div> 
             
            </div>
   
          
            <div class="shopping-cart__totals-wrapper">
            <div class="sticky-content">
                <div class="shopping-cart__totals">
                <h3>Cart Totals</h3>
                @if (Session::has('discounts'))
                <table class="cart-totals">
                    <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>{{ Cart::instance('cart')->subTotal() }}</td>
                        </tr>
                        <tr>
                            <th>Discount {{ Session::get('coupons')['code'] ?? '' }}</th>
                            <td>{{ Session::get('discounts')['discount'] ?? '0.00' }}</td>
                        </tr>
                        <tr>
                            <th>Subtotal After Discount</th>
                            <td>{{ Session::get('discounts')['subtotal'] ?? Cart::instance('cart')->subTotal() }}</td>
                        </tr>
                        <tr>
                            <th>Shipping</th>
                            <td>Free</td>
                        </tr>
                        <tr>
                            <th>VAT</th>
                            <td>{{ Session::get('discounts')['tax'] ?? '0.00' }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>{{ Session::get('discounts')['total'] ?? Cart::instance('cart')->total() }}</td>
                        </tr>
                    </tbody>
                </table>
                @else
                <table class="cart-totals">
                    <tbody>
                    <tr>
                        <th>Subtotal</th>
                        <td>{{Cart::instance('cart')->subTotal()}}</td>
                    </tr>
                    <tr>
                        <th>Shipping</th>
                        <td>Free</td>
                    </tr>
                    <tr>
                        <th>VAT</th>
                        <td>{{Cart::instance('cart')->tax()}}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>{{Cart::instance('cart')->total()}}</td>
                    </tr>
                    </tbody>
                </table>
                @endif
                
                </div>
                <div class="mobile_fixed-btn_wrapper">
                <div class="button-wrapper container">
                    <a href="{{route('cart.checkout')}}" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
                </div>
                </div>
            </div>
            </div>
            @else
                <div class="row">
                    <div class="col md-12 text-centre pt-5 bp-5">
                        <p>No Items Found In your Card</p>
                        <a href="{{route('shops.index')}}" class="btn btn-info">Shop Now</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>
@endsection

{{-- javascript --}}
@push('script')
    <script>
        $(function(){
            $('.qty-control__increase').on("click",function(){
                $(this).closest('form').submit();
            });

            $('.qty-control__reduce').on("click",function(){
                $(this).closest('form').submit();
            });

            $('.remove-cart').on("click",function(){
                $(this).closest('form').submit();
            });
        })
    </script>
@endpush