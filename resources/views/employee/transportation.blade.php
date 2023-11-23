@extends('layouts.employee.transportation')

@section('content')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>{{ __('List of Transportations') }}</h3>
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
                                                <button class="nav-link active mb-3 me-3" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Upcoming Transportation <span class="badge rounded-pill bg-primary">{{ $approvedTranspo }}</span></button>
                                                <button class="nav-link mb-3 me-3" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Transportation History <span class="badge rounded-pill bg-primary">{{ $countDeliveredTranspo }}</span></button>
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                                <div class="table-responsive table-responsive-for-transportation">
                                                    <table id="datatable1" class="table table-bordered letter-size" >
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Company Name</th>
                                                                <th scope="col">Transportation Date</th>
                                                                <th scope="col">Route</th>
                                                                <th scope="col">Helper</th>
                                                                <th scope="col">Transport Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                // Sort the $transpo array based on the date
                                                                $sortedTranspo = $transpo->sortBy(function ($t) {
                                                                    return Carbon\Carbon::parse($t->booking->transportation_date);
                                                                });
                                                            @endphp
                                                            @foreach ($sortedTranspo as $t)
                                                                <tr>
                                                                    <td scope="row">{{ $loop->iteration }}</td>
                                                                    <td>{{ $t->booking->user->name }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($t->booking->transportation_date)->format('M d, Y') }}</td>
                                                                    <td>{{ $t->booking->origin }} - {{ $t->booking->destination }}</td>
                                                                    <td>
                                                                        @if ($t->helper)
                                                                            {{ $t->helper->user->name }} {{ $t->helper->user->lname }}
                                                                        @else
                                                                            N/A <!-- Display "N/A" if there is no associated helper -->
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($t->status == '1')
                                                                            <span class="badge bg-success">To be picked-up</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                                <div class="table-responsive table-responsive-for-transportation-history">
                                                    <table id="datatable2" class="table table-bordered table-hover letter-size">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Company Name</th>
                                                                <th scope="col">Transportation Date</th>
                                                                <th scope="col">Route</th>
                                                                <th scope="col">Helper</th>
                                                                <th scope="col">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                // Sort the $transpo array based on the date
                                                                $deliveredTransportation = $deliveredTranspo->sortBy(function ($t) {
                                                                    return Carbon\Carbon::parse($t->booking->transportation_date);
                                                                });
                                                            @endphp
                                                            @foreach ($deliveredTransportation as $t)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $t->booking->user->name }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($t->booking->transportation_date)->format('M d, Y') }}</td>
                                                                    <td>{{ $t->booking->origin }} - {{ $t->booking->destination }}</td>
                                                                    <td>
                                                                        @if ($t->helper)
                                                                            {{ $t->helper->user->name }} {{ $t->helper->user->lname }}
                                                                        @else
                                                                            N/A <!-- Display "N/A" if there is no associated helper -->
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($t->status == '1')
                                                                            <span class="badge bg-success">Approved</span>
                                                                        @elseif ($t->status == '2')
                                                                            <span class="badge bg-secondary">Departure</span>
                                                                        @elseif ($t->status == '3')
                                                                            <span class="badge bg-primary">To be Pick-Up</span>
                                                                        @elseif ($t->status == '4')
                                                                            <span class="badge bg-light">In Route</span>
                                                                        @elseif ($t->status == '5')
                                                                            <span class="badge bg-success">Delivered</span>
                                                                        @elseif ($t->status == '6')
                                                                            <span class="badge bg-success">Delivered</span>
                                                                        @elseif ($t->status == '7')
                                                                            <span class="badge bg-success">Delivered</span>
                                                                        @else
                                                                            Unknown
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