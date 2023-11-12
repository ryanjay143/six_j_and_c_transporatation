<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Payment details') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/logo/six_j_and_c_logo.png') }}">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">

    <script defer src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
   
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <link rel="stylesheet"  href="{{ asset('/css/customer.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo fs-6">
                            <a href="{{ route('user.home') }}">{{ Auth::user()->name }}</a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item">
                            <a href="{{ route('user.home') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item ">
                            <a href="{{ route('user.booking') }}" class='sidebar-link'>
                                <i class="bi bi-book-fill"></i>
                                <span>{{ __('Bookings') }}</span>
                            </a>
                        </li>

                        <li class="sidebar-item ">
                            <a href="{{ route('user.transportation') }}" class='sidebar-link'>
                                <i class="bi bi-truck"></i>
                                <span>Transportation</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('user.billings.payment') }}" class='sidebar-link'>
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span>Billings</span>
                            </a>
                        </li>

                        <li class="sidebar-item active">
                            <a href="{{ route('user.reports.payment') }}" class='sidebar-link'>
                                <i class="fas fa-chart-bar"></i>
                                <span>Reports</span>
                            </a>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="fas fa-cog"></i>
                                <span>{{ __('Settings') }}</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item">
                                    <a href="{{ route('user.profile') }}">
                                        <i class="fas fa-user"></i> Profile
                                    </a>
                                </li>
                                <li class="submenu-item">
                                    <a href="{{ route('user.reset.password') }}">
                                        <i class="fas fa-lock"></i> Change Password
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('logout') }}" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>{{ __('Logout') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>

    </div>

    <main class="py-4">
            @yield('content')
    </main>
   
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/user.js') }}"></script>
    

   
    
    

   
    
</body>

</html>