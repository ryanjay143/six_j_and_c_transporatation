@extends('layouts.admin.clientbooking')

@section('content')
@include('sweetalert::alert')
    <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4">{{ __('Clients Booking') }}</h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">Booking</li>
                                </ol>
                            </nav>
                            <div class="row">
                                <div class="container-fluid">
                                    <div class="card mb-5">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example" class="table size table-bordered table-hover">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Company Name</th>
                                                            <th scope="col">Booking Date</th>
                                                            <th scope="col">Transportation Date</th>
                                                            <th scope="col">Expectation Tons</th>
                                                            <th scope="col">Route</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pendingBookings as $p)
                                                            <tr class="{{ $p->status == 2 ? 'danger-row' : '' }}">
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td class="{{ $p->status == 2 ? 'text-danger' : '' }}">{{ $p->user->name }}</td>
                                                            <td class="{{ $p->status == 2 ? 'text-danger' : '' }}">{{ date('M j, Y', strtotime($p->created_at)) }}</td>
                                                            <td class="{{ $p->status == 2 ? 'text-danger' : '' }}">{{ date('M j, Y', strtotime($p->date)) }}</td>
                                                            <td class="{{ $p->status == 2 ? 'text-danger' : '' }}">
                                                                <input type="text" style="width: 60px;" readonly class="form-control" value="{{ $p->exp_tons }}">
                                                            </td>
                                                            <td class="{{ $p->status == 2 ? 'text-danger' : '' }}">{{ $p->origin }} - {{ $p->destination }}</td>
                                                            <td>
                                                            @if ($p->status == 0)
                                                                <span class="badge text-bg-primary">Pending</span>
                                                            @elseif ($p->status == 2)
                                                                <span class="badge text-bg-danger">Decline</span>
                                                            @endif
                                                            </td>
                                                            <td>
                                                                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1{{ $p->id }}" {{ $p->status == 2 ? 'disabled' : '' }}><i class="bi bi-eye"></i></button>
                                                                    <a href="{{ route('decline.booking',$p->id) }}" type="button" class="btn btn-outline-danger btn-sm" {{ $p->status == 2 ? 'disabled' : '' }}><i class="fa-solid fa-circle-xmark"></i></a>
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="exampleModal1{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Transportation Details</h1>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form action="{{ route('transportation.details', ['id' => $p->id]) }}" method="post" onsubmit="return validateForm()">
                                                                                    @csrf
                                                                                        <div class="mb-3">
                                                                                            <input type="text" hidden class="form-control" name="booking_id" id="booking_id" value="{{ $p->id }}">
                                                                                            <label for="formGroupExampleInput" class="form-label">Driver Assign</label>
                                                                                            <select class="form-select" aria-label="Default select example" name="driver_id" id="driver_id" required>
                                                                                                <option selected disabled>Select Driver</option>
                                                                                                @foreach ($drivers as $driver)
                                                                                                    <option value="{{ $driver->id}}">{{ $driver->user->name}} {{ $driver->user->lname}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="formGroupExampleInput2" class="form-label">Helper Assign</label>
                                                                                            <select class="form-select" aria-label="Default select example" name="helper_id" id="helper_id" required>
                                                                                                <option selected disabled>Select Helper</option>
                                                                                                @foreach ($helpers as $helper)
                                                                                                    <option value="{{ $helper->id}}">{{ $helper->user->name}} {{ $helper->user->lname}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="formGroupExampleInput2" class="form-label">Available Truck</label>
                                                                                            <select class="form-select text-uppercase" aria-label="Default select example" name="truck_id" id="truck_id" required>
                                                                                                <option selected disabled>Available Truck</option>
                                                                                                @foreach ($trucks as $truck)
                                                                                                    <option class="text-uppercase" value="{{ $truck->id }}">{{ $truck->truck_type }} {{ $truck->plate_number }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button id="submit-button" type="submit" class="btn btn-primary btn-sm">Approved</button>
                                                                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </form>
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
                </main>
            </div>
        </div>

       

@endsection