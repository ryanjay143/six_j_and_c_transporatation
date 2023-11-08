<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/logo/six_j_and_c_logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('/css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>

    <script defer src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="{{ asset('js/scripts.js') }}"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>

    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('/css/dashboard.css') }}">


    <title>{{ __('Admin Profile') }}</title>

     <!-- Scripts -->
     @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-primary">
            <!-- Navbar Brand-->
            <a class="navbar-brand text-light" href="{{ route('admin.home') }}">
                <i class="" style="margin-left: 15px;"></i> 
                <img src="{{ asset('/logo/six_j_and_c_logo.png') }}" alt="Logo" style="height: 30px;">
                {{ __('Six J and C Transport') }}
            </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars fa-lg text-light"></i></button>
            <!-- Navbar Search-->
            <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0 text-light">
                {{ now()->format('F d, Y h:i A') }}
            </div>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 text-light">
                <li class="nav-item dropdown text-light">
                    <a class="nav-link dropdown-toggle text-light text-capitalize" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end " aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav ">
                            <div class="sb-sidenav-menu-heading"></div>
                            <a class="nav-link active" href="{{ route('admin.home') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                {{ __('Dashboard') }}
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="bi bi-people-fill"></i></div>
                                {{ __('Manage Users') }}
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('client.account') }}">Clients Account</a>
                                    <a class="nav-link" href="{{ route('employee.account')}}">Employee Account</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="{{ route('booking.calendar') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-days"></i></div>
                                {{ __('Manage Booking') }}
                            </a>
                            <a class="nav-link" href="{{ route('admin.transportation') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-truck-fast"></i></div>
                                {{ __('Transportation') }}
                            </a>
                            <a class="nav-link" href="{{ route('list.of.trucks') }}">
                                <div class="sb-nav-link-icon"><i class="bi bi-truck"></i></div>
                                {{ __('Manage Trucks') }}
                            </a>
                            <a class="nav-link" href="{{ route('admin.billing') }}">
                                <div class="sb-nav-link-icon"><i class="bi bi-receipt"></i></div>
                                 {{ __('Manage Billing') }}
                            </a>
                            <a class="nav-link " href="{{ route('admin.payroll') }}">
                                <div class="sb-nav-link-icon"><i class="bi bi-wallet-fill"></i></i></div>
                                {{ __('Manage Payroll') }}
                            </a>
                            <!-- <a class="nav-link" href="{{ route('payroll.info') }}">
                                <div class="sb-nav-link-icon"><span class="fw-bold">₱</span></div>
                                {{ __('Payroll Information') }}
                            </a>
                            <a class="nav-link" href="{{ route('billing.information') }}">
                                <div class="sb-nav-link-icon"><i class="bi bi-receipt"></i></div>
                                {{ __('Billing Information') }}
                            </a> -->
                            <a class="nav-link collapsed " href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts1">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                                {{ __('Reports') }}
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts1" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav mb-5">
                                    <a class="nav-link" href="{{ route('admin.billingReports') }}">Billing Reports</a>
                                    <a class="nav-link" href="{{ route('admin.paymentReports') }}">Payment Reports</a>
                                    <a class="nav-link" href="{{ route('admin.transportationReports') }}">Transportation Reports</a>
                                    <a class="nav-link" href="{{ route('admin.payrollReports') }}">Payroll Reports</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        
        <main class="py-4">
            @yield('content')
        </main>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
       
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="/js/datatables-simple-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>