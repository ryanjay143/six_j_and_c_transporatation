@extends('layouts.admin.billing')

@section('content')
    @include('sweetalert::alert')
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!-- <h2 class="mt-4">{{ __('Manage Billing') }}</h2><hr> -->
                    <div class="row">
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

                            <div class="container">
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-3">
                                        <form id="filterForm" action="{{ route('client.filter') }}" method="GET">
                                            <label for="">Filter Company name</label>
                                            <select class="form-select @error('client_id') is-invalid @enderror" id="clientSelect" name="client_id" aria-label="Default select example" required>
                                                <option value="">All</option>
                                                @foreach ($users as $client)
                                                    <option value="{{ $client->id }}" @if(request('client_id') == $client->id) selected @endif>{{ $client->name }}</option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                        <div id="start_date_input" class="col-sm-3">
                                            <input hidden="" type="date" class="form-control" name="start_date" placeholder="Start Date" aria-label="Start Date">
                                        </div>
                                        <div id="end_date_input" class="col-sm-3">
                                            <input hidden="" type="date" class="form-control" name="end_date" placeholder="End Date" aria-label="End Date">
                                        </div>

                                        <!-- <div class="col-sm-3 align-self-end">
                                            <button type="submit" class="btn btn-outline-primary w-100">Filter Date</button>
                                        </div> -->
                                    </form>
                                </div>

                            
                                    <div class="card mb-5">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="billing" class="table table-bordered table-hover">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th scope="col">Transportation Date</th>
                                                            <th scope="col">Company Name</th>
                                                            <th scope="col">Origin</th>
                                                            <th scope="col">Destination</th>
                                                            <th scope="col">Unit Weight</th>
                                                            <th scope="col">Price per tons</th>
                                                            <th scope="col">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $sortedTranspo = $transpo->sortBy('booking.transportation_date'); 
                                                            $totalAmount = 0;
                                                        @endphp
                                                        @foreach ($sortedTranspo as $t)
                                                            @if ($t->booking->tons !== null)
                                                                <tr>
                                                                    <td>{{ date('F j, Y', strtotime($t->booking->pickUp_date)) }}</td>
                                                                    <td>{{ $t->booking->user->name }}</td>
                                                                    <td>{{ $t->booking->origin }}</td>
                                                                    <td>{{ $t->booking->destination }}</td>
                                                                    <td>
                                                                        <div style="display: flex; align-items: center;">
                                                                            <input type="number" readonly class="form-control form-control-sm exp-tons border border-0" style="width: 70px;" value="{{ $t->booking->tons }}" aria-label="Tons" 
                                                                                pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAmount('{{ $loop->iteration }}'); updateTonsCopy(this.value, '{{ $loop->iteration }}'); checkAllRowsValidity();"
                                                                                data-iteration="{{ $loop->iteration }}">
                                                                            <span style="margin-left: -40px;">Tons</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control form-control-sm price" value="0" style="width: 100px;" aria-label="First name" pattern="[0-9]*" 
                                                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateAmount('{{ $loop->iteration }}'); updatePriceCopy('{{ $loop->iteration }}');"
                                                                        data-iteration="{{ $loop->iteration }}" id="price_{{ $loop->iteration }}" checkAllRowsValidity();>
                                                                    </td>
                                                                    <td class="amount" id="amount_{{ $loop->iteration }}"></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>

                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6" class="fw-bold text-end">Total Amount:</td>
                                                            <td colspan="0" class="fw-bold" id="totalAmount"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" class="fw-bold text-end"></td>
                                                            <td colspan="2">
                                                                <form action="{{ route('save.billing') }}" method="post">
                                                                    @csrf

                                                                    <input hidden="" type="text" name="client_id" id="clientNameInput" value="{{ old('client_id') }}">
                                                                    <div hidden="" id="start_date_input_copy" class="col-auto">
                                                                        <input type="date" class="form-control" name="start_date" placeholder="Start Date" aria-label="Start Date">
                                                                    </div>
                                                                    <div hidden="" id="end_date_input_copy" class="col-auto">
                                                                        <input type="date" class="form-control" name="end_date" placeholder="End Date" aria-label="End Date">
                                                                    </div>
                                                                    <input hidden="" type="text" name="totalAmount" class="form-control form-control-sm" id="totalAmountCopy">

                                                                    @php
                                                                        $sortedTranspo = $transpo->sortBy('booking.transportation_date'); 
                                                                        $totalAmount = 0;
                                                                    @endphp
                                                                    @foreach ($sortedTranspo as $t)
                                                                        @if ($t->booking->tons !== null)
                                                                            <input hidden="" name="transportation_id[]" type="text" value="{{ $t->id }}">
                                                                            <input type="text" hidden="" name="bStatus[]" value="1">
                                                                            <input hidden="" name="price[]" type="text" class="form-control form-control-sm price-copy" 
                                                                                aria-label="First name" pattern="[0-9]*"
                                                                                id="priceCopy_{{ $loop->iteration }}" readonly>
                                                                            <input hidden="" name="tons[]" type="text" class="form-control form-control-sm tons-copy" 
                                                                                value="{{ $t->booking->tons }}" aria-label="Tons" pattern="[0-9]*"
                                                                                id="tonsCopy_{{ $loop->iteration }}" readonly>
                                                                                <input type="text" hidden="" name="status" value="1">
                                                                        @endif
                                                                    @endforeach
                                                                   
                                                                    <div class="col-md-12 text-center">
                                                                        <button type="submit" class="btn btn-primary fw-bold btn-sm w-100" id="saveBillingBtn" disabled>Generate billing</button>
                                                                    </div>
                                                                </form>
                                                            </td>
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
    </div>

    
    


@endsection
