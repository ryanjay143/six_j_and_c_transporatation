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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/transport.css') }} ">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>

    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    
    

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>


<body style="background-image: linear-gradient(to right, blue, white, blue);">
    <div id="app">
        <nav class="navbar navbar-expand-sm navbar-dark bg-light shadow">
            <div class="container">
                <a class="navbar-brand me-5 text-dark" href="{{ route('user.home') }}">
                    <img src="{{ asset('/logo/six_j_and_c_logo.png') }}" alt="Logo" style="height: 50px;">
                    
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <i class="fas fa-bars text-dark"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav nav-underline">
                            <li class="nav-item">
                                <a class="nav-link text-dark" aria-current="page" href="{{ route('user.home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active text-primary" href="{{ route('user.about') }}">{{ __('About') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ route('user.contact') }}">{{ __('Contact') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ route('user.service') }}">{{ __('Services') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="#">{{ __('Dashboard') }}</a>
                            </li>
                        </ul>
                        
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                            <li class="nav-item">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn1 btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="fas fa-right-to-bracket"></i> {{ __('Login') }}
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <h4 class="fw-bold text-uppercase text-center">{{__('six j and c transport')}}</h4>
                                                    <center>
                                                        <img src="{{ ('/logo/six_j_and_c_logo.png') }}"  alt="Logo" style="height: 100px;">    
                                                    </center> 
                                                    <p class="text-center fw-bold ">Login Here!</p>
                                                    <form method="POST" action="{{ route('login') }}">
                                                    @csrf 

                                                        <!-- Email input -->
                                                        <div class="form-soutline mb-4 mt-3">
                                                            <div class="row mb-3">
                                                            <label for="email" class="col-md-4 col-form-label text-md-end text-dark">{{ __('Email Address') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="email" type="email" placeholder="Email Address" class="form-control border border-primary  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                       

                                                        <!-- Password input -->
                                                        <div class="form-outline mb-4">
                                                            <div class="row mb-3">
                                                                <label for="password" class="col-md-4 col-form-label text-md-end text-dark">{{ __('Password') }}</label>

                                                                <div class="col-md-6">
                                                                    <input id="password" type="password" placeholder="Password" class="form-control border border-primary @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                                                    @error('password')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- 2 column grid layout -->
                                                        <div class="row mb-4">
                                                            <div class="col-md-6 d-flex justify-content-center">
                                                            <!-- Checkbox -->
                                                                <div class="form-check mb-3 mb-md-0">
                                                                    <input class="form-check-input border border-dark" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                                        <label class="form-check-label" for="remember">
                                                                            {{ __('Remember Me') }}
                                                                        </label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 d-flex justify-content-center">
                                                            <!-- Simple link -->
                                                            @if (Route::has('password.request'))
                                                                <a href="{{ route('password.request') }}">Forgot password?</a>
                                                            @endif
                                                            </div>
                                                        </div>

                                                        <!-- Submit button -->
                                                        <button type="submit" class="btn btn-primary btn-block btn-sm mb-4"><i class="fas fa-right-to-bracket"></i> {{ __('Login') }}</button>

                                                        </form>
                                                        
                                                    </div>
                                                       
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        // Select all the cards
        const cards = document.querySelectorAll('.card');

        function revealCards() {
        cards.forEach(card => {
            if (isElementInViewport(card)) {
            card.classList.add('reveal');
            }
        });
        }

        function isElementInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
        }

        // Add an event listener for the scroll event
        window.addEventListener('scroll', revealCards);

        // Call the revealCards function on page load to reveal the visible cards
        revealCards();

    </script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
