@extends('layouts.admin.payroll')

@section('content')
@include('sweetalert::alert')

        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4">{{ __('List of Employee') }}</h2>
                        <div class="row">
                            <div class="container">
                                <div class="card mb-3 bg-light">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php
                                                // Sort the employees array so that drivers come first
                                                $sortedEmployees = $employees->sortBy(function ($employee) {
                                                    return $employee->position;
                                                });

                                                // Use the sorted employees array to generate the table rows
                                            ?>
                                            <table id="example" class="table table-bordered table-hover">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Employee name</th>
                                                        <th scope="col">Position</th>
                                                        <th scope="col">Cash Adv. Bal.</th>
                                                        <th scope="col">Damage Ded. Bal.</th>
                                                        <th scope="col">Total balance</th>
                                                        <th scope="col">Manage payroll</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sortedEmployees as $e)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $e->user->name }} {{ $e->user->lname }}</td>
                                                            <td>
                                                                @if ($e->position == 0)
                                                                   Driver
                                                                @elseif ($e->position == 1)
                                                                    Helper
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($totalCashAdvances[$e->id] == 0)
                                                                    <span class="text-dark">No cash advance</span>
                                                                @else
                                                                    &#8369; {{ number_format($totalCashAdvances[$e->id], 2) }}
                                                                @endif
                                                            </td> 
                                                            <td>
                                                                @if ($totalDamages[$e->id] == 0)
                                                                    <span class="text-dark">No damage deduction</span>
                                                                @else
                                                                    &#8369; {{ number_format($totalDamages[$e->id], 2) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ( $totalCashAdvances[$e->id] + $totalDamages[$e->id] == 0)
                                                                    <span class="text-dark">No balance deduction</span>
                                                                @else
                                                                    &#8369; {{ number_format($totalCashAdvances[$e->id] + $totalDamages[$e->id], 2) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('view.payroll', $e->id) }}" type="button" class="btn btn-outline-primary btn-sm">{{ __('View Payroll') }}</a>
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