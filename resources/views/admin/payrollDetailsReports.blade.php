@extends('layouts.admin.payrollDetailsReports')

@section('content')
@include('sweetalert::alert')

        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4">{{ __('Payroll Details') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.reports') }}">{{ __('Reports') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Payroll Details') }}</li>
                            </ol>
                        </nav>
                        <!-- <hr class="color-info"> -->
                        <div class="row" id="printableForm">
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
                            </div>
                            <div class="container">
                                <strong>
                                    <p class="text-capitalize">Payslip for the month of {{ \Carbon\Carbon::parse($payroll->payroll_start_date)->format('F j') }}-{{ \Carbon\Carbon::parse($payroll->payroll_end_date)->format('j, Y') }}</p>
                                    <p class="text-primary text-uppercase">Emplyee Pay Salary</p>
                                </strong>
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-0 row align-items-center">
                                                <div class="col-sm-12 col-md-4 d-flex align-items-center">
                                                    <img id="profile-preview" class="me-3" width="250px" src="{{ $employee->photo ? asset('storage/' . $employee->photo) : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}">
                                                </div>
                                                <div class="col-sm-12 col-md-8">
                                                    <div class="mb-0 row text-start align-items-center"> <!-- Adjusted alignment class -->
                                                        <label for="staticEmail" class="col-sm-6 col-md-4 col-form-label fw-bold">{{ __('Employee Name:') }}</label> <!-- Adjusted column size -->
                                                        <div class="col-sm-6 col-md-8"> <!-- Adjusted column size -->
                                                            <input type="text" name="driver_name" readonly class="form-control-plaintext fst-normal" id="staticEmail" value="{{ $employee->user->name }} {{ $employee->user->lname }}">
                                                        </div>
                                                    </div>
                                                    <div class="mb-0 row text-start align-items-center"> <!-- Adjusted alignment class -->
                                                        <label for="staticEmail" class="col-sm-6 col-md-4 col-form-label fw-bold">{{ __('Contact Number:') }}</label> <!-- Adjusted column size -->
                                                        <div class="col-sm-6 col-md-8"> <!-- Adjusted column size -->
                                                            <input type="text" readonly class="form-control-plaintext fst-normal" id="staticEmail" value="{{ $employee->user->phone_num }}">
                                                        </div>
                                                    </div>
                                                    <div class="mb-0 row text-start align-items-center"> <!-- Adjusted alignment class -->
                                                        <label for="staticEmail" class="col-sm-6 col-md-4 col-form-label fw-bold">{{ __('Position:') }}</label> <!-- Adjusted column size -->
                                                        <div class="col-sm-6 col-md-8"> <!-- Adjusted column size -->
                                                            <input type="text" readonly class="form-control-plaintext fst-normal" id="staticEmail" value="{{ $employee->position == 0 ? 'Driver' : '' }} {{ $employee->position == 1 ? 'Helper' : '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card mb-3 mt-3 bg-light">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Company Name</th>
                                                        <th scope="col">Route</th>
                                                        <th scope="col">Delivery Date</th>
                                                        <th scope="col">Rate</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payrollDetails as $p)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ $p->transportation->booking->user->name }}</td>
                                                            <td>{{ $p->transportation->booking->origin }} - {{ $p->transportation->booking->destination }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($p->transportation->booking->date)->format('F j, Y') }}</td>
                                                            <td>&#8369; {{ number_format($p->rate, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4" class="text-end fw-bold">Total Rate:</td>
                                                        <td>&#8369; {{ number_format($payrollDetails->sum('rate'), 2) }}</td>
                                                    </tr>
                                                    <!-- Add other totals below, for example: -->
                                                    <tr>
                                                        <td colspan="4" class="text-end fw-bold">Total Deduction:</td>
                                                        <td>&#8369; {{ number_format($payroll->total_deduction, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-end fw-bold">Total Net Salary:</td>
                                                        <td>&#8369; {{ number_format($payroll->total_net_salary, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="text-end fw-bold">Total Balance Deduction:</td>
                                                        <td>
                                                            @if ($totalBalance != 0)
                                                                &#8369; {{ number_format($totalBalance, 2) }}
                                                            @else
                                                                No deduction found
                                                            @endif
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
                </main>
            </div>
        </div>

        
    
</script>


@endsection