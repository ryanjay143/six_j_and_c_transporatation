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
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <form class="row g-3 mb-3" id="dateFilterForm">
                                                <div class="col-md-4">
                                                    <label for="staticEmail2" class="fw-bold">From:</label>
                                                    <input type="date" class="form-control" name="from">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputPassword2" class="fw-bold">To:</label>
                                                    <input type="date" class="form-control" name="to">
                                                </div>
                                                <div class="col-sm-3 align-self-end">
                                                    <button type="submit" class="btn btn-outline-primary">Filter date</button>
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
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payroll as $p)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ \Carbon\Carbon::parse($p->payroll_start_date)->format('M. j') }}-{{ \Carbon\Carbon::parse($p->payroll_end_date)->format('j, Y') }}</td>

                                                            <td>&#8369; {{ number_format($p->ca_deduction, 2) }}</td>
                                                            <td>&#8369; {{ number_format($p->df_deduction,2 ) }}</td>
                                                            <td>&#8369; {{ number_format($p->total_deduction, 2) }}</td>
                                                            <td>&#8369; {{ $p->total_rate }}</td>
                                                            <td>
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
                                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Payroll report details</h1>
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
                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label fw-bold">Total transportation:</label>
                                                                                        <div class="col-sm-6">
                                                                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" 
                                                                                            value="{{ $countTransportation }}">
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
                                                                                                @foreach ($p->payrollDetails as $r)
                                                                                                    <tr>
                                                                                                        <th scope="row">{{ $r->transportation->booking->transportation_date }}</th>
                                                                                                        <td>{{ $r->transportation->booking->user->name }}</td>
                                                                                                        <td>{{ $r->transportation->booking->origin }} - {{ $r->transportation->booking->destination }}</td>
                                                                                                        <td>&#8369; {{ number_format($r->rate, 2) }}</td>
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