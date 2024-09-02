@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title">Addresses</h2>

      <div class="row">
       @include('user.account-nav')
        <div class="col-lg-9">
          <div class="page-content my-account__address">
            <div class="row">
              @include('layouts.message')
              <div class="col-6">
                <p class="notice">The following addresses will be used on the checkout page by default.</p>
              </div>
              <div class="col-6 text-right">
                <a href="{{route('address.create')}}" class="btn btn-sm btn-info">Add New</a>
              
              </div>
            </div>
            <div class="my-account__address-list row">
              <h5>Shipping Address</h5>
                @foreach ($address as $adrs )
               
                <div class="my-account__address-item col-md-6">
                    <div class="my-account__address-item__title">
                      <h5>Name:  {{$adrs->name}} <i class="fa fa-check-circle text-success"></i></h5>
                      <a href="{{route('address.edit',$adrs->id)}}">Edit</a>
                      <form action="{{route('address.destroy',$adrs->id)}}" style="display:inline;" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger delete" onclick="return confirm('Are you Sure!! You want to delete')">
                         delete
                        </button>
                      </form>
                     
                    </div>
                    <div class="my-account__address-item__detail">
                      <p>Address-  {{$adrs->address}}</p>
                      <p>Locality-  {{$adrs->locality}}</p>
                      <p>City/Country-  {{$adrs->city}},{{$adrs->country}}</p>
                      <p>Landmark-  {{$adrs->landmark}}</p>
                      <p>Pincode-  {{$adrs->zip}}</p>
                      <br>
                      <p>Mobile-  {{$adrs->phone}}</p>
                    </div>
                  </div> 
                @endforeach
           
              <hr>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection