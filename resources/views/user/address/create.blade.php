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
                            <div class="col-6">
                                <p class="notice">The following addresses will be used on the checkout page by default.</p>
                            </div>
                            <div class="col-6 text-right">
                                @include('layouts.message')
                            </div>
                        </div>
                        <div class="row mt-5">
                            <form action="{{ route('address.store') }}" method="POST">
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}">
                                        <label for="name">Full Name *</label>
                                        <span class="text-danger"></span>
                                        @error('name')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            name="phone" value="{{ old('phone') }}">
                                        <label for="phone">Phone Number *</label>
                                        <span class="text-danger"></span>
                                        @error('phone')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control @error('zip') is-invalid @enderror"
                                            name="zip" value="{{ old('zip') }}">
                                        <label for="zip">Pincode *</label>
                                        <span class="text-danger"></span>
                                        @error('zip')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control @error('state') is-invalid @enderror"
                                            name="state" value="{{ old('state') }}">
                                        <label for="state">State *</label>
                                        <span class="text-danger"></span>
                                        @error('state')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                                            name="city" value="{{ old('city') }}">
                                        <label for="city">Town / City *</label>
                                        <span class="text-danger"></span>
                                        @error('city')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control @error('country') is-invalid @enderror"
                                            name="country" value="{{ old('country') }}">
                                        <label for="city">Country *</label>
                                        <span class="text-danger"></span>
                                        @error('country')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                            name="address" value="{{ old('address') }}">
                                        <label for="address">House no, Building Name *</label>
                                        <span class="text-danger"></span>
                                        @error('address')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control @error('locality') is-invalid @enderror"
                                            name="locality" value="{{ old('locality') }}">
                                        <label for="locality">Road Name, Area, Colony *</label>
                                        <span class="text-danger"></span>
                                        @error('locality')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control @error('landmark') is-invalid @enderror"
                                            name="landmark" value="{{ old('landmark') }}">
                                        <label for="landmark">Landmark *</label>
                                        <span class="text-danger"></span>
                                        @error('landmark')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" name="submit" class="btn btn-secondary">Submit</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
