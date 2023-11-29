@extends('layouts.landing.service')

    @section('content')
    <div class="my-image bg-image">
        <img src="{{ asset('images/truck.jpg') }}" alt="Sample" />
        <div class="my-mask mask">
            <div class="container">
                <div class="text-white text-center row justify-content-center">
                    <div class="col-lg-8 col-md-10 border-start border-3 border-primary">
                        <h1 class="fw-bold display-5 slideInDown text-justify">
                            Delivering Freshness - Ensuring Quality
                        </h1>
                        <p class="text-start lh-sm">
                            Six J and C Transport is your 
                            trusted partner in perishable goods transportation, 
                            committed to safeguarding the integrity of your perishable 
                            from origin to destination. 
                            With refrigerated trucks, customized temperature solutions, 
                            and a relentless dedication to precision, 
                            our mission is to provide seamless and reliable transportation 
                            services for your perishable items. Experience excellence in perishable 
                            transportation with us - where every delivery is a promise of freshness 
                            preserved and quality guaranteed.
                        </p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer.footer') 
    @endsection
    

