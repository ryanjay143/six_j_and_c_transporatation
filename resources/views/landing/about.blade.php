@extends('layouts.landing.about')
    @section('content')

        <div class="bg-image">
            <img src="{{ asset('images/truck.jpg') }}" class="img-fluid w-100" style="max-width: 100%; height: 50vh;" alt="Sample"/>
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
                <div class="d-flex p-5 align-items-center h-100">
                    <div class="container">
                        <div class="text-white row justify-content-center">
                            <div class="col-lg-8 col-md-10"> 
                                <h1 class="text-light fw-bold text-center display-5 slideInDown">
                                    About Us 
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="about container-fluid text-center bg-light">
            <div class="row">
                <div class="col animated">
                    <h2>About Our Transportation Services</h2>
                    <p>Welcome to our transportation services! We are dedicated to providing safe and efficient transportation solutions for our customers. Whether you're looking for local travel or long-distance journeys, we've got you covered.</p>
                </div>
                <div class="col animated">
                    <h2>Our Mission</h2>
                    <p>We strive to be the leading transportation service provider, delivering exceptional experiences to our clients. Our mission is to connect people, places, and opportunities through reliable and innovative transportation solutions.</p>
                </div>
            </div>
        </div>

        
        
    @endsection

    @section('footer')
        @include('layouts.footer.footer') 
    @endsection
    
