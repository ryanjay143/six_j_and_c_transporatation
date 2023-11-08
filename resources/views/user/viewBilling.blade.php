@extends('layouts.user.viewBilling')
    @section('content')
    
    @include('sweetalert::alert')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.billings.payment') }}">List of Billing</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Billing Details</li>
                    </ol>
                </nav>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mr-sm-3 border border-primary w-100">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <p class="text-center">This is bill you the various services rendered for the period of {{ \Carbon\Carbon::parse($billing->billing_start_date)->format('F d, Y') }} - {{ \Carbon\Carbon::parse($billing->billing_end_date)->format('F d, Y') }}</p>
                                            <table class="table letter-size table-bordered table-hover">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Transportation date</th>
                                                        <th scope="col">Driver</th>
                                                        <th scope="col">Plate No.</th>
                                                        <th scope="col">Truck type</th>
                                                        <th scope="col">Routes</th>
                                                        <th scope="col">Unit weight</th>
                                                        <th scope="col">Price per kls.</th>
                                                        <th scope="col">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($billingDetails as $b)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>{{ date('M d, Y', strtotime($b->transpo->booking->date)) }}</td>
                                                        <td>{{ $b->transpo->employee->user->name }} {{ $b->transpo->employee->user->lname }}</td>
                                                        <td>{{ $b->transpo->truck->plate_number }}</td>
                                                        <td class="text-uppercase">{{ $b->transpo->truck->truck_type }}</td>
                                                        <td>{{ $b->transpo->booking->origin }}-{{ $b->transpo->booking->destination }}</td>
                                                        <td>{{ $b->tons }} Tons</td>
                                                        <td>&#8369; {{ number_format($b->price) }}</td>
                                                        <td>&#8369; {{ number_format($b->tons * $b->price) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="8" class="text-end">Total billing:</th>
                                                        <th>&#8369; {{ $billing->total_amount }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
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