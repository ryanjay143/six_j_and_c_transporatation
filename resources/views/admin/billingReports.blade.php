@extends('layouts.admin.reports')

@section('content')
@include('sweetalert::alert')
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4 mb-4">Billing Reports</h2>
                            <div class="row">
                                <div class="container">
                                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-secondary" onclick="printForm()">Print with PDF</button>
                                    </div>
                                    <div id="printableForm" class="card mb-3 print-form">
                                        <div class="card-body">                                 
                                            <div class="table-responsive">
                                                <div class="row g-3 mb-3">
                                                    <form id="filterForm" action="" method="GET">
                                                        <div class="d-flex">
                                                            <div class="col-sm-3 me-3">
                                                                <label>Search Invoice number</label>
                                                                <input type="text" class="form-control" id="search" name="search" placeholder="INV-0-00000000000">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for="">Company name</label>
                                                                <select class="form-select" id="clientSelect" name="client_id" aria-label="Default select example" required>
                                                                    <option value="">All</option>
                                                                    @foreach ($users as $client)
                                                                        <option value="{{ $client->id }}" @if(request('client_id') == $client->id) selected @endif>{{ $client->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('client_id')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <table id="billingReports" class="table table-hover table-bordered datatable-table ">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th class="fw-bold" scope="col">#</th>
                                                            <th class="fw-bold" scope="col">Client Name</th>
                                                            <th class="fw-bold" scope="col">Invoice Number</th>
                                                            <th class="fw-bold" scope="col">Billing Peroid</th>
                                                            <th class="fw-bold" scope="col">Amount</th>
                                                            <th class="fw-bold" scope="col">Payment status</th>
                                                            <th class="fw-bold action-column" scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="invoiceTableBody">
                                                        @foreach ($billing as $b)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $b->user->name }}</td>
                                                                <td>{{ $b->invoice_num }}</td>
                                                                <td>{{ date('M d', strtotime($b->billing_start_date)) }}-{{ date('d, Y', strtotime($b->billing_end_date)) }}</td>
                                                                <td data-amount="{{ $b->amount }}">&#8369; {{ $b->total_amount }}</td>
                                                                <td>
                                                                    @if ($b->status == 0)
                                                                        <span class="badge text-bg-dark">Pending for payment</span>
                                                                    @elseif ($b->status == 1)
                                                                        <span class="badge text-bg-success">Paid</span>
                                                                    @endif
                                                                </td>
                                                                <td class="action-column">
                                                                    <a href="{{ route('view.billing.details', $b->id) }}" type="button" class="btn btn-outline-primary btn-sm">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>

                                                                    <button type="button" class="btn btn-outline-success btn-sm text-capitalize" data-bs-toggle="modal" data-bs-target="#paidModal{{ $b->id }}"  @if ($b->status == 1) disabled @endif>Paid</button>

                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="paidModal{{ $b->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Payment Details</h1>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="payment-row">
                                                                                        <form action="{{ route('billing.payment') }}" method="post">
                                                                                            @csrf
                                                                                            <div class="mb-3">
                                                                                                <input type="text" name="billing" value="{{ $b->id }}" hidden="">
                                                                                                <label for="formGroupExampleInput" class="form-label">Payment Method:</label>
                                                                                                <select class="form-select paymentSelect @error('payment') is-invalid @enderror" name="payment" aria-label="Payment Method">
                                                                                                    <option selected disabled>Select payment method</option>
                                                                                                    <option value="Cash">Cash</option>
                                                                                                    <option value="Bank Transfer">Bank Transfer</option>
                                                                                                    <option value="Cheque">Cheque</option>
                                                                                                </select>
                                                                                                @error('payment')
                                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                                @enderror
                                                                                            </div>
                                                                                            
                                                                                            <div class="payment-details" style="display: none;">
                                                                                                <!-- Add the unique identifier (e.g., $b->id) to the ID attributes for each row -->
                                                                                                <div class="chique-number" style="display: none;">
                                                                                                    <div class="mb-3">
                                                                                                        <label for="formGroupExampleInput" class="form-label">Cheque Number</label>
                                                                                                        <input type="text" class="form-control chique_input" name="chique" placeholder="Chique Number: xxx-xxx-xxx">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="reference-number" style="display: none;">
                                                                                                    <div class="mb-3">
                                                                                                        <label for="formGroupExampleInput" class="form-label">Bank Transfer</label>
                                                                                                        <input type="text" class="form-control reference_input" name="refNum" placeholder="Reference Number: xxx-xxx-xxx">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="cash" style="display: none;">
                                                                                                    <div class="mb-3">
                                                                                                        <label for="total_amount" class="form-label">Total Amount</label>
                                                                                                        @php
                                                                                                            // Remove commas from the total_amount value
                                                                                                            $totalAmount = str_replace(',', '', $b->total_amount);
                                                                                                        @endphp
                                                                                                        <input type="text" readonly class="form-control total_amount" name="amount" value="{{ $totalAmount }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <button type="submit" class="btn btn-success btn-sm float-end" disabled>Submit</button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <!-- <tfoot>
                                                        <tr>
                                                            <td colspan="3"></td>
                                                            <td ><strong>Total Amount:</strong></td>
                                                            <td id="totalAmountCell"><strong>&#8369;</strong></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot> -->
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