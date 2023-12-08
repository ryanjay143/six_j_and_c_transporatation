@extends('layouts.admin.payrollDetails')

@section('content')
@include('sweetalert::alert')

        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="container">
                                <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.payrollReports') }}">List of employee</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Payroll Reports</li>
                                </ol>
                                </nav>
                                <div class="btn-group mb-3" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-secondary" onclick="printForm()">Print with PDF</button>
                                </div>
                                <div class="card print-form" id="printableForm">
                                    <div class="card-body">
                                        <h3 class="mb-3 text-secondary">Overall payroll reports for {{ $employee->user->name }} {{ $employee->user->lname }}</h3>
                                        <div class="table-responsive">
                                            <form action="{{ route('admin.payrollFilterReports') }}" class="row g-3 mb-3" method="get">
                                                <input type="text" hidden="" name="employee_id" value="{{ $employee->id }}">
                                                <div class="col-md-4 action-column">
                                                    <label for="staticEmail2" class="fw-bold">From:</label>
                                                    <input type="date" class="form-control  " name="payroll_start_date" value="{{ $payroll_start_date }}">
                                                </div>
                                                <div class="col-md-4 action-column">
                                                    <label for="inputPassword2" class="fw-bold">To:</label>
                                                    <input type="date" class="form-control " name="payroll_end_date" value="{{ $payroll_end_date }}">
                                                </div>
                                                <div class="col-sm-3 align-self-end ">
                                                    <button type="submit" class="btn btn-outline-primary action-column">Filter date</button>
                                                </div>
                                            </form>
                                            <table id="payrollReports" class="table table-bordered table-hover">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Payroll period</th>
                                                        <th scope="col">Cash advance deduction</th>
                                                        <th scope="col">Damage deduction</th>
                                                        <th scope="col">Total deduction deduction</th>
                                                        <th scope="col">Total rate</th>
                                                        <th class="action-column" scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payroll as $p)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ \Carbon\Carbon::parse($p->payroll_start_date)->format('M. j') }}-{{ \Carbon\Carbon::parse($p->payroll_end_date)->format('j, Y') }}</td>
                                                            <td>
                                                                @if ($p->ca_deduction == 0)
                                                                    <span>No CA deduction</span>
                                                                @else
                                                                    &#8369; {{ number_format($p->ca_deduction, 2) }}
                                                                @endif
                                                            </td>

                                                            <td>
                                                                @if ($p->df_deduction == 0)
                                                                    <span>No DF deduction</span>
                                                                @else
                                                                    &#8369; {{ number_format($p->df_deduction,2 ) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($p->total_deduction == 0) 
                                                                    <span>No Total deduction found</span>
                                                                @else
                                                                    &#8369; {{ number_format($p->total_deduction, 2) }}
                                                                @endif
                                                            </td>
                                                            <td>&#8369; {{ number_format($p->total_rate, 2) }}</td>
                                                            <td class="action-column">
                                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" 
                                                                    data-bs-target="#exampleModal{{ $p->id }}">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="exampleModal{{ $p->id }}" tabindex="-1" 
                                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Payroll Report Details</h1>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="container">
                                                                                    <div class="row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label fw-bold">
                                                                                            Employee name:
                                                                                        </label>
                                                                                        <div class="col-sm-6">
                                                                                            <input type="text" readonly class="form-control-plaintext" 
                                                                                            id="staticEmail" value="{{ $employee->user->name }} {{ $employee->user->lname }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label fw-bold">Pay Peroid Start:</label>
                                                                                        <div class="col-sm-6">
                                                                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" 
                                                                                            value="{{ \Carbon\Carbon::parse($p->payroll_start_date)->format('M. j, Y') }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label fw-bold">Pay Peroid End:</label>
                                                                                        <div class="col-sm-6">
                                                                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" 
                                                                                            value="{{ \Carbon\Carbon::parse($p->payroll_end_date)->format('M. j, Y') }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label fw-bold">Pay Date:</label>
                                                                                        <div class="col-sm-6">
                                                                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" 
                                                                                            value="{{ $p->updated_at->format('F d, Y') }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-bordered table-hover">
                                                                                            <thead class="table-primary">
                                                                                                <tr>
                                                                                                    <th scope="col">Delivered date</th>
                                                                                                    <th scope="col">Company name</th>
                                                                                                    <th scope="col">Route</th>
                                                                                                    <th scope="col">Rate</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @php
                                                                                                    $totalRate = 0;
                                                                                                @endphp
                                                                                                @foreach ($p->payrollDetails as $r)
                                                                                                    <tr>
                                                                                                        <td>{{ \Carbon\Carbon::parse($r->transportation->booking->transportation_date)->format('F d, Y') }}</td>
                                                                                                        <td>{{ $r->transportation->booking->user->name }}</td>
                                                                                                        <td>{{ $r->transportation->booking->origin }} - {{ $r->transportation->booking->destination }}</td>
                                                                                                        <td>&#8369; {{ number_format($r->rate, 2) }}</td>
                                                                                                    </tr>
                                                                                                    @php
                                                                                                        $totalRate += $r->rate;
                                                                                                    @endphp
                                                                                                @endforeach
                                                                                            </tbody>
                                                                                            <tfoot>
                                                                                                <tr>
                                                                                                    <td colspan="3" class="fw-bold">Total Rate:</td>
                                                                                                    <td class="fw-bold">&#8369; {{ number_format($totalRate, 2) }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="fw-bold" colspan="3">Cash advanve deduction:</td>
                                                                                                    <td class="fw-bold">&#8369; {{ number_format($p->ca_deduction, 2) }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="fw-bold" colspan="3">Damage Deduction:</td>
                                                                                                    <td class="fw-bold">&#8369; {{ number_format($p->df_deduction, 2) }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="fw-bold" colspan="3">Total deduction:</td>
                                                                                                    <td class="fw-bold">&#8369; {{ number_format($p->total_deduction, 2) }}</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="fw-bold" colspan="3">Total net salary:</td>
                                                                                                    <td class="fw-bold">&#8369; {{ number_format($p->total_net_salary,2 )  }} </td>
                                                                                                </tr>
                                                                                            </tfoot>
                                                                                        </table>
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
                </main>
            </div>
        </div>

        
    
</script>


@endsection