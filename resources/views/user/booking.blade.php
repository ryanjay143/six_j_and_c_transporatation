@extends('layouts.user.booking')
    @section('content')
    
    @include('sweetalert::alert')

    <style>
       .fc-unthemed th, .fc-unthemed td, .fc-unthemed thead, .fc-unthemed tbody, .fc-unthemed .fc-divider, .fc-unthemed .fc-row, .fc-unthemed .fc-content, .fc-unthemed .fc-popover, .fc-unthemed .fc-list-view, .fc-unthemed .fc-list-heading td{
        border-color: blue;
       }
       .red-background {
            background-color: red !important;
           
        }
    </style>

        <div id="main">
           

            <div class="page-heading">
                
            </div>
            <!-- <button type="button" class="btn btn-primary mb-3"  data-bs-toggle="modal" data-bs-target="#exampleModal">Add Booking</button> -->

            
            <div class="modal fade" id="clientBooking" tabindex="-1" aria-labelledby="exampleModalLabel" 
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Booking</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="pickUpDate" readonly>
                                <label for="floatingInput">Pick-up date</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" readonly 
                                value="{{ Auth::user()->name }}">
                                <label for="floatingInput">Company name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" name="origin" id="origin" 
                                    aria-label="Floating label select example" required onchange="updateOriginReadOnly()">
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
                                <select class="form-select" id="destination" name="destination" aria-label="Floating label select example" required readonly>
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
                                <span id="destinationError" class="text-danger mb-3"></span>
                                <label for="floatingSelect">Destination</label>
                            </div>
                            <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="transportationDate" readonly>
                                <span id="transportationDateError" class="text-danger mb-3"></span>
                                <label for="transportationDate">Transportation date</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" id="saveBtn" type="submit">Add Booking</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           

            <!-- Modal -->
            <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Booking Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row row-cols-2">
                                    <div class="col mb-3">
                                        <p id="modal_booking_date"></p>
                                    </div>
                                    <div class="col mb-3">
                                        <p id="booking_origin"></p>
                                    </div>
                                    <div class="col mb-3">
                                        <p id="booking_destination"></p>
                                    </div>
                                    <div class="col mb-3">
                                        <p id="transportation_date"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <h5><u>Carrier Details</u></h5>
                            </div>
                            <div class="p-3 border rounded" style="background-color: rgba(255, 214, 215);">
                                <p class="m-0">
                                    <strong>Note:</strong> No driver assigned yet!
                                </p>
                            </div>
                            <div class="container">
                                <div class="row row-cols-2">
                                    <div class="col mb-3 mt-3">
                                        <p class="text-secondary">Driver name:</p>
                                    </div>
                                    <div class="col mb-3 mt-3">
                                        <p class="text-secondary">Truck number:</p>
                                    </div>
                                    <div class="col mb-3">
                                        <p class="text-secondary">Helper name:</p>
                                    </div>
                                    <div class="col mb-3">
                                        <p class="text-secondary">Transportation Status:</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Transportation Details</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered border-dark table-hover">
                                <tbody>
                                    <tr>
                                        <th scope="row">Pick-up date:</th>
                                        <td><span id="booking_date"></span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Company Name:</th>
                                        <td><span id="booking_title"></span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Origin:</th>
                                        <td><span id="modal_booking_origin"></span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Destination:</th>
                                        <td><span id="modal_booking_destination"></span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Transportation date:</th>
                                        <td><span id="modal_transportationDate"></span></td>
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
                                        <td><span class="badge bg-success" id="modal_booking_status"></span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Perishable Status:</th>
                                        <td><span class="badge bg-success" id="modal_booking_transportation_status"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-shadow mb-0 w-100">
                                    <div class="card-body">
                                        <div id="legend">
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #0d6efd;"></div>
                                                <div class="legend-label">Pre-booking</div>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: #198754;"></div>
                                                <div class="legend-label">Booked</div>
                                            </div>
                                            <div class="legend-item">
                                                <div class="legend-color" style="background-color: hsla(117, 72%, 68%, 0.879);;"></div>
                                                <div class="legend-label">Delivered</div>
                                            </div>
                                            <!-- Add more legend items as needed -->
                                        </div>
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2021 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="http://ahmadsaugi.com">A. Saugi</a></p>
                    </div>
                </div>
            </footer> -->
        </div>


    @endsection