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
                                    <div class="card mb-3">
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
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for="start_date">From:</label>
                                                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" placeholder="Start Date" aria-label="Start Date" value="{{ old('start_date', $start_date ?? '') }}" required>
                                                            </div>
                                                            <div id="end_date_input" class="col-sm-3">
                                                                <label for="end_date">To:</label>
                                                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" placeholder="End Date" aria-label="End Date" value="{{ old('end_date', $end_date ?? '') }}" required>
                                                            </div>

                                                            <div class="col-sm-3 align-self-end mb-3">
                                                                <button type="submit" class="btn btn-outline-primary w-100">Filter Date</button>
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
                                                            <th class="fw-bold" scope="col">Cheque number</th>
                                                            <th class="fw-bold" scope="col">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="paymentRows" class="size">
                                                        @foreach ($payments as $p)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $p->created_at->format('M. d, Y') }}</td>
                                                                <td>{{ substr($p->or_num, 0, 4) }}-{{ substr($p->or_num, 4, 2) }}-{{ substr($p->or_num, 6, 2) }}-{{ substr($p->or_num, 8) }}</td>
                                                                <td>{{ $p->biiling->invoice_num }}</td>
                                                                <td>{{ $p->billing->user->name }}</td>
                                                                <td>{{ $p->payment_method }}</td>
                                                                <td>
                                                                    @if ( $p->ref_num)
                                                                        {{ $p->ref_num }}
                                                                    @else
                                                                        <span class="text-danger">--------None--------</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($p->chique_num)
                                                                        {{ $p->chique_num }}
                                                                    @else
                                                                        <span class="text-danger">-------None-------</span>
                                                                    @endif
                                                                </td>
                                                                <td>&#8369; {{ number_format($p->amount, 2 ) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th class="fw-bold" colspan="7">Total Amount:</th>
                                                            <th class="fw-bold" id="totalAmount">0.00</th>
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