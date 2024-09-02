@extends('layouts.admin')
@section('content')
<div class="main-content">
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                @include('layouts.message')
                <h3>Categories infomation</h3>
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
                        <a href="{{route('brands.index')}}">
                            <div class="text-tiny">Categories</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{route('category.create')}}">
                          <div class="text-tiny">New Category</div>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{route('category.store')}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow  @error('name') is-invalid @enderror" type="text" placeholder="Category name" name="name"
                            tabindex="0" value="{{old('name')}}" aria-required="true" >
                            @error('name')
                               <p class= "invalid-feedback">{{$message}}</p>
                            @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Category Slug <span class="tf-color-1">*</span></div>
                        <input class="flex-grow @error('slug') is-invalid @enderror" type="text" placeholder="Brand Slug" name="slug"
                            tabindex="0" value="{{old('slug')}}" aria-required="true" >
                            @error('slug')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                    </fieldset>
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display:none">
                                <img src="" class="effect8" alt="">
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile @error('image') is-invalid @enderror" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span
                                            class="tf-color">click to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                        @error('image')
                            <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </fieldset>

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="bottom-page">
        <div class="body-text">Copyright © 2024 hanjangweb</div>
    </div>
</div>
@endsection
@push('script')
    <script>
        $(function(){
            $("#myFile").on("change",function(e){
                const photoInp =$('#myFile');
                const [file] = this.files;
                if(file){
                    $("#imgpreview img").attr('src',URL,createObjectURL(file));
                    $("#imgpreview").show();
                }
            });
            $("input[name= 'name']").on("change",function(){
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });
        });
        function StringToSlug(text){
            return text.toLowerCase()
            .replace(/[^\w]+/g,"")
            .replace(/ +/g,"-");
        }
    </script>
@endpush