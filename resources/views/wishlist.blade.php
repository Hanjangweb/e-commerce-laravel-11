@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Wishlist</h2>
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
              @foreach ($items as $item )
              <tr>
                <td>
                  <div class="shopping-cart__product-item">
                    <a href="{{route('shops.details',['product_slug'=>$item->model->slug])}}">
                      <img loading="lazy" src="{{asset('uploads/products/')}}/{{$item->model->image}}" width="120" height="120" alt="{{$item->name}}" />
                    </a>
                  
                  </div>
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
                  {{$item->qty}}<!-- .qty-control -->
                </td>
                <td>
                  <span class="shopping-cart__subtotal">$297</span>
                </td>
                <td>
                  <div class="row">
                    <div class="col-6">
                      <form action="{{ route('wishlist.move_to_cart', ['rowId' => $item->rowId]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning">Move to Cart</button>
                      </form>
                    </div>
                    
                  
                    <div class="col-6">
                      <form action="{{ route('wishlist.item.remove', ['rowId' => $item->rowId]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <a href="javascript:void(0)" class="remove-cart" onclick="this.closest('form').submit();">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                            </svg>
                        </a>
                      </form>
                    </div>
                  </div>
                
                </td>
              </tr>
              @endforeach
             
            
            </tbody>
          </table>
           
          <div class="cart-table-footer">
            <form action="{{route('wishlist.empty')}}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-light">CLEAR CART</button>
          </form>
          </div>
        </div>
        @else
          <div class="row">
            <div class="col md-12">
              <div class="col md-12 text-centre pt-5 bp-5">
                <p>No Items Found In your Card</p>
                <a href="{{route('shops.index')}}" class="btn btn-info">Wishlist Now</a>
              </div>
            </div>     
          </div>
        @endif
      </div>
    </section>
  </main>
@endsection