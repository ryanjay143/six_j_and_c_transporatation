<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ __('Six J and C Transportation') }}
    </title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/logo/six_j_and_c_logo.png') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" text="text/css" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>

    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('css/transport.css') }}">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>


<body style="background-image: linear-gradient(to right, blue, blue, white);">
    <div id="app">
        <nav class="navbar  navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <div class="col-lg-7 text-light px-5 text-start">
                    <div class="h-100 d-inline-flex align-items-center me-4">
                        <span class="fa fa-phone-alt me-2"></span>
                        <span>+012 345 6789</span>
                    </div>
                    <div class="h-100 d-inline-flex align-items-center">
                        <span class="far fa-envelope me-2"></span>
                        <span>info@example.com</span>
                    </div>
                </div>
                <div class="col-lg-5 px-5 text-end">
                    <div class="h-100 d-inline-flex align-items-center mx-n2">
                        <span class="text-light">Follow Us:</span>
                        <a class="btn btn-link text-light" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-link text-light" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-link text-light" href=""><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn btn-link text-light" href=""><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar1  navbar-expand-sm navbar-dark bg-light shadow">
            <div class="container">
                <a class="navbar-brand me-5 text-dark" href="{{ url('/') }}">
                    <img src="{{ asset('logo/six_j_and_c_logo.png') }}" alt="Logo" style="height: 60px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <i class="fas fa-bars text-dark"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <div style="display: flex; justify-content: center;">
                        <ul class="navbar-nav nav-underline">
                            <li class="nav-item">
                                <a class="nav-link active text-primary fs-5" aria-current="page" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark fs-5" href="{{ route('about') }}">{{ __('About') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark fs-5" href="{{ route('transportation') }}">{{ __('Transportation') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark fs-5" href="{{ route('service') }}">{{ __('Services') }}</a>
                            </li>
                        </ul>
                    </div>

                        
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn fs-5 btn1 btn-outline-primary btn-sm custom-login-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="bi bi-person-fill"></i> {{ __('Login') }}
                                    </button>


                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title fw-bold text-uppercase text-center">Login Information</h4>
                                                    <button type="button" class="btn-close btn-close-white bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <center>
                                                    <img src="/logo/six_j_and_c_logo.png" alt="Logo" class="mb-3" style="height: 100px;">
                                                </center>
                                                <div class="alert alert-success d-none" id="loginSuccessAlert" role="alert">
                                                    Reset successful! You can now access your account.
                                                </div>
                                                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                                                    @csrf                      

                                                    <!-- Email Input -->
                                                    <div class="input-group input-group-lg mb-3">
                                                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" aria-label="Email Address" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                                                        <button class="btn btn-outline-primary" disabled type="button" id="button-addon2">
                                                            <i class="bi bi-envelope"></i>
                                                        </button>
                                                    </div>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                    <div class="input-group input-group-lg mb-3">
                                                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" aria-label="Password" autocomplete="current-password">
                                                        <button class="btn btn-outline-primary" type="button" id="togglePassword">
                                                            <i class="bi bi-eye" style="display: none;"></i>
                                                            <i class="bi bi-eye-slash" ></i>
                                                        </button>
                                                    </div>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                    <!-- 2 column grid layout -->
                                                    <div class="row mb-4">
                                                        <div class="col-md-12 d-flex justify-content-end">
                                                            <!-- Simple link -->
                                                            @if (Route::has('password.request'))
                                                                <a href="{{ route('password.request') }}">Forgot password?</a>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Submit button -->
                                                    <button type="submit" id="submitButton" class="btn btn-primary btn-block" disabled>
                                                        <i class="fas fa-right-to-bracket"></i> Login
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                            @endif
                            

                            <!-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif -->
                         @else
                            <li class="nav-item dropdown">
                                <!-- <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark" href="" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a> -->
                                <button type="button" id="navbarDropdown" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="">
                                        <i class="fas fa-key"></i> {{ __('Change Password') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-right-from-bracket"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest 
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>

    
    @yield('footer')
   


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('js/login.js') }}"></script>

    @if(session('show_login_alert'))
        <script src="{{ asset('js/modal.js') }}"></script>
    @endif

    <script>
        var resertpasswordURL = "{{ route('password.update') }}"
    </script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
</body>
</html>
