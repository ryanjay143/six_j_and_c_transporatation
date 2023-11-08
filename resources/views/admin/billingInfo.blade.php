@extends('layouts.admin.billingInfo')

@section('content')
@include('sweetalert::alert')
        <div id="layoutSidenav">
            <div id="layoutSidenav_content" >
                <main >
                    <div class="container-fluid px-4" >
                        <h3 class="mt-4">List of Billing</h3>
                         
                        <div class="row">
                            <div class="container">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-hover table-bordered datatable-table">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Client Name</th>
                                                        <th scope="col">Billing Period</th>
                                                        <th scope="col">Total Amount</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($billing as $b)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ $b->user->name }}</td>
                                                            <td>
                                                                {{ date('F j, Y', strtotime($b->billing_start_date)) }} - {{ date('F j, Y', strtotime($b->billing_end_date)) }}
                                                            </td>
                                                            <td>&#8369; {{ $b->total_amount }}</td>
                                                            <td>
                                                                @if ($b->status == 0)
                                                                    <span class="badge text-bg-secondary">Unpaid</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('view.billing.details',$b->id) }}" type="button" class="btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                                <button type="button" class="btn btn-outline-danger btn-sm delete-button" data-id="{{ $b->id }}" data-delete-url="{{ route('delete.billing', ['id' => $b->id]) }}">
                                                                    <i class="fas fa-trash-can"></i>
                                                                </button>
                                                                
                                                                <!-- Modal for Delete Confirmation -->
                                                                <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Are you sure you want to delete this billing?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#paidModal{{ $b->id }}">Paid</button>

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
