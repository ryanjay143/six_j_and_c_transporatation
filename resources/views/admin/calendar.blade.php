@extends('layouts.admin.booking')

@section('content')
@include('sweetalert::alert')

    <style>
        .fc-unthemed th, .fc-unthemed td, .fc-unthemed thead, .fc-unthemed tbody, .fc-unthemed .fc-divider, .fc-unthemed .fc-row, .fc-unthemed .fc-content, .fc-unthemed .fc-popover, .fc-unthemed .fc-list-view, .fc-unthemed .fc-list-heading td{
            border-color: blue;
           
       }
    
      
    </style>
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                            <!-- Modal -->
                        <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Booking Details</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="transportationDate" readonly>
                                            <label for="floatingInput">Transportation date</label>
                                        </div>
                                        <div class="form-floating">
                                            <select class="form-select mb-3" id="company_name"  name="company_name" aria-label="Floating label select example">
                                                <option selected disabled>Select Company</option>
                                                    @foreach ($clients as $c)
                                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                    @endforeach
                                            </select>
                                            <label for="floatingSelect">Company</label>
                                            <span id="titleError" class="text-danger mb-3"></span>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="origin" id="origin" aria-label="Floating label select example" required>
                                                <option selected disabled>Select Origin</option>
                                                <option value="Cagayan de Oro">Cagayan de Oro</option>
                                                <option value="Iligan City">Iligan City</option>
                                                <option value="Pagadian City">Pagadian City</option>
                                                <option value="Zamboanga">Zamboanga</option>
                                                <option value="Ozamiz City">Ozamiz City</option>
                                                <option value="Davao">Davao</option>
                                                <option value="Butuan City">Butuan City</option>
                                                <option value="Gensan">Gensan</option>
                                            </select>
                                            <span id="originError" class="text-danger"></span>
                                            <label for="floatingSelect">Origin</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="pickUpTime" aria-label="Floating label select example" required>
                                            <option selected disabled>(expectation)</option>
                                                    <option value="08:00">8:00 AM</option>
                                                    <option value="09:00">9:00 AM</option>
                                                    <option value="10:00">10:00 AM</option>
                                                    <option value="11:00">11:00 AM</option>
                                                    <option value="12:00">12:00 PM</option>
                                                    <option value="13:00">1:00 PM</option>
                                                    <option value="14:00">2:00 PM</option>
                                                    <option value="15:00">3:00 PM</option>
                                                    <option value="16:00">4:00 PM</option>
                                                    <option value="17:00">5:00 PM</option>
                                                    <option value="18:00">6:00 PM</option>
                                            </select>
                                            <span id="pickUpTimeError" class="text-danger mb-3"></span>
                                            <label for="floatingSelect">Pick-up time</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="destination" name="destination" aria-label="Floating label select example" required>
                                                <option selected disabled>Select Destination</option>
                                                <option value="Cagayan de Oro">Cagayan de Oro</option>
                                                <option value="Iligan City">Iligan City</option>
                                                <option value="Pagadian City">Pagadian City</option>
                                                <option value="Zamboanga">Zamboanga</option>
                                                <option value="Ozamiz City">Ozamiz City</option>
                                                <option value="Davao">Davao</option>
                                                <option value="Butuan City">Butuan City</option>
                                                <option value="Gensan">Gensan</option>
                                            </select>
                                            <span id="desError" class="text-danger mb-3"></span>
                                            <label for="floatingSelect">Destination</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="datetime-local" class="form-control" id="trasportationTime" min="{{ date('Y-m-d\TH:i') }}">
                                            <span id="transportationTimeError" class="text-danger mb-3"></span>
                                            <label for="floatingInput">Delivery date & time</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="driver_id" name="driver_id" aria-label="Floating label select example">
                                                <option selected disabled>Select Driver</option>
                                                @foreach ($drivers as $e)
                                                    <option value="{{ $e->id }}" @if ($e->user->is_disabled == 1) disabled @endif>
                                                        {{ $e->user->name }} {{ $e->user->lname }}
                                                        @if ($e->user->is_disabled == 1) (Inactive) @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span id="driverError" class="text-danger mb-3"></span>
                                            <label for="driver_id">Driver</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="helper_id" name="helper" aria-label="Floating label select example">
                                                <option selected disabled>Select Helper</option>
                                                @foreach ($helpers as $e)
                                                    <option value="{{ $e->id }}">
                                                        {{ $e->user->name }} {{ $e->user->lname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span id="helperError" class="text-danger mb-3"></span>
                                            <label for="helper_id">Helper</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-select text-uppercase" id="truck_id" name="truck_id" aria-label="Floating label select example">
                                                <option selected disabled>Select Truck</option>
                                                @foreach ($trucks as $truck)
                                                    <option class="text-uppercase" value="{{ $truck->id }}" @if ($truck->status != 0) disabled @endif>
                                                        {{ $truck->truck_type }} {{ $truck->plate_number }}
                                                        @if ($truck->status == 1) 
                                                            (Under Maintenance) 
                                                        @elseif ($truck->status == 2)
                                                            (Assigned)
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span id="truckError" class="text-danger mb-3"></span>
                                            <label for="floatingSelect">Truck Type</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="saveBtn" class="btn btn-sm btn-primary">Approved</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add a modal for displaying event details -->
                        <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Booking Information</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered border-dark table-hover">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Transportation Date:</th>
                                                    <td><span id="modal_date"></span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Company Name:</th>
                                                    <td><span id="modal_company_name"></span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Origin:</th>
                                                    <td><span id="modal_origin"></span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Pick-up time:</th>
                                                    <td><span id="modal_pickUpTime"></span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Destination:</th>
                                                    <td><span id="modal_destination"></span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Delivery date & time:</th>
                                                    <td><span id="modal_transportationTime"></span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Driver:</th>
                                                    <td><span id="modal_driver"></span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Helper:</th>
                                                    <td><span id="modal_helper"></span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Truck Assigned:</th>
                                                    <td><span class="text-uppercase" id="modal_truck"></span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Booking Status:</th>
                                                    <td><span class="badge text-bg-success" id="modal_status"></span></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Perishable Status:</th>
                                                    <td><span class="badge text-bg-success" id="modal_status_perishable"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Booking Information</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-floating">
                                            <input hidden="" type="text" class="form-control" id="booking_id">
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="date" readonly>
                                            <label for="transportationDate">Transportation date</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="modal_booking_title" readonly>
                                            <label for="modal_booking_title">Client Name</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="modal_booking_origin" readonly>
                                            <label for="modal_booking_origin">Origin</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="modal_booking_pickUpTime" readonly>
                                            <label for="modal_booking_pickUpTime">Pick-up time</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="modal_booking_destination" readonly>
                                            <label for="modal_booking_destination">Destination</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="modal_booking_transportation_time" readonly>
                                            <label for="modal_booking_transportation_time">Transportation time</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="modal_booking_status" readonly>
                                            <label for="modal_booking_status">Status</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="driver" name="driver_id" aria-label="Floating label select example">
                                                <option selected disabled>Select Driver</option>
                                                @foreach ($drivers as $e)
                                                    <option value="{{ $e->id }}" @if ($e->user->is_disabled == 1) disabled @endif>
                                                        {{ $e->user->name }} {{ $e->user->lname }}
                                                        @if ($e->user->is_disabled == 1) (Inactive) @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span id="driverIDError" class="text-danger mb-3"></span>
                                            <label for="driver_id">Driver</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="helper" name="helper" aria-label="Floating label select example">
                                                <option selected disabled>Select Helper</option>
                                                @foreach ($helpers as $e)
                                                    <option value="{{ $e->id }}">
                                                        {{ $e->user->name }} {{ $e->user->lname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span id="helperIDError" class="text-danger mb-3"></span>
                                            <label for="helper_id">Helper</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-select text-uppercase" id="truck" name="truck_id" aria-label="Floating label select example">
                                                <option selected disabled>Select Truck</option>
                                                @foreach ($trucks as $t)
                                                    <option class="text-uppercase" value="{{ $t->id }}" @if ($t->status == 1) disabled @endif>
                                                        {{ $t->truck_type }} {{ $t->plate_number }}
                                                        @if ($t->status == 1) 
                                                            (Under Maintenance) 
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span id="truckIDError" class="text-danger mb-3"></span>
                                            <label for="floatingSelect">Truck Type</label>
                                        </div>
                                        <button type="button" id="saveBtn1" class="btn btn-primary btn-sm float-end">Approved</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="container">
                                <div class="card card-shadow mt-5 mb-3 w-100">
                                    <div class="card-body">
                                        <div id="legend">
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #0d6efd;"></div>
                                                <div class="legend-label">Not assign</div>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #198754;"></div>
                                                <div class="legend-label">To be pick-up</div>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #dc3545;"></div>
                                                <div class="legend-label">Picked-up</div>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #adb5bd;"></div>
                                                <div class="legend-label">Departure</div>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: skyblue;"></div>
                                                <div class="legend-label">Delivery on the way</div>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: hsla(117, 72%, 68%, 0.879);;"></div>
                                                <div class="legend-label">Delivered</div>
                                            </div>
                                            <!-- Add more legend items as needed -->
                                        </div>
                                        <div class="calendar-date" id="calendar" ></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                           
                        </div>
                    </main>
                </div>
            </div>

       

@endsection