@extends('layouts.admin.profile')

@section('content')

@include('sweetalert::alert')
        <div id="layoutSidenav">
            <div id="layoutSidenav_content" >
                <main >
                    <div class="container-fluid px-4" >
                    
                        
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card mt-5 mb-5">
                                        <div class="card-header fs-4">
                                            {{ __('Admin Profile') }}
                                        </div>
                                        <div class="card-body">
                                        <nav>
                                        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                                            <a href="#1" class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Profile Update</a>
                                            <a href="#2" class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Change Password</a>
                                        </div>
                                        </nav>
                                            <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                                                    <div class="card-body">
                                                        @if(session('success'))
                                                        <div class="alert alert-success" role="alert">
                                                            {{ session('success') }}
                                                        </div>
                                                        @endif
                                                        <form action="{{ route('admin.profile.update') }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group mb-3">
                                                                <label for="name">{{ __('Firstname') }}</label>
                                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $adminUser->name) }}" required autofocus>
                                                                @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label for="name">{{ __('Lastname') }}</label>
                                                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname', $adminUser->lname) }}" required autofocus>
                                                                @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label for="email">{{ __('Email') }}</label>
                                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $adminUser->email) }}" required>
                                                                @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label for="email">{{ __('Phone number') }}</label>
                                                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone_num', $adminUser->phone_num) }}" required>
                                                                @error('phone')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            <div class="d-grid gap-2">
                                                                <button class="btn btn-primary" type="submit">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                                                    <div class="card-body">
                                                    <form method="POST" action="{{ route('admin.password.update') }}">
                                                        @csrf

                                                        <div class="mb-3">
                                                            <label for="password" class="form-label">New Password</label>
                                                            <input type="password" name="password" id="password" class="form-control" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                                        </div>

                                                        <button type="submit" class="btn btn-primary">Change Password</button>
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
        </div>

       
@endsection
