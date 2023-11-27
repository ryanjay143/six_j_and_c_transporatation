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
                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary" onclick="printForm()">Print with PDF</button>
                                    </div>
                                    <div id="printableForm" class="card mb-3 print-form">
                                        <div class="card-body">                                 
                                            <div class="table-responsive">
                                                <div class="row g-3">
                                                    <div class="col-md-4 mb-2">
                                                        <select id="driverSelect" class="form-select action-column" required>
                                                            <option selected disabled>Select driver</option>
                                                            @foreach ($driver as $d)
                                                                <option>{{ $d->user->name }} {{ $d->user->lname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 align-self-end mb-2" required>
                                                        <select id="helperSelect" class="form-select align-self-end action-column">
                                                            <option selected disabled>Select helper</option>
                                                            @foreach ($helper as $h)
                                                                <option>{{ $h->user->name }} {{ $h->user->lname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 align-self-end mb-2" required>
                                                        <select id="plateNumberSelect" class="form-select align-self-end action-column">
                                                            <option selected disabled>Select plate number</option>
                                                            @foreach ($truck as $t)
                                                                <option>{{ $t->plate_number }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <table id="transportationReports" class="table table-bordered">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th class="fw-bold" scope="col">Delivered date</th>
                                                            <th class="fw-bold" scope="col">Driver name</th>
                                                            <th class="fw-bold" scope="col">Helper name</th>
                                                            <th class="fw-bold" scope="col">Route</th>
                                                            <th class="fw-bold" scope="col">Plate No.</th>
                                                            <th class="fw-bold action-column" scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            // Sort the transportations array based on the latest updated_at timestamp
                                                            $sortedTransportations = $transportations->sortByDesc(function ($t) {
                                                                $latestUpdatedTime = $t->updatedTimes->where('status', 5)->max('created_at');
                                                                return $latestUpdatedTime ?? '';
                                                            });
                                                        @endphp
                                                        @foreach ($sortedTransportations as $t)
                                                            <tr class="uniqueIdentifier">
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
                                                                <td class="action-column">
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
                                                                                                <tbody id="modalTable">
                                                                                                    @foreach ($t->updatedTimes as $u)
                                                                                                        <tr>
                                                                                                            <td scope="row">{{ $loop->iteration }}</td>
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