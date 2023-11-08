@extends('layouts.admin.billing')

@section('content')
@include('sweetalert::alert')
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4">{{ __('View Billing') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.billing') }}">{{ __('Manage Billing') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('View Billing') }}</li>
                            </ol>
                        </nav>
                        <div class="row">
                            <div class="text-center mt-3">
                                <h4 class="text-primary fs-1">SIX J AND C <br> <span style="letter-spacing: 10px;">TRANSPORT</span> </h4>
                                <p class="lh-1 fw-bold">
                                    Padilla St., Zone 10, Impantao Bulua, Cagayan de Oro City, 9000 Philippines
                                </p>
                                <p class="lh-1 fw-bold" style="word-spacing: 10px;">
                                    NONE VAT REH-TIN 327-941-681-000 <span style="word-spacing: normal;">Contact No. 09757388692</span>
                                </p>
                            </div>
                            <hr class="bg-primary border-2 border-top border-primary">
                            <div class="container">
                                <div class="text-start p-3">
                                    <div class="mb-3 row fw-bold">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">Client Name:</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext fw-bold" id="staticEmail" value="{{ $users->name }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 row fw-bold">
                                        <label for="staticEmail" class="col-sm-2 col-form-label">Date:</label>
                                        <div class="col-sm-10">
                                            <input type="text" readonly class="form-control-plaintext fw-bold" id="staticEmail" value="{{ $date }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="">
                                    <div class="row">
                                        <form action="" class="row row-cols-lg-auto g-3 align-items-center">
                                            <div class="col-md-4 mb-3">
                                                <label for="start-date">Start Date</label>
                                                <input type="date" id="start-date" class="form-control" placeholder="Start Date" aria-label="Start Date">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="end-date">End Date</label>
                                                <input type="date" id="end-date" class="form-control" placeholder="End Date" aria-label="End Date">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Filter Date</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="container">
                                <div class="card mt-3 mb-5 bg-light">
                                    <div class="card-body">
                                       <div class="table-responsive">
                                       <table id="example" class="table table-bordered table table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Transportation Date</th>
                                                    <th scope="col">Plate Number</th>
                                                    <th scope="col">Truck Type</th>
                                                    <th scope="col">Origin</th>
                                                    <th scope="col">Destination</th>
                                                    <th scope="col">Price/kls.</th>
                                                    <th scope="col">Unit Weight</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totalAmount = 0;
                                                @endphp
                                                @foreach ($transpo as $t)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>{{ $t->booking->date }}</td>
                                                        <td class="text-uppercase">{{ $t->truck->plate_number }}</td>
                                                        <td>{{ $t->truck->truck_type }}</td>
                                                        <td>{{ $t->booking->origin }}</td>
                                                        <td>{{ $t->booking->destination }}</td>
                                                        <td>
                                                            @if ($t->billing)
                                                                {{ number_format($t->billing->price, 2) }}                                           
                                                            @else
                                                                Please enter the data.
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($t->billing)
                                                                {{ $t->billing->tons }} Tons
                                                            @else
                                                                Please enter the data.
                                                            @endif
                                                        </td>
                                                        <td class="amount">
                                                            @if ($t->billing)
                                                                @php
                                                                    $amount = $t->billing->price * $t->billing->tons;
                                                                    $totalAmount += $amount;
                                                                @endphp
                                                               {{ $amount }} 
                                                            @else
                                                                Please enter the data.
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                            @if ($t->billing)
                                                                <button type="button" class="btn btn-light text-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $t->id }}" disabled><i class="fas fa-pen"></i></button>
                                                            @else
                                                                <button type="button" class="btn btn-light text-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $t->id }}"><i class="fas fa-pen"></i></button>
                                                            @endif

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="exampleModal{{ $t->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Input Billing Details') }}</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('billing.details', $t->id) }}" method="post">
                                                                                @csrf
                                                                                <input type="text" name="transpo_id" id="transpo_id" hidden="" value="{{ $t->id }}">
                                                                                <div class="form-floating mb-3">
                                                                                    <input type="number" min="1" class="form-control" id="price" name="price" placeholder="Enter Price" required>
                                                                                    <label for="floatingInput">{{ __('Enter Price/kls.') }}</label>
                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <input type="number" id="tons" min="1" name="tons" class="form-control" placeholder="Unit Weight" required>
                                                                                    <span class="input-group-text bg-light">Tons</span>
                                                                                </div>
                                                                                <div class="d-grid gap-2">
                                                                                    <button class="btn btn-primary btn-sm" type="submit">Save</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if ($t->billing)
                                                                <button type="button" class="btn btn-light text-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1{{ $t->id }}"><i class="fas fa-eye"></i></button>
                                                            @else
                                                                <button type="button" class="btn btn-light text-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal1{{ $t->id }}" disabled><i class="fas fa-eye"></i></button>
                                                            @endif
                                                                
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="exampleModal1{{ $t->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Update Billing Details') }}</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                        <form action="{{ route('update.billing', $t->id) }}" method="post">
                                                                            @csrf
                                                                            @method('PUT') <!-- Include this to specify the HTTP method as PUT -->

                                                                            @if ($t->billing)
                                                                                <div class="form-floating mb-3">
                                                                                    <input type="number" min="1" class="form-control" id="price" name="price" value="{{ $t->billing->price }}" required>
                                                                                    <label for="floatingInput">{{ __('Update Price/kls.') }}</label>
                                                                                </div>
                                                                                <div class="input-group mb-3">
                                                                                    <input type="number" id="tons" min="1" name="tons" class="form-control" value="{{ $t->billing->tons }}" required>
                                                                                    <span class="input-group-text bg-light">{{ __('Tons') }}</span>
                                                                                </div>
                                                                                <div class="d-grid gap-2">
                                                                                    <button class="btn btn-primary btn-sm" type="submit">{{ __('Update') }}</button>
                                                                                </div>
                                                                            @else
                                                                                <p>No billing details available.</p>
                                                                            @endif
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
                                            <tfoot>
                                                <tr>
                                                    <td colspan="8" class="fw-bold text-end">Total Amount:</td>
                                                    <td id="totalAmount" ></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
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