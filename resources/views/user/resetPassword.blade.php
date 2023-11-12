@extends('layouts.user.profile')
    @section('content')
    
    @include('sweetalert::alert')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-content">
                <section class="row">
                <h4 class="d-flex justify-content-center align-items-center">Reset Password</h4>
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <div class="card border border-primary w-50">
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
                                <form action="{{ route('user.change.password') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="formGroupExampleInput" class="form-label">Old Password</label>
                                        <input type="text" class="form-control"  id="old_password" placeholder="Enter your old password" name="old_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="new_password" placeholder="Enter your new password" name="new_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="formGroupExampleInput2" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="new_password_confirmation" placeholder="Enter your confirm password" name="new_password_confirmation" required>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" type="submit">Change Password</button>
                                    </div>
                                </form>
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