@extends('layouts.user.about')
    @section('content')
    
    @include('sweetalert::alert')
    
        <!-- <section>
            
            <h3 class="text-center text-light display-5">Our Trucks</h3>
            
            <div class="container animation-card text-center mt-5">
                <div class="row">
                    @foreach ($trucks as $truck)
                        <div class="col d-flex justify-content-center align-items-center">
                            <div class="card animation-cards mb-3" style="width: 12rem;">
                                <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-ripple-color="light">
                                    <img src="{{ asset($truck->truck_image) }}" class="img w-100 card-image" height="100" alt="{{ $truck->truck_type }}">
                                        <div data-mdb-toggle="modal" data-mdb-target="#exampleModal1">
                                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2);"></div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title text-center text-uppercase">Truck Type: {{ $truck->truck_type }}</h5>
                                            <p class="card-title text-uppercase">Plate Number: {{ $truck->plate_number }}</p>
                                        </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-6">col-8</div>
                <div class="col-6">col-4</div>
            </div>
        </div>
            
        </section> -->
        
@endsection
