@extends('layouts.employee.resetPassword')

@section('content')
@include('sweetalert::alert')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>{{ __('Update Profile') }}</h3>
                <!-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Transportation') }}</li>
                    </ol>
                </nav> -->
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-8">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mx-auto border border-primary">
                                    <div class="card-body">
                                        <form action="{{ route('driver.profile.update') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="text" class="form-control" name="first_name" placeholder="First name" aria-label="First name" value="{{ auth()->user()->name }}">
                                                </div>
                                                <div class="col">
                                                    <input type="text" class="form-control" placeholder="Last name" name="last_name" aria-label="Last name" value="{{ auth()->user()->lname }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="email" class="form-control" name="email" id="formGroupExampleInput" placeholder="Email" value="{{ auth()->user()->email }}">
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <input type="text" class="form-control" name="phone_number" placeholder="Phone number" aria-label="First name" value="{{ auth()->user()->phone_num }}">
                                                </div>
                                                <div class="col">
                                                    <input type="date" class="form-control" name="date_of_birth" placeholder="Date of birth" aria-label="Last name" value="{{ $employee->dob }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" class="form-control" name="address" id="formGroupExampleInput" placeholder="Address" value="{{ $employee->address }}">
                                            </div>

                                            <!-- Allow users to upload a new profile photo -->
                                            <div class="mb-3">
                                                <label for="profile_photo" class="form-label">Upload new profile photo</label>
                                                <input type="file" class="form-control" id="profile_photo_input" name="profile_photo" placeholder="Profile photo">
                                            </div>
                                               
                                            <!-- Display the old profile photo if it exists -->
                                            <div class="mb-3">
                                                @if($employee && $employee->photo)
                                                    <div id="old_photo">
                                                        <img src="{{ asset('storage/' . $employee->photo) }}" alt="Profile Photo" style="max-width: 200px; max-height: 200px;">
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="d-grid gap-2">
                                                <button class="btn btn-primary" type="submit">Update Profile</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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