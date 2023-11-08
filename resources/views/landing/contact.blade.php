@extends('layouts.landing.contact')
    
    @section('content')
    <div class="my-image bg-image">
        <img src="{{ asset('images/truck.jpg') }}" alt="Sample" />
        <div class="my-mask mask">
            <div class="container">
                <div class="text-white text-center">
                    <h1 class="fw-bold display-5 slideInDown">
                        Transportation Services in Mindanao
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Card with Map -->
    <div class="my-card card">
        <h1 class="text-start p-3">Map of Mindanao</h1>
        <div class="card-body">
            <iframe id="mapIframe" width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
        </div>
        <h4 class="text-center">Explore the map!</h4>
    </div>


        
    
        
    @endsection
    

    @section('footer')
        @include('layouts.footer.footer') 
    @endsection