@extends('layouts.admin.employee')

@section('content')
@include('sweetalert::alert')

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h2 class="mt-4">List of Employee Accounts</h2>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-user-plus"></i> Add Employee</button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Employee Account</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">{{ __('Driver') }}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">{{ __('Helper') }}</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                        <div class="container p-3">
                                            <form method="post" class="row g-3" action="{{ url('employee.accounts') }}" enctype="multipart/form-data">
                                                @csrf
                                                <h3 class="mb-0">Personal Account and Information</h3>
                                                <div class="col-md-4">
                                                    <label for="inputEmail4" class="form-label">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputEmail4" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="lname" name="lname" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputPassword4" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" required name="email" value="{{ old('email') }}" required>
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <input type="number" hidden="" class="form-control" id="type" name="type" value="2" required>


                                                <div class="col-md-4">
                                                    <label for="inputEmail4" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="date" id="date" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputEmail4" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputPassword4" class="form-label">Home Address <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="address" name="address" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputCopyEmail" class="form-label">Password <span class="text-danger">*</span></label>
                                                    <input type="password" name="password" readonly class="form-control" id="copyEmail">
                                                    <div id="emailHelp" class="form-text">Your password has the same with your lastname.</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputCopyEmail" class="form-label">Photo <span class="text-danger">*</span></label>
                                                    <div class="input-with-preview d-flex align-items-center">
                                                        <input type="file" name="photo" class="form-control mb-2" id="photoInput" onchange="displaySelectedPhoto(this)">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputCopyEmail" class="form-label"></label>
                                                    <div id="photoPreview" class="photo-preview" style="max-width: 30%; height: auto;"></div>
                                                </div>
                                                <input type="text" hidden="" class="form-control" value="0" id="position" name="position">
                                                <div class="col-12">
                                                    <button class="btn btn-primary float-end" type="submit">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

                                        <form method="post" action="{{ route('helper.account') }}" class="row g-3 needs-validation" novalidate>
                                            @csrf
                                            <div class="contaner p-3">
                                                <h4 class="">Personal Information</h4>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="validationCustom01" class="form-label">First name</label>
                                                <input type="text" name="name" class="form-control" id="validationCustom01" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="validationCustom02" class="form-label">Last name</label>
                                                <input type="text" class="form-control" name="lname" id="validationCustom02" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="validationCustomUsername" class="form-label">Email Address</label>
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend"></span>
                                                    <input type="text" name="email" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                                                    <div class="invalid-feedback">
                                                        Please choose an email.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="validationCustom03" class="form-label">Home Address</label>
                                                <input type="text" name="home" class="form-control" id="validationCustom03" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid city.
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="validationCustom04" class="form-label">Date of Birth</label>
                                                <input type="date" name="dob" class="form-control" id="validationCustom04" required>
                                                <div class="invalid-feedback">
                                                    Please select a birthdate.
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="validationCustom05" class="form-label">Phone Number</label>
                                                <input type="text" name="phone_num" class="form-control" id="validationCustom05" required>
                                                <div class="invalid-feedback">
                                                    Please provide a phone number.
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="inputCopyEmail" class="form-label">Photo <span class="text-danger">*</span></label>
                                                <div class="input-with-preview d-flex align-items-center">
                                                    <input type="file" name="photo" class="form-control mb-2" id="photoInput" onchange="displaySelectedPhotoHelper(this)">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="inputCopyEmail" class="form-label"></label>
                                                <div id="photoPreviewHelper" class="photo-previewHelper" style="max-width: 30%; height: auto;"></div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary float-end" type="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <div class="card bg-light mt-3 mb-3">
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab1" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab1" data-bs-toggle="tab" data-bs-target="#home-tab-pane1" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Drivers</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab1" data-bs-toggle="tab" data-bs-target="#profile-tab-pane1" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Helpers</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent1">
                                    <div class="tab-pane fade show active" id="home-tab-pane1" role="tabpanel" aria-labelledby="home-tab1" tabindex="0">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example" class="table table-bordered table-hover">
                                                    <thead class="table-primary"> 
                                                        <tr>
                                                            
                                                            <th scope="col">Photo</th>
                                                            <th scope="col">Employee Name</th>
                                                            <th scope="col">Email</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $activeEmployees = [];
                                                            $inactiveEmployees = [];
                                                        @endphp
                                                        @foreach ($driver as $employee)
                                                            @if ($employee->user->is_disabled == 0)
                                                                @php
                                                                    $activeEmployees[] = $employee;
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $inactiveEmployees[] = $employee;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @foreach (array_merge($activeEmployees, $inactiveEmployees) as $employee)
                                                            <tr id="employee_row_{{ $employee->id }}">
                                                                <td>
                                                                    <div class="d-flex justify-content-center align-items-center">
                                                                        <a href="{{ $employee->photo ? asset('storage/' . $employee->photo) : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}" data-lightbox="profile-image">
                                                                            <img id="profile-preview" class="rounded-circle" width="30px" height="35px" src="{{ $employee->photo ? asset('storage/' . $employee->photo) : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}">
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $employee->user->name }} {{ $employee->user->lname }}</td>
                                                                <td>{{ $employee->user->email }}</td>
                                                                <td class="status-cell">
                                                                    @if ($employee->user->is_disabled == 0)
                                                                        <span class="badge text-bg-success">Active</span>
                                                                    @else
                                                                        <span class="badge text-bg-danger">
                                                                            Inactive
                                                                        </span>
                                                                    @endif 
                                                                </td>
                                                                <td>
                                                                    <a href="{{ url('admin/employee/details',$employee->id) }}" type="button" class="btn btn-outline-primary btn-sm"><i class="bi bi-eye"></i></a>
                                                                    <button class="btn btn-outline-success btn-sm" type="button" onclick="confirmEnable({{ $employee->id }}, 'employee_row_{{ $employee->id }}')" @if ($employee->user->is_disabled == 0) disabled @endif>
                                                                        <i class="fa-solid fa-user-check"></i>
                                                                    </button>
                                                                    <button class="btn btn-outline-danger btn-sm" type="button" onclick="confirmDisable({{ $employee->id }}, 'employee_row_{{ $employee->id }}')" @if ($employee->user->is_disabled == 1) disabled @endif>
                                                                        <i class="fa-solid fa-user-lock"></i> 
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile-tab-pane1" role="tabpanel" aria-labelledby="profile-tab1" tabindex="0">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="examples" class="table table-bordered table-hover">
                                                    <thead class="table-primary"> 
                                                        <tr>
                                                            <th scope="col">Photo</th>
                                                            <th scope="col">Employee Name</th>
                                                            <th scope="col">Email</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($helper as $employee)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex justify-content-center align-items-center">
                                                                        <a href="{{ $employee->photo ? asset('storage/' . $employee->photo) : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}" data-lightbox="profile-image">
                                                                            <img id="profile-preview" class="rounded-circle" width="30px" height="35px" src="{{ $employee->photo ? asset('storage/' . $employee->photo) : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}">
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $employee->user->name }} {{ $employee->user->lname }}</td>
                                                                <td>{{ $employee->user->email }}</td>
                                                                <td>
                                                                    @if ( $employee->user->is_disabled == 0)
                                                                        <span class="badge text-bg-success">Acive</span>
                                                                    @else ($employee->user->is_disabled == 1)
                                                                        <span class="badge text-bg-danger">Deactivated</span>
                                                                    @endif  
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('admin.helper.details',$employee->id) }}" type="button" class="btn btn-outline-primary btn-sm"><i class="bi bi-eye"></i></a>
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
