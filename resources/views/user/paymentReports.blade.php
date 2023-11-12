@extends('layouts.user.paymentReports')
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
                        <li class="breadcrumb-item"><a href="{{ route('user.reports.payment') }}">Payment reports</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payment details</li>
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
                                        <div class=" row">
                                            <label for="staticEmail" class="col-sm-6 col-form-label fw-bold ml-3">OR number:</label>
                                            <div class="col-sm-4">
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $payment->or_num }}">
                                            </div>
                                        </div>
                                        <div class=" row">
                                            <label for="staticEmail" class="col-sm-6 col-form-label fw-bold ml-3">Payment Method:</label>
                                            <div class="col-sm-4">
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $payment->payment_method }}">
                                            </div>
                                        </div>
                                        <div class=" row">
                                            <label for="staticEmail" class="col-sm-6 col-form-label fw-bold ml-3">Invoice Number:</label>
                                            <div class="col-sm-4">
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $payment->billing->invoice_num }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="staticEmail" class="col-sm-6 col-form-label fw-bold ml-3">Reference number:</label>
                                            <div class="col-sm-4">
                                                @if ($payment->ref_num)
                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $payment->ref_num }}">
                                                @elseif ($payment->chique_num)
                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $payment->chique_num }}">
                                                @else
                                                    <span class="badge bg-secondary">None</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class=" row">
                                            <label for="staticEmail" class="col-sm-6 col-form-label fw-bold ml-3">Date today:</label>
                                            <div class="col-sm-4">
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $currentDate }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php
                                                $transportationDate = $billingDetails ->sortBy(function ($billingDetails) {
                                                    return $billingDetails->transpo->booking->date;
                                                });                                    
                                            ?>
                                            <table class="table letter-size table-hover table-bordered">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Transportation date</th>
                                                        <th scope="col">Driver</th>
                                                        <th scope="col">Plate No.</th>
                                                        <th scope="col">Routes</th>
                                                        <th scope="col">Unit weight</th>
                                                        <th scope="col">Price per kilos</th>
                                                        <th scope="col">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($transportationDate as $b)
                                                        <tr>
                                                            <th class="text-dark" scope="row">{{ $loop->iteration }}</th>
                                                            <td class="text-dark">{{ date('M d, Y', strtotime($b->transpo->booking->date)) }}</td>
                                                            <td class="text-dark">{{ $b->transpo->employee->user->name }} {{ $b->transpo->employee->user->lname }}</td>
                                                            <td class="text-dark">{{ $b->transpo->truck->plate_number }}</td>
                                                            <td class="text-dark">{{ $b->transpo->booking->origin }}-{{ $b->transpo->booking->destination }}</td>
                                                            <td class="text-dark">{{ $b->tons }} Tons</td>
                                                            <td class="text-dark">&#8369; {{ number_format($b->price, 2) }}</td>
                                                            <td class="text-dark">&#8369; {{ number_format($b->tons * $b->price, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="7" class="text-end text-dark">Total Amount:</th>
                                                        <td class="text-dark">&#8369; {{ number_format($payment->amount, 2) }}</td>
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