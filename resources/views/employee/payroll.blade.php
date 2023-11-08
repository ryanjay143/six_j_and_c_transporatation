@extends('layouts.employee.payroll')

@section('content')
@include('sweetalert::alert')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <!-- <h3>{{ __('Payroll Details') }}</h3> -->
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="page-content">
                            <section class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card mr-sm-3 border border-primary w-100">
                                                <div class="card-body">
                                                    <nav>
                                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                        <button class="nav-link active me-2" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Payroll Reports</button>
                                                        <button class="nav-link me-2" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Unpaid Payroll</button>
                                                        <button class="nav-link me-2" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Cash advance record</button>
                                                        <button class="nav-link me-2" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled" type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">Damage details record</button>
                                                    </div>
                                                    </nav>
                                                    <div class="tab-content" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                                            <div class="card-body"> 
                                                                <div class="row g-3 mb-3 mt-3">
                                                                    <form id="filterForm" action="" method="GET" class="row">
                                                                        <div class="col-sm-3">
                                                                            <label for="start_date">From:</label>
                                                                            <input type="date" class="form-control" name="start_date" id="start_date" placeholder="Start Date" aria-label="Start Date" value="" required>
                                                                            @error('start_date')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <label for="end_date">To:</label>
                                                                            <input type="date" class="form-control" name="end_date" id="end_date" placeholder="End Date" aria-label="End Date" value="" required>
                                                                            @error('end_date')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-sm-3 align-self-end">
                                                                            <button type="submit" class="btn btn-outline-primary w-100">Filter Date</button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table id="table" class="table table-bordered letter-size table-hover">
                                                                            <thead class="table-primary">
                                                                                <tr>
                                                                                    <th scope="col">#</th>
                                                                                    <th scope="col">Payroll period</th>
                                                                                    <th scope="col">Cash advance deduction</th>
                                                                                    <th scope="col">Damage deduction</th>
                                                                                    <th scope="col">Total deduction</th>
                                                                                    <th scope="col">Total rate</th>
                                                                                    <th scope="col">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($payroll as $p)
                                                                                    <tr>
                                                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                                                        <td>
                                                                                            {{ date('M. d', strtotime($p->payroll_start_date)) }}-{{ date('d Y', strtotime($p->payroll_end_date)) }}
                                                                                        </td>
                                                                                        <td>&#8369; {{ number_format($p->ca_deduction, 2) }}</td>
                                                                                        <td>&#8369; {{ number_format($p->df_deduction, 2) }}</td>
                                                                                        <td>&#8369; {{ number_format($p->total_deduction, 2) }}</td>
                                                                                        <td>&#8369; {{ $p->total_rate }}</td>
                                                                                        <td>
                                                                                            <button type="button" class="btn btn-outline-primary btn-sm">
                                                                                                <i class="fas fa-eye"></i>
                                                                                            </button>
                                                                                        
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table id="examples" class="table table-hover table-bordered letter-size">
                                                                        <thead class="table-primary">
                                                                            <tr>
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">Pay Period</th>
                                                                                <th scope="col">Net Salary</th>
                                                                                <th scope="col">Status</th>
                                                                                <th scope="col">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($unpaidPayroll as $p)
                                                                                <tr>
                                                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                                                    <td>{{ \Carbon\Carbon::parse($p->payroll_start_date)->format('F j') }}-{{ \Carbon\Carbon::parse($p->payroll_end_date)->format('j, Y') }}</td>
                                                                                    <td>&#8369; {{ number_format($p->total_net_salary, 2, '.', ',') }}</td>
                                                                                    <td>
                                                                                        @if ($p->status == 0)
                                                                                            <span class="badge bg-danger">Unpaid</span>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="{{ route('view.payroll.details.for.driver', $p->id) }}" type="button" class="btn btn-outline-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table id="example" class="table table-bordered letter-size">
                                                                        <thead class="table-primary">
                                                                            <tr>
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">Amount Balance</th>
                                                                                <th scope="col">Purpose</th>
                                                                                <th scope="col">Payemnt Sequence</th>
                                                                                <th scope="col">Status</th>
                                                                                <th scope="col">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($cashAdvance as $c)
                                                                                <tr>
                                                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                                                    <td>&#8369; {{ number_format($c->amount) }}</td>
                                                                                    <td>{{ $c->purpose }}</td>
                                                                                    <td>{{ $c->pay_seq }}</td>
                                                                                    <td>
                                                                                        @if ($c->status == 0)
                                                                                            <span class="badge bg-danger">Not completed</span>
                                                                                        @elseif ($c->status == 1)
                                                                                            <span class="badge bg-success">Completed</span>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td>
                                                                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#cashAdvance{{ $c->id }}"><i class="fas fa-eye"></i></button>

                                                                                        <!-- Modal -->
                                                                                        <div class="modal fade cashAdvanceModal" id="cashAdvance{{ $c->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-id="{{ $c->id }}">
                                                                                            <div class="modal-dialog modal-lg">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cash advance details</h1>
                                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div class="card">
                                                                                                            <div class="card-body">
                                                                                                                <div class="row">
                                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Date Borrowed:</label>
                                                                                                                    <div class="col-sm-6">
                                                                                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ date('F d, Y', strtotime($c->created_at)) }}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="row">
                                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Borrowed Amount:</label>
                                                                                                                    <div class="col-sm-6">
                                                                                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="&#8369; {{ number_format($c->c_amount, 2) }}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="mb-3 row">
                                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Term:</label>
                                                                                                                    <div class="col-sm-6">
                                                                                                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $c->c_pay_sequence}}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="card border border-primary">
                                                                                                                    <div class="card-body">
                                                                                                                        <div class="table-responsive">
                                                                                                                            <table class="table table-bordered border-primary table-hover">
                                                                                                                                <thead class="table-primary">
                                                                                                                                    <tr>
                                                                                                                                        <th scope="col">Pay Date</th>
                                                                                                                                        <th scope="col">Paid Amount</th>
                                                                                                                                        <th scope="col">Remaining Balance</th>
                                                                                                                                    </tr>
                                                                                                                                </thead>
                                                                                                                                <tbody>
                                                                                                                                    @if ($c->caDetails->isEmpty())
                                                                                                                                        <tr>
                                                                                                                                            <td class="text-center" colspan="3">No data available</td>
                                                                                                                                        </tr>
                                                                                                                                    @else
                                                                                                                                    @foreach ($c->caDetails as $ca)
                                                                                                                                        <tr>
                                                                                                                                            <td>{{ date('F d, Y', strtotime($ca->created_at)) }}</td>
                                                                                                                                            <td>&#8369; {{ number_format($ca->paid_amount, 2) }}</td>
                                                                                                                                            <td>
                                                                                                                                                @if ($ca->balance == 0)
                                                                                                                                                    <span class="badge bg-success">Completed</span>
                                                                                                                                                @else
                                                                                                                                                    &#8369; {{ number_format($ca->balance, 2) }}
                                                                                                                                                @endif
                                                                                                                                            </td>

                                                                                                                                        </tr>
                                                                                                                                    @endforeach
                                                                                                                                    @endif
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
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">
                                                            <div class="card-body">
                                                                <div class="table-responsive">
                                                                    <table id="examples1" class="table table-bordered letter-size">
                                                                        <thead class="table-primary">
                                                                            <tr>
                                                                                <th scope="col">#</th>
                                                                                <th scope="col">Date Incidence</th>
                                                                                <th scope="col">Description</th>
                                                                                <th scope="col">Deduction Bal.</th>
                                                                                <th scope="col">Term</th>
                                                                                <th scope="col">Status</th>
                                                                                <th scope="col">Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($damage as $d)
                                                                                <tr>
                                                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                                                    <td>{{ \Carbon\Carbon::parse($d->date_of_incidence)->format('M. d, Y') }}</td>
                                                                                    <td>{{ $d->description }}</td>
                                                                                    <td>&#8369; {{ number_format($d->deduction, 2) }}</td>
                                                                                    <td>{{ $d->damage_sequence }}</td>
                                                                                    <td>
                                                                                        @if ($d->status == 0)
                                                                                            <span class="badge bg-danger">Not completed</span>
                                                                                        @elseif ($d->status == 1)
                                                                                            <span class="badge bg-success">Completed</span>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td>
                                                                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#damageModal{{ $d->id }}">
                                                                                            <i class="fas fa-eye"></i>
                                                                                        </button>

                                                                                        <!-- Modal -->
                                                                                        <div class="modal fade DamageModal" id="damageModal{{ $d->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-modal-id="{{ $d->id }}">
                                                                                            <div class="modal-dialog modal-lg">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Damage details</h1>
                                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div class="card">
                                                                                                            <div class="card-body">
                                                                                                                <div class="row">
                                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Date of Incidence:</label>
                                                                                                                    <div class="col-sm-4">
                                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ \Carbon\Carbon::parse($d->date_of_incidence)->format('F j, Y') }}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="row">
                                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Damage Amount:</label>
                                                                                                                    <div class="col-sm-4">
                                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="&#8369; {{ number_format($d->c_deduction,2) }}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="mb-3 row">
                                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Term:</label>
                                                                                                                    <div class="col-sm-4">
                                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $d->c_term }}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="card border border-primary">
                                                                                                                    <div class="card-body">
                                                                                                                        <div class="table-responsive">
                                                                                                                            <table class="table table-hover table-bordered">
                                                                                                                                <thead class="table-primary">
                                                                                                                                    <tr>
                                                                                                                                        <th scope="col">Pay Date</th>
                                                                                                                                        <th scope="col">Paid amount</th>
                                                                                                                                        <th scope="col">Remaining balance</th>
                                                                                                                                        
                                                                                                                                    </tr>
                                                                                                                                </thead>
                                                                                                                                <tbody>
                                                                                                                                    @if ($d->damageDetails->isEmpty())
                                                                                                                                        <tr>
                                                                                                                                            <td class="text-center" colspan="3">No data available</td>
                                                                                                                                        </tr>
                                                                                                                                    @else
                                                                                                                                    @foreach ($d->damageDetails as $da)
                                                                                                                                    <tr>
                                                                                                                                        <td>{{ $da->created_at->format('M. d, Y') }}</td>
                                                                                                                                        <td>&#8369; {{ number_format($da->paid_amount, 2) }}</td>
                                                                                                                                        <td>
                                                                                                                                            @if ($da->balance == 0)
                                                                                                                                                <span class="badge bg-success">Completed</span>
                                                                                                                                            @else
                                                                                                                                                &#8369; {{ number_format($da->balance, 2) }}
                                                                                                                                            @endif
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                    @endforeach
                                                                                                                                    @endif
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
                                        </div>
                                    </div>
                                </div>
                            </section>
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