@extends('layouts.admin')
@section('content')
<div class="main-content">
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Coupon Update infomation</h3>
                @include('layouts.message')
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('admin.index')}}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{route('coupon.index')}}">
                            <div class="text-tiny">Coupons</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{route('coupon.create')}}">
                            <div class="text-tiny"> New Coupons</div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="wg-box">
                <form class="form-new-product form-style-1" method="POST" action="{{route('coupon.update',$coupons->id)}}">
                    @csrf
                    @method('PATCH')
                    <fieldset class="name">
                        <div class="body-title">Coupon Code <span class="tf-color-1">*</span></div>
                        <input class="flex-grow @error('code') is-invalid  @enderror" type="text" placeholder="Coupon Code" name="code"
                            tabindex="0" value="{{$coupons->code}}" aria-required="true"  >
                            @error('code')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                    </fieldset>
                    <fieldset class="category">
                        <div class="body-title">Coupon Type</div>
                        <div class="select flex-grow">
                            <select class="" name="type">
                                <option value="0" {{old('type',$coupons->type ?? '') == '0' ? 'selected': ''}}>Select</option>
                                <option value="fixed" {{old('type',$coupons->type ?? '') == 'fixed'  ? 'selected': ''}}>Fixed</option>
                                <option value="percent" {{old('type', $coupons->type ?? '') == 'percent' ? 'selected' : ''}}>Percent</option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Value <span class="tf-color-1">*</span></div>
                        <input class="flex-grow @error('value') is-invalid @enderror" type="text" placeholder="Coupon Value" name="value"
                            tabindex="0" value="{{$coupons->value}}" aria-required="true" >
                            @error('value')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Cart Value <span class="tf-color-1">*</span></div>
                        <input class="flex-grow @error('cart_value') is-invalid @enderror" type="text" placeholder="Cart Value"
                            name="cart_value" tabindex="0" value="{{$coupons->cart_value}}" aria-required="true">
                            @error('cart_value')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Expiry Date <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="date" placeholder="Expiry Date"
                            name="expiry_date" tabindex="0" value="{{$coupons->expiry_date}}" aria-required="true">
                    </fieldset>

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit" name="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bottom-page">
        <div class="body-text">Copyright © 2024 Hanjangweb</div>
    </div>
</div>
@endsection