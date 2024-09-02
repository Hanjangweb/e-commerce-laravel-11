@extends('layouts.admin')
@section('content')
<div class="main-content">

    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                @include('layouts.message') 
                <h3>Update Product</h3>
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
                        <a href="{{route('product.index')}}">
                            <div class="text-tiny">Products</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Add product</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form action="{{route('product.update',$products->id)}}" class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- or @method('PATCH') -->

                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10  @error('name') is-invalid  @enderror">Product name <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter product name"
                            name="name" tabindex="0" value="{{$products->name}}" aria-required="true" >
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                            @error('name')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug"
                            name="slug" tabindex="0" value="{{$products->slug}}" aria-required="true" >
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                            @error('name')
                            <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </fieldset>

                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                            </div>
                            <div class="select">
                                <select class="" name="category_id">
                                    <option>Choose category</option>
                                    @foreach ($categories as $category )
                                         <option value="{{$category->id}}" {{$products->category_id == $category->id ? "selected":""}}>{{$category->name}}

                                         </option>
                                    @endforeach
                            
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="brand">
                            <div class="body-title mb-10">Brand <span class="tf-color-1">*</span>
                            </div>
                            <div class="select">
                                <select class="" name="brand_id">
                                    <option>Choose Brand</option>
                                    @foreach ($brands as $brand )
                                       <option value="{{$brand->id}}" {{$products->brand_id == $brand->id ? "selected":""}}>{{$brand->name}}</option>
                                    @endforeach
                                  
                                </select>
                            </div>
                        </fieldset>
                    </div>

                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span
                                class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description"
                            placeholder="Short Description" tabindex="0" aria-required="true">{{$products->short_description}}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                            @error('short_description')
                              <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                    </fieldset>

                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                        </div>
                        <textarea class="mb-10 @error('description') is-invalid @enderror" name="description" placeholder="Description"
                            tabindex="0" aria-required="true" >{{$products->description}}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                            @error('description')
                               <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                    </fieldset>
                </div>
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview">
                                @if ($products->image)
                                    <img src="{{ asset('uploads/products/' . $products->image) }}" alt="{{ $products->name }}" class="effect8">
                                @else
                                    <img src="{{asset('path/to/default-image.jpg')}} class="effect8" alt="No Image available">
                                @endif
                              
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span
                                            class="tf-color">click to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Upload Gallery Images</div>
                        <div class="upload-image mb-16">
                                @if ($products->images)
                                    @foreach (explode(',', $products->images) as $img )
                                    <div class="item">
                                        <img src="{{ asset('uploads/products/') }}/{{trim($img)}}" alt="{{ $products->name }}" class="effect8">
                                     
                                    </div> 
                                    @endforeach    
                                @else
                                <img src="{{asset('path/to/default-image.jpg')}} class="effect8" alt="No Image available">
                                @endif                                             -->
                            <div id="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Drop your images here or select <span
                                            class="tf-color">click to browse</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*"
                                        multiple="">
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Regular Price <span
                                    class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter regular price"
                                name="regular_price" tabindex="0" value="{{$products->regular_price}}" >
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Sale Price <span
                                    class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter sale price"
                                name="sale_price" tabindex="0" value="{{$products->sale_price}}">
                        </fieldset>
                    </div>


                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU"
                                tabindex="0" value="{{$products->SKU}}" >
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter quantity"
                                name="quantity" tabindex="0" value="{{$products->quantity}}" >
                               
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status">
                                    <option value="instock" {{$products->stock_status == "instock" ? "selected":""}}>InStock</option>
                                    <option value="outofstock" {{$products->stock_status == "outofstock" ? "selected":""}}>Out of Stock</option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Featured</div>
                            <div class="select mb-10">
                                <select class="" name="featured">
                                    <option value="0" {{$products->featured == "0" ? "selected":""}}>No</option>
                                    <option value="1" {{$products->featured == "1" ? "selected":""}}>Yes</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Update Product</button>
                    </div>
                </div>
            </form>
            <!-- /form-add-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    <!-- /main-content-wrap -->

    <div class="bottom-page">
        <div class="body-text">Copyright © 2024 Hanjangweb</div>
    </div>
</div>
@endsection