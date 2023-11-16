@extends('layouts.admin.dashboard')

@section('content')

@include('sweetalert::alert')
        <div id="layoutSidenav">
            <div id="layoutSidenav_content" >
                <main >
                    <div class="container-fluid px-4" >
                        <h2 class="mt-4 mb-4">
                            @php
                                date_default_timezone_set('Asia/Manila'); // Set the timezone to Philippines
                                $currentHour = date('H'); // Get the current hour in 24-hour format
                                if ($currentHour >= 5 && $currentHour < 12) {
                                    echo 'Good Morning';
                                } elseif ($currentHour >= 12 && $currentHour < 18) {
                                    echo 'Good Afternoon';
                                } else {
                                    echo 'Good Evening';
                                }
                            @endphp
                            <span class="text-capitalize">{{ Auth::user()->name }}!</span>
                        </h2>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary mb-3">
                                <div class="card-body text-light ml-3">
                                    <h6 class="card-title"><i class="far fa-calendar-days"></i> Transportation Schedule</h6>
                                    <p class="card-text">{{ $pendingBookings }}</p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="{{ route('booking.calendar') }}"><i class="fas fa-info-circle"></i> View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning mb-3">
                                    <div class="card-body text-light ml-3">
                                        <h6 class="card-title"><i class="bi bi-people"></i> List of Clients</h6>
                                        <p class="card-text">{{ $clients }}</p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="{{ route ('client.account') }}"><i class="fas fa-info-circle"></i> View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success mb-3">
                                <div class="card-body text-light ml-3">
                                    <h6 class="card-title"><i class="bi bi-people"></i> List of Employee</h6>
                                    <p class="card-text">{{ $employee }}</p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="{{ route('employee.account') }}"><i class="fas fa-info-circle"></i> View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                            
                        @if ($countEmployeesTodayBirthday > 0)
                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-3" style="background-color: rgb(249, 36, 232);">
                                    <div class="card-body text-light ml-3">
                                        <h6 class="card-title"><i class="fas fa-birthday-cake"></i> Today's Birthday</h6>
                                        <p class="card-text">{{ $countEmployeesTodayBirthday }}</p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="{{ route('employee.birthday') }}"><i class="fas fa-info-circle"></i> View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        @endif


                        </div>
                        <div class="card mb-0 size">
                            <div class="card-body">
                                <h5 class="fw-bold mb-4">{{ __('Today\'s Transportation') }} <span class="badge text-bg-primary">{{ $countTranspo }}</span></h5>
                                <div class="table-responsive">
                                    <table id="example" class="table table-hover table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Company Name</th>
                                                <th scope="col">Truck type</th>
                                                <th scope="col">Route</th>
                                                <th scope="col">Transportation Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count = 1;
                                            @endphp
                                            @foreach ($transpo as $t)
                                            <tr>
                                                <th scope="row">{{ $count++ }}</th>
                                                <td>{{ $t->booking->user->name }}</td>
                                                <td class="text-uppercase">{{ $t->truck->truck_type }} {{ $t->truck->plate_number }}</td>
                                                <td>{{ $t->booking->origin }} - {{ $t->booking->destination }}</td>
                                                <td>
                                                    @if ($t->status == 5)
                                                    <form method="post" action="{{ route('update_transportation.for.admin', ['id' => $t->id]) }}">
                                                        @csrf
                                                        <select name="status" class="form-select form-select-sm" aria-label=".form-select-sm example"
                                                            onchange="this.form.submit()">
                                                            <option value="5" @if ($t->status == 5) selected @endif disabled>Delivered</option>
                                                            <option value="6">Arrived at the station</option>
                                                        </select>
                                                    </form>

                                                    @else
                                                        @if ($t->status == 1)
                                                            <span class="badge bg-success">To be pick-up</span>
                                                        @elseif ($t->status == 2)
                                                            <span class="badge bg-success">Picked-up</span>
                                                        @elseif ($t->status == 3)
                                                            <span class="badge bg-success">Departed</span>
                                                        @elseif ($t->status == 4)
                                                            <span class="badge bg-success">In Transit</span>
                                                        @elseif ($t->status == 5)
                                                            <span class="badge bg-success">Delivered</span>
                                                        @elseif ($t->status == 6)
                                                            <span class="badge bg-info">Arrived at the station</span>
                                                        @endif
                                                    @endif
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1{{ $t->id }}"><i class="bi bi-eye-fill"></i></button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal1{{ $t->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-3" id="exampleModalLabel">Transportation Booking Details</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="container text-center">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <table class="table table-bordered table-hover border-dark">
                                                                                    <thead class="table-primary">
                                                                                        <tr>
                                                                                            <th colspan="2">
                                                                                                <h4 class="text-start">Client Information</h4>
                                                                                            </th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody class="text-start ">
                                                                                        <tr>
                                                                                            <td class="fw-bold">Company Name:</td>
                                                                                            <td>{{ $t->booking->user->name }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-bold">Email Address:</td>
                                                                                            <td>{{ $t->booking->user->email }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-bold">Contact Number:</td>
                                                                                            <td>{{ $t->booking->user->phone_num }}</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div class="col-md-6">
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
                                                                                            <td class="fw-bold">Pick-up date:</td>
                                                                                            <td>{{ \Carbon\Carbon::parse($t->booking->pickUp_date)->format('M-d-Y') }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-bold">Transportation Date:</td>
                                                                                            <td>{{ \Carbon\Carbon::parse($t->booking->transportation_date)->format('M-d-Y') }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-bold">Origin:</td>
                                                                                            <td>{{ $t->booking->origin }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-bold">Destination:</td>
                                                                                            <td>{{ $t->booking->destination }}</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mt-4">
                                                                            <div class="col-md-6">
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
                                                                                            <td class="fw-bold">Driver:</td>
                                                                                            <td>{{ optional($t->employee->user)->name ?? 'N/A' }} {{ optional($t->employee->user)->lname ?? 'N/A' }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-bold">Helper:</td>
                                                                                            <td>{{ optional($t->helper->user)->name ?? 'N/A' }} {{ optional($t->helper->user)->lname ?? 'N/A' }}</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div class="col-md-6">
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
                                                                                            <td class="fw-bold">Truck Type:</td>
                                                                                            <td class="text-uppercase">{{ $t->truck->truck_type }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="fw-bold">Plate Number:</td>
                                                                                            <td class="text-uppercase">{{ $t->truck->plate_number }}</td>
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
                </main>
            </div>
        </div>

@endsection
