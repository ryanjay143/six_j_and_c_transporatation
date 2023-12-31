@extends('layouts.admin.billingreports')

@section('content')
    @include('sweetalert::alert')
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h2 class="mt-4">Billing Report Details</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page" ><a href="{{ route('admin.reports')}}">{{ __('Reports') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Billing Report Details') }}</li>
                            </ol>
                        </nav>
                    </nav>
                    <div id="printableForm" class="card mb-5 print-form">
                        <div  class="row ">
                            <div class="container">
                                <div class="text-center mt-3">
                                    <h4 class="text-primary fs-1">SIX J AND C <br> <span style="letter-spacing: 10px;">TRANSPORT</span> </h4>
                                    <p class="lh-1 fw-bold">
                                        Padilla St., Zone 10, Impantao Bulua, Cagayan de Oro City, 9000 Philippines
                                    </p>
                                    <p class="lh-1 fw-bold" style="word-spacing: 10px;">
                                        NONE VAT REH-TIN 327-941-681-000 <span style="word-spacing: normal;">Contact No. 09757388692</span>
                                    </p>
                                    <hr class="bg-primary border-2 border-top border-primary">
                                </div>
                                <div class="card-body">
                                    <div class=" row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label fw-bold ml-3">OR number:</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $payment->or_num }}">
                                        </div>
                                    </div>
                                    <div class=" row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label fw-bold ml-3">Client Name:</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $payment->billing->user->name }}">
                                        </div>
                                    </div>
                                    <div class=" row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label fw-bold ml-3">Payment Method:</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $payment->payment_method }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label fw-bold ml-3">Reference number:</label>
                                        <div class="col-sm-10">
                                            @if ($payment->ref_num)
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $payment->ref_num }}">
                                            @elseif ($payment->chique_num)
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $payment->chique_num }}">
                                            @else
                                                <span class="badge text-bg-secondary">None</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class=" row">
                                        <label for="staticEmail" class="col-sm-2 col-form-label fw-bold ml-3">Date today:</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $currentDate }}">
                                        </div>
                                    </div>
                                </div>
                                

                                <p class="fst-normal text-center mt-5">This is to bill you the various services rendered for the period of {{ date('F j, Y', strtotime($payment->billing->billing_start_date)) }} - {{ date('F j, Y', strtotime($payment->billing->billing_end_date)) }}</p>

                                        <div class="container-fluid">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="printForm()"> <i class="fas fa-print"></i> Print</button>
                                                    </div>
                                                    <table class="table table-hover table-striped table-bordered">
                                                        <thead class="table-primary">
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Transportation Date</th>
                                                                <th scope="col">Driver</th>
                                                                <th scope="col">Plate No.</th>
                                                                <th scope="col">Truck Type</th>
                                                                <th scope="col">Routes</th>
                                                                <th scope="col">Unit Weight</th>
                                                                <th scope="col">Price/kls</th>
                                                                <th scope="col">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($billingDetails as $billings)
                                                                <tr>
                                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                                    <td>{{ \Carbon\Carbon::parse($billings->transpo->booking->date)->format('F j, Y') }}</td>
                                                                    <td>{{ $billings->transpo->employee->user->name }} {{ $billings->transpo->employee->user->lname }}</td>
                                                                    <td class="text-uppercase">{{ $billings->transpo->truck->plate_number }}</td>
                                                                    <td class="text-uppercase">{{ $billings->transpo->truck->truck_type }}</td>
                                                                    <td>{{ $billings->transpo->booking->origin }} - {{ $billings->transpo->booking->destination }}</td>
                                                                    <td>{{ $billings->tons }} Tons</td>
                                                                    <td>&#8369; {{ number_format($billings->price, 2, '.', ',') }}</td>
                                                                    <td>&#8369; {{ number_format( $billings->tons * $billings->price ) }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="8" class="fw-bold text-end">Total Amount:</td>
                                                                <td class="fw-bold">&#8369; {{ $payment->billing->total_amount }}</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                
                                            </div>
                                            <div class="container text-center">
                                                <div class="row row-cols-2">
                                                    <div class="col">
                                                        <p class="text-start mt-5">Thank you for availing our services.</p>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3 row mt-5">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Prepared by:</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="Joel E. Amit">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3 row">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Received by:</label>
                                                            <div class="col-sm-6">
                                                                <p class="form-control-plaintext"></p>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="mb-3 row">
                                                            <label for="staticEmail" class="col-sm-4 col-form-label">Checked by:</label>
                                                            <div class="col-sm-6">
                                                                <p class="form-control-plaintext"></p>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
