@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="contact-us container">
            <div class="mw-930">
                <h2 class="page-title">CONTACT US</h2>
            </div>
        </section>

        <hr class="mt-2 text-secondary " />
        <div class="mb-4 pb-4"></div>

        <section class="contact-us container">
            @include('layouts.message')
            <div class="mw-930">
                <div class="contact-us__form">
                    <form name="contact-us-form" action="{{route('contact.store')}}" class="needs-validation" novalidate="" method="POST">
                        @csrf
                        <h3 class="mb-5">Get In Touch</h3>
                        <div class="form-floating my-4">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="name *">
                            <label for="contact_us_name">Full Name *</label>
                            <span class="text-danger"></span>
                            @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-floating my-4">
                            <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                placeholder="Phone *">
                            <label for="contact_us_name">Phone *</label>
                            <span class="text-danger"></span>
                            @error('phone')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-floating my-4">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                placeholder="Email address *">
                            <label for="contact_us_name">Email address *</label>
                            <span class="text-danger"></span>
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="my-4">
                            <textarea class="form-control form-control_gray" name="message" placeholder="Your Message" cols="30"
                                rows="8"></textarea>
                            <span class="text-danger"></span>
                        </div>
                        <div class="my-4">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
