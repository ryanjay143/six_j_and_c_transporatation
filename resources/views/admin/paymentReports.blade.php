@extends('layouts.admin.reports')

@section('content')
@include('sweetalert::alert')
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4 mb-4">Payment Reports</h2>
                            <div class="row">
                                <div class="container">
                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary" onclick="printForm()">Print with PDF</button>
                                    </div>
                                    <div id="printableForm" class="card mb-3 print-form">
                                        <div class="card-body">                                 
                                            <div class="table-responsive">
                                                <div class="row g-3 mb-3">
                                                    <div class="col-sm-3">
                                                        <form id="filterForm" action="{{ route('payment.filterClient') }}" method="GET">
                                                            <label for=""></label>
                                                            <div class="input-group mb-3">
                                                                <select class="form-select" id="clientSelect" name="client_id" aria-label="Default select example" required>
                                                                    <option selected disabled>Select Company</option>
                                                                    @foreach ($client as $c)
                                                                        <option value="{{ $c->id }}" @if(request('client_id') == $c->id) selected @endif>{{ $c->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <table id="paymentReports" class="table table-bordered table-hover">
                                                    <thead class="table-primary tsize">
                                                        <tr>
                                                            <th class="fw-bold" scope="col">#</th>
                                                            <th class="fw-bold" scope="col">Payment date</th>
                                                            <th class="fw-bold" scope="col">O.R number</th>
                                                            <th class="fw-bold" scope="col">Invoice Number</th>
                                                            <th class="fw-bold" scope="col">Client name</th>
                                                            <th class="fw-bold" scope="col">Payment method</th>
                                                            <th class="fw-bold" scope="col">Reference number</th>
                                                            <th class="fw-bold" scope="col">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="paymentRows" class="">
                                                        @foreach ($payments as $p)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $p->created_at->format('M. d, Y') }}</td>
                                                                <td>{{ substr($p->or_num, 0, 4) }}-{{ substr($p->or_num, 4, 2) }}-{{ substr($p->or_num, 6, 2) }}-{{ substr($p->or_num, 8) }}</td>
                                                                <td>{{ $p->billing->invoice_num }}</td>
                                                                <td>{{ $p->billing->user->name }}</td>
                                                                <td>{{ $p->payment_method }}</td>
                                                                <td>
                                                                    @if ( $p->ref_num)
                                                                        {{ $p->ref_num }}
                                                                    @else
                                                                        {{ $p->chique_num }}
                                                                    @endif
                                                                </td>
                                                                <td>&#8369; {{ number_format($p->amount, 2 ) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th class="fw-bold text-end" colspan="7">Total Payment Amount:</th>
                                                            <th class="fw-bold" id="totalPaymentAmount">0.00</th>
                                                        </tr>
                                                    </tfoot>
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