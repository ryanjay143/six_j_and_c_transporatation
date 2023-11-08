@extends('layouts.employee.payrollDetails')

@section('content')
@include('sweetalert::alert')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('employee.payroll') }}">Payroll details</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payslip</li>
                    </ol>
                </nav>
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
                                                    <div class="table-responsive">
                                                        <?php
                                                            // Sort the employees array so that drivers come first
                                                            $sortedDate = $payrollDetails ->sortBy(function ($payrollDetails ) {
                                                                return $payrollDetails->transportation->booking->date;
                                                            });                                    
                                                        ?>
                                                        <table class="table table-bordered table-hover">
                                                            <thead class="table-primary">
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Company name</th>
                                                                    <th scope="col">Route</th>
                                                                    <th scope="col">Delivered Date</th>
                                                                    <th scope="col">Rate</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($sortedDate as $p)
                                                                    <tr>
                                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                                        <td>{{ $p->transportation->booking->user->name }}</td>
                                                                        <td>{{ $p->transportation->booking->origin }}-{{ $p->transportation->booking->destination }}</td>
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
                                                                <tr>
                                                                    <td colspan="4" class="text-end fw-bold">Cash advance:</td>
                                                                    <td>&#8369; {{ number_format($payroll->ca_deduction, 2) }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4" class="text-end fw-bold">Damage deduction:</td>
                                                                    <td>&#8369; {{ number_format($payroll->df_deduction, 2) }}</td>
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
                                                            </tfoot>
                                                        </table>
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