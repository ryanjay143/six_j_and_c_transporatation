@extends('layouts.user.profile')
    @section('content')
    
    @include('sweetalert::alert')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <!-- <div class="page-heading">
                <h3>{{ __('Dashboard for Client') }}</h3>
            </div> -->
            <div class="page-content">
           
                <section class="row">
                <h4 class="d-flex justify-content-center align-items-center">Update Profile</h4>
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        
                        <div class="card border border-primary w-50">
                            <div class="card-body">
                                <form action="{{ route('user.update.profile') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="formGroupExampleInput" class="form-label text-primary">Company name</label>
                                        <input type="text" class="form-control" id="formGroupExampleInput" name="name"  value="{{ old('name', $client->name) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="formGroupExampleInput2" class="form-label text-primary">Email</label>
                                        <input type="text" class="form-control" id="formGroupExampleInput2" name="email" value="{{ old('email', $client->email) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="formGroupExampleInput2" class="form-label text-primary">Phone number</label>
                                        <input type="text" class="form-control" id="formGroupExampleInput2" name="phone" value="{{ old('phone_num', $client->phone_num) }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm float-end">Update</button>
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