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
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active position-relative" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Driver <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    {{ $driversCount }}
                                                    <span class="visually-hidden">unread messages</span>
                                                    </span>
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link position-relative" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Helper  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                       {{ $helpersCount }}
                                                        <span class="visually-hidden">unread messages</span>
                                                    </span>
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="example" class="table table-bordered table-hover">
                                                            <thead class="table-primary">
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Employee name</th>
                                                                    <th scope="col">Cash Adv. Bal.</th>
                                                                    <th scope="col">Damage Ded. Bal.</th>
                                                                    <th scope="col">Total balance</th>
                                                                    <th scope="col">Manage payroll</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($drivers as $e)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $e->user->name }} {{ $e->user->lname }}</td>
                                                                        <td>
                                                                            @if ($totalCashAdvancesDriver[$e->id] == 0)
                                                                                <span class="text-dark">No cash advance</span>
                                                                            @else
                                                                                &#8369; {{ number_format($totalCashAdvancesDriver[$e->id], 2) }}
                                                                            @endif
                                                                        </td> 
                                                                        <td>
                                                                            @if ($totalDamagesDriver[$e->id] == 0)
                                                                                <span class="text-dark">No damage deduction</span>
                                                                            @else
                                                                                &#8369; {{ number_format($totalDamagesDriver[$e->id], 2) }}
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ( $totalCashAdvancesDriver[$e->id] + $totalDamagesDriver[$e->id] == 0)
                                                                                <span class="text-dark">No balance deduction</span>
                                                                            @else
                                                                                &#8369; {{ number_format($totalCashAdvancesDriver[$e->id] + $totalDamagesDriver[$e->id], 2) }}
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ route('view.payroll', $e->id) }}" type="button" title="View payroll" class="btn btn-outline-primary btn-sm">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="examples" class="table table-bordered table-hover">
                                                            <thead class="table-primary">
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Employee name</th>
                                                                    <th scope="col">Cash Adv. Bal.</th>
                                                                    <th scope="col">Damage Ded. Bal.</th>
                                                                    <th scope="col">Total balance</th>
                                                                    <th scope="col">Manage payroll</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($helpers as $h)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $h->user->name }} {{ $h->user->lname }}</td>
                                                                        <td>
                                                                            @if ($totalCashAdvancesHelper[$h->id] == 0)
                                                                                <span class="text-dark">No cash advance</span>
                                                                            @else
                                                                                &#8369; {{ number_format($totalCashAdvancesHelper[$h->id], 2) }}
                                                                            @endif
                                                                        </td> 
                                                                        <td>
                                                                            @if ($totalDamagesHelper[$h->id] == 0)
                                                                                <span class="text-dark">No damage deduction</span>
                                                                            @else
                                                                                &#8369; {{ number_format($totalDamagesHelper[$h->id], 2) }}
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ( $totalCashAdvancesHelper[$h->id] + $totalDamagesHelper[$h->id] == 0)
                                                                                <span class="text-dark">No balance deduction</span>
                                                                            @else
                                                                                &#8369; {{ number_format($totalCashAdvancesHelper[$h->id] + $totalDamagesHelper[$h->id], 2) }}
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ route('view.payroll.for.helper', $h->id) }}" type="button" title="View payroll" class="btn btn-outline-primary btn-sm">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
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
                </main>
            </div>
        </div>


@endsection