@extends('layouts.admin.viewPayroll')

@section('content')
@include('sweetalert::alert')

        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.payroll') }}">{{ __('List of Employee') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Payroll') }}</li>
                            </ol>
                        </nav>
                        <!-- <hr class="color-info"> -->
                        <div class="row">
                        <hr class="bg-primary border-2 border-top border-primary">
                            <div class="container">
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-0 row align-items-center">
                                                <div class="col-sm-12 col-md-4 d-flex align-items-center">
                                                    <img id="profile-preview" class="me-3" width="120px" height="100vh" src="{{ $employee->photo ? asset('storage/' . $employee->photo) : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}">
                                                </div>
                                                <div class="col-sm-12 col-md-8">
                                                    <div class="row text-start align-items-center"> <!-- Adjusted alignment class -->
                                                        <label for="staticEmail" class="col-sm-6 col-md-4 col-form-label fw-bold">{{ __('Employee Name:') }}</label> <!-- Adjusted column size -->
                                                        <div class="col-sm-6 col-md-8"> <!-- Adjusted column size -->
                                                            <input type="text" name="driver_name" readonly class="form-control-plaintext fst-normal" id="staticEmail" value="{{ $employee->user->name }} {{ $employee->user->lname }}">
                                                        </div>
                                                    </div>
                                                    <div class="row text-start align-items-center"> <!-- Adjusted alignment class -->
                                                        <label for="staticEmail" class="col-sm-6 col-md-4 col-form-label fw-bold">{{ __('Contact Number:') }}</label> <!-- Adjusted column size -->
                                                        <div class="col-sm-6 col-md-8"> <!-- Adjusted column size -->
                                                            <input type="text" readonly class="form-control-plaintext fst-normal" id="staticEmail" value="{{ $employee->user->phone_num }}">
                                                        </div>
                                                    </div>
                                                    <div class="row text-start align-items-center"> <!-- Adjusted alignment class -->
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
                                <hr class="bg-primary border-2 border-top border-primary">
                                <div class="container">
                                    <form class="row g-3" method="GET" action="{{ route('filterTransportationDate') }}">
                                        <input type="hidden" name="employee_id" readonly class="form-control-plaintext" id="staticEmail" value="{{ $employee->id }}">
                                        
                                    </form>
                                    <div class="card mb-3 mt-3 bg-light">
                                        <div class="card-body">
                                        <!-- <h3 class="fw-bold text-start">Transportation Reports</h3> -->
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Delivery Reports</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link position-relative" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false">Unpaid Payroll
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                        {{ $employeePayrollCount }}
                                                        <span class="visually-hidden">unread messages</span>
                                                    </span>
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Cash advance Records</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Damage deduction Records</button>
                                            </li>
                                        </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table id="payroll" class="table table-bordered table-hover">
                                                                <thead class="table-primary">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Company Name</th>
                                                                        <th scope="col">Delivery Date</th>
                                                                        <th scope="col">Route</th>
                                                                        <th scope="col">Rates</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $sortedDriver = $driver->sortBy('booking.date');
                                                                        $sortedHelper = $helper->sortBy('booking.date');
                                                                    @endphp

                                                                    @foreach ($sortedDriver as $t)
                                                                        <tr>
                                                                            <input type="hidden" name="transpoId[]" value="{{ $t->id }}">
                                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                                            <td>{{ $t->booking->user->name }}</td>
                                                                            <td>{{ \Carbon\Carbon::parse($t->booking->date)->format('F j, Y') }}</td>
                                                                            <td>{{ $t->booking->origin }} - {{ $t->booking->destination }}</td>
                                                                            <td>
                                                                                <input type="text" style="width: 100px;" value="0" class="form-control form-control-sm rateInput"  id="rateInput_{{ $loop->iteration }}" oninput="updateTotal(); this.value = this.value.replace(/\D/g, '')">
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    @foreach ($sortedHelper as $h)
                                                                        <tr>
                                                                            <input type="hidden" name="transpoId[]" value="{{ $h->id }}">
                                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                                            <td>{{ $h->booking->user->name }}</td>
                                                                            <td>{{ \Carbon\Carbon::parse($h->booking->date)->format('F j, Y') }}</td>
                                                                            <td>{{ $h->booking->origin }} - {{ $h->booking->destination }}</td>
                                                                            <td>
                                                                                <input type="text" style="width: 100px;" value="0" class="form-control form-control-sm rateInput" oninput="updateTotal(); this.value = this.value.replace(/\D/g, '')">
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach

                                                                </tbody>
                                                                <tfoot class="table-hover">
                                                                    <tr>
                                                                        <td colspan="3" class="fw-bold text-end">Total Rate:</td>
                                                                        <td class="fw-bold" id="totalRate">0</td>
                                                                        <td></td>
                                                                    </tr>

                                                                    @php
                                                                        $cashAdvanceAmount = 0; // Initialize the cash advance amount to zero
                                                                        if ($cashAdvance && $cashAdvance->pay_seq > 0) {
                                                                            $cashAdvanceAmount = $cashAdvance->amount / $cashAdvance->pay_seq;
                                                                            $roundedCashAdvance = round($cashAdvanceAmount); // Round off the cash advance amount
                                                                        }
                                                                    @endphp

                                                                    <tr>
                                                                        <td colspan="3" class="fw-bold text-end">Cash Advance Deduction:</td>
                                                                        <td id="vale" class="fw-bold">
                                                                            @if ($cashAdvanceAmount > 0)
                                                                                <input readonly value="{{ $roundedCashAdvance }}" type="text" style="width: 100px;" class="form-control form-control-sm" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                                            @else
                                                                                <span class="badge rounded-pill text-bg-secondary">No Cash Advance for this employee</span>
                                                                            @endif
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>

                                                                    @php
                                                                        $damageAmount = 0; // Initialize the damage amount to zero
                                                                        if ($damages && $damages->damage_sequence > 0) {
                                                                            $damageAmount = $damages->deduction / $damages->damage_sequence;
                                                                            $roundedDamageAmount = round($damageAmount); // Round off the damage amount
                                                                        }
                                                                    @endphp

                                                                    <tr>
                                                                        <td colspan="3" class="fw-bold text-end">Damage Fees Deduction:</td>
                                                                        <td id="bangga" class="fw-bold">
                                                                            @if ($damageAmount > 0)
                                                                                <input readonly value="{{ $roundedDamageAmount }}" type="text" style="width: 100px;" class="form-control form-control-sm" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                                            @else
                                                                                <span class="badge rounded-pill text-bg-secondary">No damages found for this employee</span>
                                                                            @endif
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="3" class="fw-bold text-end">Total Deduction:</td>
                                                                        <td id="totalDeduction" class="fw-bold">
                                                                            @php
                                                                                $totalDeduction = (isset($cashAdvanceAmount) ? $cashAdvanceAmount : 0) + (isset($damageAmount) ? $damageAmount : 0);
                                                                                $roundedTotalDeduction = round($totalDeduction); // Round off the total deduction
                                                                            @endphp

                                                                            @if ($roundedTotalDeduction > 0)
                                                                                <input readonly value="{{ $roundedTotalDeduction }}" type="text" style="width: 100px;" class="form-control form-control-plaintext fw-bold" placeholder="0" id="numericInput" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateNetSalary();">
                                                                            @else
                                                                                No Deduction
                                                                            @endif
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="3" class="fw-bold text-end">Total Net Salary:</td>
                                                                        <td id="totalNetSalaryAmount" class="fw-bold">0</td>
                                                                        <td>
                                                                            <form action="{{ route('save.payroll') }}" method="post" id="payrollForm">
                                                                                @csrf
                                                                                <input type="text" hidden="" name="employee_id" value="{{ $employee->id }}">
                                                                                <input  id="totalNetSalaryInput" hidden="" name="total_net_salary" value="0">
                                                                                <input type="text" id="totalRateInput" name="total_rate" value="0" hidden="">

                                                                                @php
                                                                                    $cashAdvanceAmount = 0; // Initialize the cash advance amount to zero
                                                                                    $cashBalance = 0; // Initialize the cash balance to zero

                                                                                    if ($cashAdvance) {
                                                                                        if ($cashAdvance->pay_seq > 0) {
                                                                                            $cashAdvanceAmount = $cashAdvance->amount / $cashAdvance->pay_seq;
                                                                                            $roundedCashAdvanceAmount = round($cashAdvanceAmount); // Round off the cash advance amount
                                                                                        }

                                                                                        $cashBalance = $cashAdvance->amount - $roundedCashAdvanceAmount;
                                                                                    }
                                                                                @endphp

                                                                                <input type="text" hidden="" name="caId" value="{{ isset($cashAdvance) ? $cashAdvance->id : '' }}">
                                                                            
                                                                                <input type="text" hidden="" name="balance" value="{{ $cashBalance }}">

                                                                                @if ($cashAdvanceAmount > 0)
                                                                                    <input hidden="" name="ca_deduction" value="{{ $roundedCashAdvanceAmount }}" type="text" 
                                                                                    style="width: 100px;" class="form-control form-control-sm" placeholder="0" 
                                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                                                @endif


                                                                                @php
                                                                                    $damageAmount = 0; // Initialize the damage amount to zero
                                                                                    $balanceDeduction = 0;
                                                                                    if ($damages && $damages->damage_sequence > 0) {
                                                                                        $damageAmount = $damages->deduction / $damages->damage_sequence;
                                                                                        $balanceDeduction = $damages->deduction - $damageAmount;
                                                                                        $roundedDamageAmount = round($damageAmount); // Round off the damage amount
                                                                                    }
                                                                                @endphp

                                                                                @if ($damageAmount > 0)
                                                                                    <input hidden="" name="df_deduction" value="{{ $roundedDamageAmount }}" type="text" 
                                                                                    style="width: 100px;" class="form-control form-control-sm" placeholder="0" 
                                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                                                @endif
                                                                                <input type="text" hidden="" name="damage_id" value="{{ isset($damages) ? $damages->id : '' }}">
                                                                                <input type="text" hidden="" name="damage_amount" value="{{ $damageAmount }}">
                                                                                <input type="text" hidden="" name="balance_deduction" value="{{ $balanceDeduction }}">
                                                                            
                                                                                @php
                                                                                    $totalDeduction = (isset($cashAdvanceAmount) ? $cashAdvanceAmount : 0) + (isset($damageAmount) 
                                                                                    ? $damageAmount : 0);
                                                                                    $roundedTotalDeduction = round($totalDeduction); // Round off the total deduction
                                                                                @endphp

                                                                                @if ($roundedTotalDeduction > 0)
                                                                                    <input value="{{ $roundedTotalDeduction }}" hidden="" name="totalDeduction" type="text" 
                                                                                    style="width: 100px;" class="form-control form-control-plaintext fw-bold" placeholder="0" id="numericInput" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateNetSalary();">
                                                                                @endif

                                                                                
                                                                                <div class="col-auto">
                                                                                    <label for="inputCopyStartDate" class="visually-hidden">Copy Start Date</label>
                                                                                    <input hidden="" type="date" name="start_date" class="form-control form-control-sm" 
                                                                                    id="inputCopyStartDate" value="{{ $start_date ? date('Y-m-d', strtotime($start_date)) : '' }}">
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <label for="inputCopyEndDate" class="visually-hidden">Copy End Date</label>
                                                                                    <input hidden="" type="date" name="end_date" class="form-control form-control-sm" 
                                                                                    id="inputCopyEndDate" value="{{ $end_date ? date('Y-m-d', strtotime($end_date)) : '' }}">
                                                                                </div>

                                                                                @foreach ($driver as $t)
                                                                                    <input type="text" hidden="" name="transportation_id[]" value="{{ $t->id }}">
                                                                                    <input name="rate[]" hidden="" type="text" style="width: 100px;" value="0" 
                                                                                    class="form-control form-control-sm rateArrayInput" id="rateArrayInput_{{ $loop->iteration }}">
                                                                                    <input type="text" hidden="" value="1" name="pStatus">
                                                                                @endforeach

                                                                                @foreach ($helper as $h)
                                                                                    @php
                                                                                        $rateValueHelper = !empty($h->rate) ? $h->rate : 0;
                                                                                        $addRateButtonDisabledHelper = $rateValueHelper == 0;
                                                                                    @endphp
                                                                                    <input type="text" hidden="" name="transportation_id[]" value="{{ $h->id }}">
                                                                                    <input name="rate[]" hidden="" type="text" style="width: 100px;" value="{{ $rateValueHelper }}" 
                                                                                        class="form-control form-control-sm" id="numericInputCopy{{ $loop->iteration }}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); checkRateValueCopy({{ $loop->iteration }});">
                                                                                    <input type="text" hidden="" value="1" name="pStatus">
                                                                                @endforeach

                                                                                <button type="submit" class="btn btn-primary btn-sm w-100" id="savePayrollButton" disabled>
                                                                                    <i class="bi bi-file-earmark-check-fill"></i> Save Payroll
                                                                                </button>

                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                                <tfoot id="helperTfoot">
                                                                <tr>
                                                                    <td colspan="3" class="fw-bold text-end">Total Rate:</td>
                                                                    <td id="totalRate" class="fw-bold">0</td>
                                                                    <td></td>
                                                                </tr>

                    
                                                                @php
                                                                    $cashAdvanceAmountHelper = 0; // Initialize the cash advance amount for helper to zero
                                                                    if ($cashAdvanceHelper && $cashAdvanceHelper->pay_seq > 0) {
                                                                        $cashAdvanceAmountHelper = $cashAdvanceHelper->amount / $cashAdvanceHelper->pay_seq;
                                                                    }

                                                                    $damageAmountHelper = 0; // Initialize the damage amount for helper to zero
                                                                    if ($damagesHelper && $damagesHelper->damage_sequence > 0) {
                                                                        $damageAmountHelper = $damagesHelper->deduction / $damagesHelper->damage_sequence;
                                                                    }
                                                                @endphp

                                                                    <tr>
                                                                        <td colspan="3" class="fw-bold text-end">Cash Advance Deduction (Helper):</td>
                                                                        <td id="vale" class="fw-bold">
                                                                            @if ($cashAdvanceAmountHelper > 0)
                                                                                <input readonly value="{{ $cashAdvanceAmountHelper }}" type="text" style="width: 100px;" class="form-control form-control-sm" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                                            @else
                                                                                <span class="badge rounded-pill text-bg-secondary">No Cash Advance for this helper</span>
                                                                            @endif
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="3" class="fw-bold text-end">Damage Fees Deduction (Helper):</td>
                                                                        <td id="bangga" class="fw-bold">
                                                                            @if ($damageAmountHelper > 0)
                                                                                <input readonly value="{{ $damageAmountHelper }}" type="text" style="width: 100px;" class="form-control form-control-sm" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                                            @else
                                                                                <span class="badge rounded-pill text-bg-secondary">No damages found for this helper</span>
                                                                            @endif
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="3" class="fw-bold text-end">Total Deduction (Helper):</td>
                                                                        <td id="totalDeductionHelper" class="fw-bold">
                                                                            @php
                                                                                $totalDeductionHelper = (isset($cashAdvanceAmountHelper) ? $cashAdvanceAmountHelper : 0) + (isset($damageAmountHelper) ? $damageAmountHelper : 0);
                                                                            @endphp

                                                                            @if ($totalDeductionHelper > 0)
                                                                                <input readonly value="{{ $totalDeductionHelper }}" type="text" style="width: 100px;" class="form-control form-control-plaintext fw-bold" placeholder="0" id="numericInputHelper" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateHelperTotalDeduction();">
                                                                            @else
                                                                                No Deduction
                                                                            @endif
                                                                        </td>
                                                                        <td></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="3" class="fw-bold text-end">Total Net Salary (Helper):</td>
                                                                        <td id="totalNetSalaryAmountHelper" class="fw-bold">0</td>
                                                                        <td>
                                                                            <form action="{{ route('save.payroll') }}" method="post" id="payrollFormHelper">
                                                                                @csrf
                                                                                <input type="text" hidden=""  value="{{ $employee->id }}">
                                                                                <input type="text" hidden="" id="totalRateInputHelper">

                                                                                @php
                                                                                    $totalDeductionHelper = (isset($cashAdvanceAmountHelper) ? $cashAdvanceAmountHelper : 0) + (isset($damageAmountHelper) ? $damageAmountHelper : 0);
                                                                                @endphp

                                                                                @if ($totalDeductionHelper > 0)
                                                                                    <input value="{{ $totalDeductionHelper }}" hidden=""  type="text" style="width: 100px;" class="form-control form-control-plaintext fw-bold" placeholder="0" id="numericInputHelper" oninput="this.value = this.value.replace(/[^0-9]/g, ''); calculateHelperTotalDeduction();">
                                                                                @endif

                                                                                <input type="text" hidden=""  id="totalNetSalaryInputHelper" value="0">
                                                                                <div class="col-auto">
                                                                                    <label for="inputCopyStartDate" class="visually-hidden">Copy Start Date</label>
                                                                                    <input hidden="" type="date"  class="form-control form-control-sm" id="inputCopyStartDate" value="{{ $start_date ? date('Y-m-d', strtotime($start_date)) : '' }}">
                                                                                </div>
                                                                                <div class="col-auto">
                                                                                    <label for="inputCopyEndDate" class="visually-hidden">Copy End Date</label>
                                                                                    <input hidden="" type="date"  class="form-control form-control-sm" id="inputCopyEndDate" value="{{ $end_date ? date('Y-m-d', strtotime($end_date)) : '' }}">
                                                                                </div>

                                                                                @foreach ($helper as $h)
                                                                                    @php
                                                                                        $rateValueHelper = !empty($h->rate) ? $h->rate : 0;
                                                                                        $addRateButtonDisabledHelper = $rateValueHelper == 0;
                                                                                    @endphp
                                                                                    <input type="text" hidden=""  value="{{ $h->id }}">
                                                                                    <input  hidden="" type="text" style="width: 100px;" value="{{ $rateValueHelper }}" class="form-control form-control-sm" id="numericInputCopy{{ $loop->iteration }}" oninput="this.value = this.value.replace(/[^0-9]/g, ''); checkRateValueCopy({{ $loop->iteration }});">
                                                                                @endforeach

                                                                                <button type="submit" class="btn btn-primary btn-sm w-100" id="savePayrollButtonHelper" disabled>
                                                                                    <i class="bi bi-file-earmark-check-fill"></i> Save Payroll
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                        <button type="button" class="btn btn-outline-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal1{{ $employee->id }}" onclick="toggleCashAdvances({{ $employee->id }})"><i class="bi bi-plus-circle-fill"></i> {{ __('Add cash advance') }}</button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="exampleModal1{{ $employee->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add cash advance</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('cash.advance',$employee->id) }}" method="post">
                                                                                @csrf
                                                                                <input type="text" hidden="" class="form-control" name="employee_id" id="formGroupExampleInput" value="{{ $employee->id }}" required>
                                                                                <div class="mb-3">
                                                                                    <label for="formGroupExampleInput" class="form-label">Employee Name</label>
                                                                                    <input type="text" class="form-control" readonly id="formGroupExampleInput" value="{{ $employee->user->name }} {{ $employee->user->lname }}" required>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="amount">Amount</label>
                                                                                    <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter the cash advance amount" required>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="purpose">Purpose</label>
                                                                                    <textarea class="form-control"  id="purpose" name="purpose" rows="4" required placeholder="Enter the purpose of the cash advance"></textarea>
                                                                                </div>
                                                                                <div class="mb-3">
                                                                                    <label for="payment_sequence">Payment term</label>
                                                                                    <input type="number" class="form-control" min="0" id="payment_sequence" value="0" name="payment_sequence" placeholder="Enter the payment sequence for honle to pay" required>
                                                                                </div>
                                                                                <div class="d-grid gap-2">
                                                                                    <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <table id="cashAdvance_{{ $employee->id }}" class="table table-bordered table-hover">
                                                                <thead class="table-primary">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Date borrowed</th>
                                                                        <th scope="col">Amount Balance</th>
                                                                        <!-- <th scope="col">Purpose</th> -->
                                                                        <th scope="col">Remaining term</th>
                                                                        <th scope="col">Status</th>
                                                                        <th scope="col">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $firstRows = true;
                                                                    @endphp
                                                                        @foreach ($employee->cashAdvances->sortBy('created_at') as $cashAdvance)
                                                                        <tr>
                                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                                            <td>{{ $cashAdvance->created_at->format('M. d, Y') }}</td>
                                                                            <td>&#8369; {{ number_format($cashAdvance->amount) }}</td>
                                                                            <!-- <td>{{ $cashAdvance->purpose }}</td> -->
                                                                            <td>{{ $cashAdvance->pay_seq }}</td>
                                                                            <td>
                                                                                @if ($cashAdvance->status === 0)
                                                                                    @if ($firstRows)
                                                                                        <span class="badge text-bg-danger">Not Complete</span>
                                                                                        @php
                                                                                            $firstRows = false; // Set it to false for the next rows with status 0
                                                                                        @endphp
                                                                                    @else
                                                                                        <span class="badge text-bg-primary">Pending</span>
                                                                                    @endif
                                                                                @elseif ($cashAdvance->status === 1)
                                                                                    <span class="badge text-bg-success">Completed</span>
                                                                                @endif
                                                                            <td>
                                                                                <button type="button" class="btn btn-outline-primary btn-sm" id="secondModalButton{{ $cashAdvance->id }}" data-bs-target="#exampleModal2{{ $cashAdvance->id }}">
                                                                                    <i class="fas fa-eye"></i>
                                                                                </button>
                                                                                
                                                                                <div class="modal fade" id="exampleModal2{{ $cashAdvance->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-lg">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header bg-primary text-light">
                                                                                                <h1 class="modal-title fs-5 ">Cash advance details</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="row">
                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Date Borrowed:</label>
                                                                                                    <div class="col-sm-4">
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $cashAdvance->created_at->format('F d, Y') }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Borrowed Amount:</label>
                                                                                                    <div class="col-sm-4">
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="&#8369; {{ number_format($cashAdvance->c_amount) }}">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="row">
                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Payment term:</label>
                                                                                                    <div class="col-sm-4">
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $cashAdvance->c_pay_sequence }}">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="row">
                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Purpose:</label>
                                                                                                    <div class="col-sm-4">
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $cashAdvance->purpose }}">
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="card mt-3 card-shadow">
                                                                                                    <div class="card-body">
                                                                                                        <div class="table-responsive">
                                                                                                            <table id="examples2{{ $cashAdvance->id }}" class="table table-bordered table-hover datatable">
                                                                                                                <thead class="table-primary">
                                                                                                                    <tr>
                                                                                                                        <th scope="col" class="text-center">Pay Date</th>
                                                                                                                        <th scope="col" class="text-center">Paid Amount</th>
                                                                                                                        <th scope="col" class="text-center">Remaining Balance</th>
                                                                                                                    </tr>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                @foreach ($cashAdvance->caDetails as $c)
                                                                                                                    <tr>
                                                                                                                        <td class="text-center">{{ $c->created_at->format('F j, Y') }}</td>
                                                                                                                        <td class="text-center">&#8369; {{ number_format($c->paid_amount, 2, '.', ',') }}</td>
                                                                                                                        <td class="text-center">
                                                                                                                            @if ($c->balance <= 0)
                                                                                                                                <span class="badge text-bg-success">Completed</span>
                                                                                                                            @else
                                                                                                                                &#8369; {{ number_format($c->balance, 2, '.', ',') }}
                                                                                                                            @endif
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
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>

                                                            </table>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                        <button type="button" class="btn btn-outline-danger btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal3{{ $employee->id }}"><i class="bi bi-plus-circle-fill"></i> {{ __('Add Damage deduction') }}</button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="exampleModal3{{ $employee->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add damage deduction</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('add.damage', $employee->id) }}" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                
                                                                                <input type="text" hidden="" class="form-control" id="employee_id" name="employee_id" value="{{ $employee->id }}">
                                                                                <div class="mb-3">
                                                                                    <label for="deduction">Employee Name:</label>
                                                                                    <input type="text" readonly class="form-control" id="deduction" name="deduction" value="{{ $employee->user->name }} {{ $employee->user->lname }}">
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="deduction">Date of Incidence:</label>
                                                                                    <input type="date" class="form-control" id="incidence" name="incidence" required>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="deduction">Damage Deduction</label>
                                                                                    <input type="text" required class="form-control" id="deduction" name="deduction" placeholder="Enter the damage deduction amount">
                                                                                    @error('deduction')
                                                                                        <span class="text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="description">Description</label>
                                                                                    <textarea required class="form-control" id="description" name="description" rows="4" placeholder="Enter the damage description"></textarea>
                                                                                    @error('description')
                                                                                        <span class="text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="photo">Photo</label> <span class="text-secondary">(optional)</span>
                                                                                    <input type="file" class="form-control" id="photo" name="photo">
                                                                                    @error('photo')
                                                                                        <span class="text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="damage_sequence">Payment term</label>
                                                                                    <input required type="number" class="form-control" value="0" min="1" id="damage_sequence" name="damage_sequence" placeholder="Enter the damage sequence for transportation">
                                                                                    @error('damage_sequence')
                                                                                        <span class="text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>

                                                                                <button type="submit" class="btn btn-primary btn-sm w-100">Submit</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <table id="damage_{{ $employee->id }}" class="table table-bordered table-hover datatable">
                                                                <thead class="table-primary">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Incident date</th>
                                                                        <!-- <th scope="col">Description</th> -->
                                                                        <th scope="col">Balance</th>
                                                                        <!-- <th scope="col">Photo</th> -->
                                                                        <th scope="col">Remaining term</th>
                                                                        <th scope="col">Status</th>
                                                                        <th scope="col">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $first = true;
                                                                    @endphp
                                                                    @foreach ($employee->damages as $damage)
                                                                        <tr>
                                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                                            <td>{{ \Carbon\Carbon::parse($damage->date_of_incidence)->format('M. j, Y') }}</td>
                                                                            <!-- <td>{{ $damage->description }}</td> -->
                                                                            <td>&#8369; {{ number_format($damage->deduction, 2) }}</td>
                                                                            <!-- <td>
                                                                                @if ($damage->photo)
                                                                                    <img src="{{ asset('storage/' . $damage->photo) }}" alt="Damage Photo" style="max-height: 50px;">
                                                                                @else
                                                                                    No Photo
                                                                                @endif
                                                                            </td>                                                                      -->
                                                                            <td>{{ $damage->damage_sequence }}</td>
                                                                            <td>
                                                                                @if ($damage->status === 0)
                                                                                    @if ($first)
                                                                                        <span class="badge text-bg-danger">Not Complete</span>
                                                                                        @php
                                                                                            $first = false; // Set it to false for the next rows with status 0
                                                                                        @endphp
                                                                                    @else
                                                                                        <span class="badge text-bg-primary">Pending</span>
                                                                                    @endif
                                                                                @elseif ($damage->status === 1)
                                                                                    <span class="badge text-bg-success">Completed</span>
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="showModal('{{ $damage->id }}')">
                                                                                    <i class="far fa-eye"></i>
                                                                                </button>
                                                                                

                                                                                <div class="modal fade" id="modal5{{ $damage->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-lg">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header bg-primary">
                                                                                                <h1 class="modal-title fs-5 text-light">Damage details</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="row">
                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Date of Incidence:</label>
                                                                                                    <div class="col-sm-4">
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ \Carbon\Carbon::parse($damage->date_of_incidence)->format('F j, Y') }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Damage Amount:</label>
                                                                                                    <div class="col-sm-4">
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="&#8369; {{ number_format($damage->c_deduction, 2) }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Payment term:</label>
                                                                                                    <div class="col-sm-4">
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $damage->c_term }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="row">
                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Description:</label>
                                                                                                    <div class="col-sm-4">
                                                                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $damage->description }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="mb-3 row">
                                                                                                    <label for="staticEmail" class="col-sm-4 col-form-label">Photo:</label>
                                                                                                    <div class="col-sm-4">
                                                                                                        @if ($damage->photo)
                                                                                                            <img src="{{ asset('storage/' . $damage->photo) }}" alt="Damage Photo" style="max-height: 50px;">
                                                                                                        @else
                                                                                                            No Photo
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="card">
                                                                                                    <div class="card-body">
                                                                                                        <div class="table-responsive">
                                                                                                            <table id="damageDatatables{{ $damage->id }}" class="table table-bordered table-hover damageDatatable">
                                                                                                                <thead class="table-primary">
                                                                                                                    <tr>
                                                                                                                        <th scope="col">Pay Date</th>
                                                                                                                        <th scope="col">Paid Amount</th>
                                                                                                                        <th scope="col">Remaining Balance</th>
                                                                                                                    </tr>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                    @foreach ($damage->damageDetails as $d)
                                                                                                                        <tr>
                                                                                                                            <td>{{ $d->created_at->format('F j, Y') }}</td>
                                                                                                                            <td>&#8369; {{ number_format($d->paid_amount, 2) }}</td>
                                                                                                                            <td>
                                                                                                                                @if ($d->balance == 0)
                                                                                                                                    <span class="badge text-bg-success">Completed</span>
                                                                                                                                @else
                                                                                                                                    &#8369; {{ number_format($d->balance, 2) }}
                                                                                                                                @endif
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
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table id="payroll_{{ $employee->id }}" class="table table-bordered size table-hover">
                                                                <thead class="table-primary">
                                                                    <tr>
                                                                        <th class="fw-bold" scope="col">#</th>
                                                                        <th class="fw-bold" scope="col">Payroll period</th>
                                                                        <th class="fw-bold" scope="col">CA deduction</th>
                                                                        <th class="fw-bold" scope="col">Damage deduction</th>
                                                                        <th class="fw-bold" scope="col">Total deduction</th>
                                                                        <th class="fw-bold" scope="col">Total rate</th>
                                                                        <th class="fw-bold" scope="col">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($employeePayroll as $e)
                                                                        <tr>
                                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                                            <td>{{ \Carbon\Carbon::parse($e->payroll_start_date)->format('M. j') }}-{{ \Carbon\Carbon::parse($e->payroll_end_date)->format('j, Y') }}</td>
                                                                            <td>
                                                                                @if($e->ca_deduction == 0)
                                                                                    <p class="fw-bold">No DF Deduction</p>
                                                                                @else
                                                                                    &#8369; {{ number_format($e->ca_deduction, 2) }}
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if($e->df_deduction == 0)
                                                                                    <p class="fw-bold">No DF Deduction</p>
                                                                                @else
                                                                                    &#8369; {{ number_format($e->df_deduction, 2) }}
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if($e->total_deduction == 0)
                                                                                    <p class="fw-bold">No DF Deduction</p>
                                                                                @else
                                                                                    &#8369; {{ number_format($e->total_deduction, 2) }}
                                                                                @endif
                                                                            </td>
                                                                            <td>&#8369; {{ $e->total_rate }}</td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#payrollModal1{{ $e->id}}">
                                                                                    <i class="fas fa-eye"></i>
                                                                                </button>

                                                                                <button type="button" class="btn btn-outline-success btn-sm update-status-button" data-id="{{ $e->id }}" data-route="{{ route('update.status.payroll', ['id' => $e->id]) }}">Paid</button>

                                                                                @php
                                                                                    $csrfToken = csrf_token();
                                                                                @endphp
                                                                                <!-- Modal -->
                                                                                <div class="modal fade" id="payrollModal1{{ $e->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog modal-lg">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Payroll details</h1>
                                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="container">
                                                                                                    <div class="fs-6 row">
                                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label text-dark fw-bold">Employee name</label>
                                                                                                        <div class="col-sm-4">
                                                                                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $employee->user->name }} {{ $employee->user->lname }}">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="fs-6 row">
                                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label text-dark fw-bold">Pay Period Start Date</label>
                                                                                                        <div class="col-sm-4">
                                                                                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ \Carbon\Carbon::parse($e->payroll_start_date)->format('F j, Y') }}">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="fs-6 row">
                                                                                                        <label for="staticEmail" class="col-sm-4 col-form-label text-dark fw-bold">Pay Period End Date</label>
                                                                                                        <div class="col-sm-4">
                                                                                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ \Carbon\Carbon::parse($e->payroll_end_date)->format('F j, Y') }}">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="container">
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table table-bordered">
                                                                                                            <thead class="table-primary">
                                                                                                                <tr>
                                                                                                                    <th scope="col">Delivery date</th>
                                                                                                                    <th scope="col">Company name</th>
                                                                                                                    <th scope="col">Route</th>
                                                                                                                    <th scope="col">Rate</th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($e->payrollDetails as $p)
                                                                                                                    <tr>
                                                                                                                        <td>{{ $p->transportation->booking->date }}</td>
                                                                                                                        <td>{{ $p->transportation->booking->user->name }}</td>
                                                                                                                        <td>{{ $p->transportation->booking->origin }}-{{ $p->transportation->booking->destination }}</td>
                                                                                                                        <td>{{ $p->rate }}</td>
                                                                                                                    </tr>
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                            <tfoot>
                                                                                                                <tr>
                                                                                                                    <td class="fw-bold" colspan="3">Total Rate:</td>
                                                                                                                    <td class="fw-bold">{{ $e->total_rate }}</td>
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
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>

        
    
</script>


@endsection