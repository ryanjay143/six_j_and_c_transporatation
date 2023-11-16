@extends('layouts.admin.transportation')

@section('content')
@include('sweetalert::alert')
   
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4 mb-4">{{ __('List of Transportation') }}</h2>
                        <div class="row size">
                            <div class="container">
                                <div class="card mb-3 bg-light">
                                    <div class="card-body">
                                        <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Today's Transportation <span class="badge text-bg-primary">{{ $todaysTranspoCount }}</span></button>
                                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Upcoming Transportation <span class="badge text-bg-primary">{{ $countUpcoming }}</span></button>
                                        </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="examples" class="table table-bordered table-hover">
                                                            <thead class="table-primary">
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Client Name</th>
                                                                    <th scope="col">Pick-up Date</th>
                                                                    <th scope="col">Transportation Date</th>
                                                                    <th scope="col">Transportation Status</th>
                                                                    <th scope="col">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($transportations as $transportation)
                                                                    <tr>
                                                                        <th scope="row">{{ $loop->iteration}}</th>
                                                                        <td>{{ $transportation->booking->user->name }}</td>
                                                                        <td>{{ ucfirst(date('F j, Y', strtotime($transportation->booking->pickUp_date))) }}</td>
                                                                        <td>{{ ucfirst(date('F j, Y', strtotime($transportation->booking->transportation_date))) }}</td>
                                                                        <td>                     
                                                                            @if ($transportation->status == 1)
                                                                                <span class="badge bg-success">To be pick-up</span>
                                                                            @elseif ($transportation->status == 2)
                                                                                <span class="badge bg-success">Picked-up</span>
                                                                            @elseif ($transportation->status == 3)
                                                                                <span class="badge bg-success">Departure</span>
                                                                            @elseif ($transportation->status == 4)
                                                                                <span class="badge bg-success">Delivery on the way</span>
                                                                            @elseif ($transportation->status == 5)
                                                                                <span class="badge bg-success">Delivered</span>
                                                                            @elseif ($transportation->status == 6)
                                                                                <span class="badge bg-info">Arrived at the station</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-outline-primary btn-sm"data-bs-toggle="modal" data-bs-target="#exampleModal1{{ $transportation->id }}"><i class="bi bi-eye-fill"></i></button>
                                                                            
                                                                            <!-- Modal -->
                                                                            <div class="modal fade" id="exampleModal1{{ $transportation->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-xl">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h1 class="modal-title fs-3" id="exampleModalLabel">{{ __('Todays Transportation') }}</h1>
                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="container text-center">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-6">
                                                                                                        <!-- Client Information Table -->
                                                                                                        <!-- <h3 class="text-start mb-4">Client Information</h3> -->
                                                                                                        <table class="table table-bordered table-hover border-dark">
                                                                                                            <thead class="table-primary">
                                                                                                                <tr>
                                                                                                                    <th colspan="2">
                                                                                                                        <h4 class="text-start">Client Information</h4>
                                                                                                                    </th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody class="text-start">
                                                                                                                <tr>
                                                                                                                    <td>Company Name:</td>
                                                                                                                    <td>{{ $transportation->booking->user->name }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Email Address:</td>
                                                                                                                    <td>{{ $transportation->booking->user->email }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Contact Number:</td>
                                                                                                                    <td>{{ $transportation->booking->user->phone_num }}</td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                    <div class="col-md-6">
                                                                                                        <!-- Booking Information Table -->
                                                                                                        <!-- <h3 class="text-start mb-4">Booking Information</h3> -->
                                                                                                        <table class="table table-bordered table-hover border-dark">
                                                                                                            <thead class="table-primary">
                                                                                                                <tr>
                                                                                                                    <th colspan="2">
                                                                                                                        <h4 class="text-start">Booking Information</h4>
                                                                                                                    </th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody class="text-start">
                                                                                                                <tr>
                                                                                                                    <td>Pick-up Date:</td>
                                                                                                                    <td>{{ ucfirst(date('F j, Y', strtotime($transportation->booking->pickUp_date))) }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Transportation Date:</td>
                                                                                                                    <td>{{ ucfirst(date('F j, Y', strtotime($transportation->booking->transportation_date))) }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Origin:</td>
                                                                                                                    <td>{{ $transportation->booking->origin }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Destination:</td>
                                                                                                                    <td>{{ $transportation->booking->destination }}</td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row mt-4">
                                                                                                    <div class="col-md-6">
                                                                                                        <!-- Employee Assigned Table -->
                                                                                                        <!-- <h3 class="text-start mb-4">Employee Assigned</h3> -->
                                                                                                        <table class="table table-bordered table-hover border-dark">
                                                                                                            <thead class="table-primary">
                                                                                                                <tr>
                                                                                                                    <th colspan="2">
                                                                                                                        <h4 class="text-start">Employee Assigned</h4>
                                                                                                                    </th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody class="text-start">
                                                                                                                <tr>
                                                                                                                    <td>Driver:</td>
                                                                                                                    <td>{{ optional($transportation->employee->user)->name ?? 'N/A' }} {{ optional($transportation->employee->user)->lname ?? 'N/A' }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Helper:</td>
                                                                                                                    <td>{{ optional($transportation->helper->user)->name ?? 'N/A' }} {{ optional($transportation->helper->user)->lname ?? 'N/A' }}</td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                    <div class="col-md-6">
                                                                                                        <!-- Truck Information Table -->
                                                                                                        <!-- <h3 class="text-start mb-4">Truck</h3> -->
                                                                                                        <table class="table table-bordered table-hover border-dark">
                                                                                                            <thead class="table-primary">
                                                                                                                <tr>
                                                                                                                    <th colspan="2">
                                                                                                                        <h4 class="text-start">Truck</h4>
                                                                                                                    </th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody class="text-start">
                                                                                                                <tr>
                                                                                                                    <td>Truck Type:</td>
                                                                                                                    <td class="text-uppercase">{{ $transportation->truck->truck_type }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Plate Number:</td>
                                                                                                                    <td class="text-uppercase">{{ $transportation->truck->plate_number }}</td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="examples1" class="table table-bordered table-hover">
                                                            <thead class="table-primary">
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Client Name</th>
                                                                    <th scope="col">Pick-up Date</th>
                                                                    <th scope="col">Transportation Date</th>
                                                                    <th scope="col">Booking Status</th>
                                                                    <th scope="col">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($upcoming as $transportation)
                                                                    <tr>
                                                                        <th scope="row">{{ $loop->iteration}}</th>
                                                                        <td>{{ $transportation->booking->user->name }}</td>
                                                                        <td>{{ ucfirst(date('F j, Y', strtotime($transportation->booking->pickUp_date))) }}</td>
                                                                        <td>{{ ucfirst(date('F j, Y', strtotime($transportation->booking->transportation_date))) }}</td>
                                                                        <td>
                                                                            @if ($transportation->status == '1')
                                                                                <span class="badge bg-success">Approved</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-outline-primary btn-sm"data-bs-toggle="modal" data-bs-target="#exampleModal1{{ $transportation->id }}"><i class="bi bi-eye-fill"></i></button>
                                                                            
                                                                            <!-- Modal -->
                                                                            <div class="modal fade" id="exampleModal1{{ $transportation->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-xl">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h1 class="modal-title fs-3" id="exampleModalLabel">{{ __('Upcoming Transportation') }}</h1>
                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="container text-center">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-6">
                                                                                                        <!-- Client Information Table -->
                                                                                                        <!-- <h3 class="text-start mb-4">Client Information</h3> -->
                                                                                                        <table class="table table-bordered table-hover border-dark">
                                                                                                            <thead class="table-primary">
                                                                                                                <tr>
                                                                                                                    <th colspan="2">
                                                                                                                        <h4 class="text-start">Client Information</h4>
                                                                                                                    </th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody class="text-start">
                                                                                                                <tr>
                                                                                                                    <td>Company Name:</td>
                                                                                                                    <td>{{ $transportation->booking->user->name }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Email Address:</td>
                                                                                                                    <td>{{ $transportation->booking->user->email }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Contact Number:</td>
                                                                                                                    <td>{{ $transportation->booking->user->phone_num }}</td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                    <div class="col-md-6">
                                                                                                        <!-- Booking Information Table -->
                                                                                                        <!-- <h3 class="text-start mb-4">Booking Information</h3> -->
                                                                                                        <table class="table table-bordered table-hover border-dark">
                                                                                                            <thead class="table-primary">
                                                                                                                <tr>
                                                                                                                    <th colspan="2">
                                                                                                                        <h4 class="text-start">Booking Information</h4>
                                                                                                                    </th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody class="text-start">
                                                                                                                <tr>
                                                                                                                    <td>Pick-up Date:</td>
                                                                                                                    <td>{{ ucfirst(date('F j, Y', strtotime($transportation->booking->pickUp_date))) }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Transportation date:</td>
                                                                                                                    <td>{{ ucfirst(date('F j, Y', strtotime($transportation->booking->transportation_date))) }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Origin:</td>
                                                                                                                    <td>{{ $transportation->booking->origin }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Destination:</td>
                                                                                                                    <td>{{ $transportation->booking->destination }}</td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row mt-4">
                                                                                                    <div class="col-md-6">
                                                                                                        <!-- Employee Assigned Table -->
                                                                                                        <!-- <h3 class="text-start mb-4">Employee Assigned</h3> -->
                                                                                                        <table class="table table-bordered table-hover border-dark">
                                                                                                            <thead class="table-primary">
                                                                                                                <tr>
                                                                                                                    <th colspan="2">
                                                                                                                        <h4 class="text-start">Employee Assigned</h4>
                                                                                                                    </th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody class="text-start">
                                                                                                                <tr>
                                                                                                                    <td>Driver:</td>
                                                                                                                    <td>{{ optional($transportation->employee->user)->name ?? 'N/A' }} {{ optional($transportation->employee->user)->lname ?? 'N/A' }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Helper:</td>
                                                                                                                    <td>{{ optional($transportation->helper->user)->name ?? 'N/A' }} {{ optional($transportation->helper->user)->lname ?? 'N/A' }}</td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                    <div class="col-md-6">
                                                                                                        <!-- Truck Information Table -->
                                                                                                        <!-- <h3 class="text-start mb-4">Truck</h3> -->
                                                                                                        <table class="table table-bordered table-hover border-dark">
                                                                                                            <thead class="table-primary">
                                                                                                                <tr>
                                                                                                                    <th colspan="2">
                                                                                                                        <h4 class="text-start">Truck</h4>
                                                                                                                    </th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody class="text-start">
                                                                                                                <tr>
                                                                                                                    <td>Truck Type:</td>
                                                                                                                    <td class="text-uppercase">{{ $transportation->truck->truck_type }}</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Plate Number:</td>
                                                                                                                    <td class="text-uppercase">{{ $transportation->truck->plate_number }}</td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
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
                    </div>
                </main>
            </div>
        </div>
@endsection