@extends('layouts.landing.home')
    @section('content')
    
    @include('sweetalert::alert')
        <div class="bg-image">
            <img src="{{ asset('images/truck.jpg') }}" class="img-fluid w-100" style="max-width: 100%; height: 76vh;" alt="Sample"/>
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
                <div class="d-flex p-5 align-items-center h-100">
                    <div class="container">
                        <div class="text-white row justify-content-center">
                            <div class="col-lg-8 col-md-10"> 
                                <h3 class="text-primary fw-bold text-start display-5 slideInDown">
                                    <span class="custom-span">Welcome to Six J And C</span>
                                    <br>
                                    <span class="text-light text-uppercase transportation">Transportation</span>
                                </h3>
                                <p class="fs-6 fst-normal font-monospace" >"We deliver your perishable goods safely, do not delay."</p>
                                <a href="{{ route('user.booking') }}" class="btn btn-outline-primary py-sm-3 mb-5 px-sm-4">Book for Transportation Today</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

    @endsection
    
    @section('footer')
        @include('layouts.footer.footer') 
    @endsection
