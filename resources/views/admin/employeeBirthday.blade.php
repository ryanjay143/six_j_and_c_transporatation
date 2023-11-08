@extends('layouts.admin.dashboard')

@section('content')
        <div id="layoutSidenav">
            <div id="layoutSidenav_content" >
                <main >
                    <div class="container-fluid px-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Todays Birthday</li>
                            </ol>
                        </nav>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary mb-3">
                                <div class="card-body text-light ml-3">
                                    <h6 class="card-title"><i class="far fa-calendar-days"></i> Transportation Schedule</h6>
                                    <p class="card-text">{{ $pendingBookings }}</p>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href=""><i class="fas fa-info-circle"></i> View Details</a>
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
                                        <a class="small text-white stretched-link" href="{{ route ('booking.pending') }}"><i class="fas fa-info-circle"></i> View Details</a>
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
                                    <a class="small text-white stretched-link" href="#"><i class="fas fa-info-circle"></i> View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                            
                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-3" style="background-color: rgb(249, 36, 232);">
                                    <div class="card-body text-light ml-3">
                                        <h6 class="card-title"><i class="fas fa-birthday-cake"></i> {{ __('Today\'s Birthday') }}</h6>
                                        <p class="card-text">{{ $countEmployeesTodayBirthday }}</p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="{{ route('employee.birthday') }}"><i class="fas fa-info-circle"></i> View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        

                        <div class="card mb-4">
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true"><i class="fas fa-birthday-cake"></i> {{ __('Today\'s Birthday') }} 
                                            <span class="badge text-bg-primary">{{ $countEmployeesTodayBirthday }}</span>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Upcoming Birthday
                                            <span class="badge text-bg-primary">{{ $countEmployeesUpcomingBirthday }}</span>
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="table" class="table table-bordered table-hover">
                                                    <thead class="table-primary">
                                                        <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Employee Name</th>
                                                        <th scope="col">Date of Birth</th>
                                                        <th scope="col">Age</th>
                                                        <th scope="col">Position</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($employeesTodayBirthday as $e)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $e->user->name }} {{ $e->user->lname }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($e->dob)->formatLocalized('%B %d, %Y') }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($e->dob)->diffInYears(\Carbon\Carbon::now()) }} years old.</td>
                                                                <td>
                                                                    @if ( $e->position == 1)
                                                                        <span class="badge text-bg-dark">Helper</span>
                                                                    @else ($e->position == 0)
                                                                        <span class="badge text-bg-primary">Driver</span>
                                                                    @endif  
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example" class="table table-bordered table-hover">
                                                    <thead class="table-primary">
                                                        <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Employee Name</th>
                                                        <th scope="col">Date of Birth</th>
                                                        <th scope="col">Position</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($employeesUpcomingBirthday as $e)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $e->user->name }} {{ $e->user->lname }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($e->dob)->formatLocalized('%B %d, %Y') }}</td>
                                                                <td>
                                                                    @if ( $e->position == 1)
                                                                        <span class="badge text-bg-dark">Helper</span>
                                                                    @else ($e->position == 0)
                                                                        <span class="badge text-bg-primary">Driver</span>
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
                </main>
            </div>
        </div>
@endsection
