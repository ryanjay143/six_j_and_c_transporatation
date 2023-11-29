@extends('layouts.admin.employeeDetails')

@section('content')
@include('sweetalert::alert')

        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h2 class="mt-4">Employee Details</h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page" ><a href="{{ route('employee.account')}}">{{ __('Manage Users') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('Employee Details') }}</li>
                                </ol>
                            </nav>
                            <div class="container">
                                <div class="container">
                                    <div class="container border border-primary rounded bg-white mt-5 mb-5">
                                        <div class="row">
                                            <div class="col-md-3 border-right">
                                                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                                    <div id="profile-image-container">
                                                        <form id="profile-form" action="{{ route('profile.photo.update', ['id' => $employees->id]) }}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <img id="profile-preview" class="mt-5" width="180px" src="{{ $employees->photo ? asset($employees->photo) : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}">
                                                            <div class="font-weight-bold">{{ $employees->user->name }} {{ $employees->user->lname }}</div>
                                                            <span class="text-black-50 mb-2">{{ $employees->user->email }}</span>
                                                            <!-- <input type="file" class="form-control" name="photo" id="photo-input">
                                                            <button type="button" class="btn btn-primary mt-3" id="upload-button" disabled>Upload Photo</button> -->
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 border-right">
                                                <div class="p-3 py-5">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h4 class="text-right">Profile Settings</h4>
                                                    </div>
                                                    <form action="{{ route('profile.update', ['id' => $employees->id]) }}" method="post">
                                                        @csrf
                                                        <div class="row mt-3">
                                                            <div class="col-md-12">
                                                                <label class="labels">Position</label>
                                                                <select class="form-control" name="position">
                                                                    <option value="0" {{ $employees->position == 0 ? 'selected' : '' }}>Driver</option>
                                                                    <option value="1" {{ $employees->position == 1 ? 'selected' : '' }}>Helper</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-6">
                                                                <label class="labels">Firstname</label>
                                                                <input type="text" class="form-control" name="firstname" value="{{ $employees->user->name }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="labels">Lastname</label>
                                                                <input type="text" class="form-control" name="lastname" value="{{ $employees->user->lname }}" >
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3 mb-3">
                                                            <div class="col-md-12 mb-3">
                                                                <label class="labels">Mobile Number</label>
                                                                <input type="text" class="form-control" name="phone_num" value="{{ $employees->user->phone_num }}">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="labels">Address</label>
                                                                <input type="text" class="form-control" name="address" value="{{ $employees->address }}">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="labels">Email Address</label>
                                                                <input type="text" class="form-control" name="email" value="{{ $employees->user->email }}">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="labels">Date of Birth</label>
                                                                <input type="date" class="form-control" name="dob" value="{{ $employees->dob }}">
                                                            </div>
                                                        </div>
                                                        <div class="mt-5 text-center">
                                                            <button class="btn btn-primary profile-button" type="submit">Save Profile</button>
                                                        </div>
                                                    </form>
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
         

       
    
@endsection
