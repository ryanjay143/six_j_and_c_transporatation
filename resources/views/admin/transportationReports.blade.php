@extends('layouts.admin.reports')

@section('content')
@include('sweetalert::alert')
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4 mb-4">Transportation Reports</h2>
                            <div class="row">
                                <div class="container">
                                    <div class="card mb-3">
                                        <div class="card-body">                                 
                                            <div class="table-responsive">
                                                <form id="filterFormDate" class="row g-3" action="{{ route('filter.transportationDate') }}" method="get">
                                                    <div class="col-md-4 align-self-end mb-2">
                                                        <select name="driver_id" class="form-select" required>
                                                            <option selected disabled>Select driver</option>
                                                            @foreach ($driver as $d)
                                                                <option value="{{ $d->id }}">{{ $d->user->name }} {{ $d->user->lname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 align-self-end mb-2" required>
                                                        <select name="helper_id" class="form-select align-self-end">
                                                            <option selected disabled>Select helper</option>
                                                            @foreach ($helper as $h)
                                                                <option value="{{ $h->id }}">{{ $h->user->name }} {{ $h->user->lname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label for="date" class="form-label">Filter Delivered date</label>
                                                        <input type="date" class="form-control" id="deliveredDate" name="deliveredDate"> 
                                                    </div>
                                                </form>
                                                <table id="transportationReports" class="table table-bordered table-hover">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th class="fw-bold" scope="col">Delivered date</th>
                                                            <th class="fw-bold" scope="col">Driver name</th>
                                                            <th class="fw-bold" scope="col">Helper name</th>
                                                            <th class="fw-bold" scope="col">Route</th>
                                                            <th class="fw-bold" scope="col">Plate No.</th>
                                                            <th class="fw-bold" scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($transportations as $t)
                                                            <tr>
                                                                <td>
                                                                @foreach ($t->updatedTimes as $updatedTime)
                                                                    @if ($updatedTime->status == 5)
                                                                        {{ $updatedTime->updated_at->format('F d, Y') }}
                                                                    @endif
                                                                @endforeach
                                                                </td>
                                                                <td>{{ $t->employee->user->name }} {{ $t->employee->user->lname }}</td>
                                                                <td>{{ $t->helper->user->name }} {{ $t->helper->user->lname }}</td>
                                                                <td>{{ $t->booking->origin }}-{{ $t->booking->destination }}</td>
                                                                <td>{{ $t->truck->plate_number }}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-outline-primary btn-sm"data-bs-toggle="modal" 
                                                                    data-bs-target="#exampleModal2{{ $t->id }}"><i class="bi bi-eye-fill"></i></button>
                                                                     
                                                                    <div class="modal fade" id="exampleModal2{{ $t->id }}" tabindex="-1" 
                                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title fs-3">{{ __('Transportation details') }}</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" 
                                                                                    aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="card-body">
                                                                                        <div class="table-responsive">
                                                                                            <table class="table table-hover table-bordered">
                                                                                                <thead class="table-primary">
                                                                                                    <tr>
                                                                                                        <th scope="col">#</th>
                                                                                                        <th scope="col">Client name</th>
                                                                                                        <th scope="col">Transportation status</th>
                                                                                                        <th scope="col">Updated datetime</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    @foreach ($t->updatedTimes as $u)
                                                                                                        <tr>
                                                                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                                                                            <td>{{ $u->transportationDetails->booking->user->name }}</td>
                                                                                                            <td>
                                                                                                                @if ($u->status == 2)
                                                                                                                    <span class="badge bg-danger">Picked-up</span>
                                                                                                                @elseif ($u->status == 3)
                                                                                                                    <span class="badge bg-secondary">Departure</span>
                                                                                                                @elseif ($u->status == 4)
                                                                                                                    <span class="badge bg-success">Delivery on the way</span>
                                                                                                                @elseif ($u->status == 5)
                                                                                                                    <span class="badge bg-success">Delivered</span>
                                                                                                                @elseif ($u->status == 6)
                                                                                                                    <span class="badge bg-info">Arrived at the station</span>
                                                                                                                @endif
                                                                                                                
                                                                                                            </td>
                                                                                                            <td>{{ $u->created_at->format('M d, Y h:i A') }}</td>
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
         


@endsection