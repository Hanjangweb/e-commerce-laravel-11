@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Account Details</h2>

            <div class="row">
                @include('user.account-nav')
               
                <div class="col-lg-9">
                   
                    <div class="page-content my-account__edit">
                        @include('layouts.message')
                        <h3>Personal Details</h3>
                        <div class="my-account__edit-form">
                            <form action="{{route('account.change_password')}}" method="POST" >
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" value="{{ $users->name }}">
                                            <label for="name">Full Name *</label>
                                            <span class="text-danger"></span>
                                            @error('name')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="tel" class="form-control @error('mobile') is-invalid @enderror"
                                                name="mobile" value="{{ $users->mobile }}">
                                            <label for="mobile">Mobile NUmber *</label>
                                            <span class="text-danger"></span>
                                            @error('mobile')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ $users->email }}">
                                            <label for="email">Email Address*</label>
                                            <span class="text-danger"></span>
                                            @error('email')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my-3">
                                            <h5 class="text-uppercase mb-0">Password Change</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating my-3">
                                            <input type="password"
                                                class="form-control  @error('old_password') is-invalid @enderror"
                                                id="old_password" name="old_password" value="{{ $users->password }}">
                                            <label for="old_password">Old password</label>
                                            @error('old_password')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating my-3">
                                            <input type="password"
                                                class="form-control  @error('new_password') is-invalid @enderror"
                                                id="new_password" name="new_password" placeholder="New password"
                                                value="{{ old('new_password') }}">
                                            <label for="account_new_password">New password</label>
                                            @error('new_password')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating my-3">
                                            <input type="password"
                                                class="form-control  @error('new_password_confirmation') is-invalid @enderror"
                                                cfpwd="" data-cf-pwd="#new_password" id="new_password_confirmation"
                                                name="new_password_confirmation" placeholder="Confirm new password">
                                            <label for="new_password_confirmation">Confirm new password</label>
                                            @error('new_password_confirmation')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                            <div class="invalid-feedback">Passwords did not match!</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my-3">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
