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
                <h3>{{ __('Reset Password') }}</h3>
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
                                        @if (session('error'))
                                            <div class="alert alert-danger">{{ session('error') }}</div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        
                                        <form action="{{ route('change.password.submit') }}" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="old_password" class="form-label text-dark">Old Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control border border-primary" id="old_password" placeholder="Enter your old password" name="old_password" required>
                                                    <button class="btn btn-outline-secondary toggle-password" data-target="old_password" type="button">
                                                        <i class="bi bi-eye-slash-fill"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="new_password" class="form-label text-dark">New Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control border border-primary" id="new_password" placeholder="Enter your new password" name="new_password" required>
                                                    <button class="btn btn-outline-secondary toggle-password" data-target="new_password" type="button">
                                                        <i class="bi bi-eye-slash-fill"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="new_password_confirmation" class="form-label text-dark">Confirm Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control border border-primary" id="new_password_confirmation" placeholder="Enter your confirm password" name="new_password_confirmation" required>
                                                    <button class="btn btn-outline-secondary toggle-password" data-target="new_password_confirmation" type="button">
                                                        <i class="bi bi-eye-slash-fill"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="d-grid gap-2">
                                                <button class="btn btn-primary" type="submit">Change Password</button>
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