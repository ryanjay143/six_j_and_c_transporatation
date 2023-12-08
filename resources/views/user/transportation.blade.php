@extends('layouts.user.transportation')
    @section('content')
    
    @include('sweetalert::alert')
    
    <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>{{ __('List of Transportation') }}</h3>
            </div>
            
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mr-sm-3 border border-primary w-100">
                                <div class="card-body">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active me-2 mb-3" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Approved Bookings <span class="badge rounded-pill bg-primary">{{ $countApprovedTranspo }}</span></button>
                                            <button class="nav-link me-2 mb-3" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Delivered Transportation <span class="badge rounded-pill bg-primary">{{ $countDeliveredTranspo }}</span></button>
                                        </div>
                                    </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                                <div class="table-responsive">
                                                    <?php
                                                        // Sort the employees array so that drivers come first
                                                        $approvedDate = $approvedTranspo ->sortBy(function ($approvedTranspo ) {
                                                            return $approvedTranspo->booking->date;
                                                        });                                    
                                                    ?>
                                                    <?php
                                                        // Sort the employees array so that drivers come first
                                                        $deliveredDate = $deliveredTranspo ->sortBy(function ($deliveredTranspo) {
                                                            return $deliveredTranspo->booking->date;
                                                        });                                    
                                                    ?>
                                                    <table id="example" class="table letter-size table-bordered table-hover">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Transportation Date</th>
                                                                <th scope="col">Driver</th>
                                                                <th scope="col">Route</th> 
                                                                <th scope="col">Truck Type</th> 
                                                                <th scope="col">Booking date</th>                                                                   
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($approvedDate as $t)
                                                                <tr>
                                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                                    <td>{{ date('F j, Y', strtotime($t->booking->transportation_date)) }}</td>
                                                                    <td>{{ $t->employee->user->name }} {{ $t->employee->user->lname }}</td>
                                                                    <td>{{ $t->booking->origin }} - {{ $t->booking->destination }}</td>  
                                                                    <td class="text-uppercase">{{ $t->truck->truck_type }} {{ $t->truck->plate_number }}</td>
                                                                    <td>{{ date('F j, Y', strtotime($t->booking->created_at)) }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                               
                                                    <div class="table-responsive">
                                                        <table id="examples" class="table letter-size table-bordered table-hover">
                                                            <thead class="table-primary">
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Driver</th>
                                                                    <th scope="col">Route</th> 
                                                                    <th scope="col">Truck Type</th> 
                                                                    <th scope="col">Booking date</th>                                                                   
                                                                    <th scope="col">Transportation date</th>
                                                                    <th scope="col">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($deliveredDate as $t)
                                                                    <tr>
                                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                                        <td>{{ $t->employee->user->name }} {{ $t->employee->user->lname }}</td>
                                                                        <td>{{ $t->booking->origin }} - {{ $t->booking->destination }}</td>  
                                                                        <td class="text-uppercase">{{ $t->truck->truck_type }} {{ $t->truck->plate_number }}</td>
                                                                        <td>{{ date('F j, Y', strtotime($t->booking->created_at)) }}</td>                                                                    
                                                                        <td>{{ date('F j, Y', strtotime($t->booking->transportation_date)) }}</td>
                                                                        <td>
                                                                            @if (in_array($t->status, ['5', '6', '7']))
                                                                                <span class="badge bg-success">Delivered</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        
@endsection
