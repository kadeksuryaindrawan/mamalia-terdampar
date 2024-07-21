<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Responsive Admin Dashboard Template">
        <meta name="keywords" content="admin,dashboard">
        <meta name="author" content="stacks">
        <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!-- Title -->
        @if (request()->segment(1) == '' || request()->segment(1) == 'home')
            <title>Marine Mammals and Sea Turtles Standing Reporting System - Dashboard</title>
        @else
            <title>Marine Mammals and Sea Turtles Standing Reporting System - {{ ucwords(request()->segment(1)) }}</title>
        @endif

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
        <link href="{{ asset('assets') }}/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('assets') }}/plugins/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="{{ asset('assets') }}/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
        <link href="{{ asset('assets') }}/plugins/apexcharts/apexcharts.css" rel="stylesheet">
        <link href="{{ asset('assets/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">

        <link rel="shortcut icon" href="{{ asset('assets/images/logowesterlaken.png') }}">

        <!-- Theme Styles -->
        <link href="{{ asset('assets') }}/css/main.min.css" rel="stylesheet">
        <link href="{{ asset('assets') }}/css/custom.css" rel="stylesheet">
        <link href="{{ asset('assets/css/lightbox.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>

        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div class="page-container">
            <div class="page-header">
                <nav class="navbar navbar-expand-lg d-flex justify-content-between">
                  <div class="" id="navbarNav">
                    <ul class="navbar-nav" id="leftNav">
                      <li class="nav-item">
                        <a class="nav-link" id="sidebar-toggle" href="#"><i data-feather="align-justify"></i></a>
                      </li>
                    </ul>
                    </div>
                    <a href="{{ url('/') }}">
                        <div class="authent-logo d-none d-lg-block">
                            <h4 class="text-primary" style="font-weight: 600; margin-top: 10px;">Marine Mammals and Sea Turtles Standing Reporting System</h4>
                        </div>
                    </a>
                    <div class="" id="headerNav">
                      <ul class="navbar-nav">
                        @if (Auth::user()->role == 'pelapor')
                            <li class="nav-item dropdown">
                            <a class="nav-link search-dropdown" href="#" id="searchDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="flag"></i></a>
                            <div class="dropdown-menu dropdown-menu-end search-drop-menu" aria-labelledby="searchDropDown">
                                    <a class="dropdown-item" href="{{ route('locale','id') }}">Indonesia</a>
                                    <a class="dropdown-item" href="{{ route('locale','en') }}">English</a>
                            </div>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                          <a class="nav-link profile-dropdown" href="#" id="profileDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{ asset('assets') }}/images/pic1.jpg" alt=""></a>
                          <div class="dropdown-menu dropdown-menu-end profile-drop-menu" aria-labelledby="profileDropDown">
                            @if (Auth::user()->role == 'pelapor')
                                <p class="dropdown-item">{{ __('messages.welcome') }},<br>{{ Auth::user()->nama }}</p>
                            @else
                                <p class="dropdown-item">Selamat Datang,<br>{{ Auth::user()->nama }}</p>
                            @endif

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();"><i data-feather="log-out"></i>Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                          </div>
                        </li>
                      </ul>
                  </div>
                </nav>
            </div>
            <div class="page-sidebar">
                <ul class="list-unstyled accordion-menu">
                    <li class="sidebar-title d-none d-lg-block">
                        Menu
                    </li>
                    <li class="sidebar-title d-lg-none d-block">
                        Marine Mammals and Sea Turtles Standing Reporting System
                    </li>
                  <li class="{{ (request()->segment(1) == '' || request()->segment(1) == 'home') ? 'active-page' : '' }}">
                    <a href="{{ url('/') }}"><i data-feather="home"></i>Dashboard</a>
                  </li>
                  @if (Auth::user()->role == 'admin')
                    <li  class="{{ (request()->segment(1) == 'user') ? 'active-page' : '' }}">
                        <a href="{{ route('user.index') }}"><i data-feather="user"></i>User</a>
                    </li>
                    <li  class="{{ (request()->segment(1) == 'laporan' || request()->segment(1) == 'editfotolaporan') ? 'active-page' : '' }}">
                        <a href="{{ route('laporan.index') }}"><i data-feather="zap"></i>Laporan</a>
                    </li>
                    <li  class="{{ (request()->segment(1) == 'penanganan') ? 'active-page' : '' }}">
                        <a href="{{ route('tindakan-index') }}"><i data-feather="activity"></i>Penanganan</a>
                    </li>
                  @endif

                  @if (Auth::user()->role == 'pelapor')
                    <li  class="{{ (request()->segment(1) == 'laporan' || request()->segment(1) == 'editfotolaporan') ? 'active-page' : '' }}">
                        <a href="{{ route('laporan.index') }}"><i data-feather="zap"></i>{{ __('messages.report') }}</a>
                    </li>
                  @endif

                  @if (Auth::user()->role == 'yayasan')
                    <li  class="{{ (request()->segment(1) == 'laporan' || request()->segment(1) == 'editfotolaporan') ? 'active-page' : '' }}">
                        <a href="{{ route('laporan.index') }}"><i data-feather="zap"></i>Laporan</a>
                    </li>
                    <li  class="{{ (request()->segment(1) == 'penanganan') ? 'active-page' : '' }}">
                        <a href="{{ route('tindakan-index') }}"><i data-feather="activity"></i>Penanganan</a>
                    </li>
                  @endif

                </ul>
            </div>
            @yield('content')
        </div>

        <!-- Javascripts -->
        <script src="{{ asset('assets') }}/plugins/jquery/jquery-3.4.1.min.js"></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="{{ asset('assets') }}/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
        <script src="{{ asset('assets') }}/plugins/apexcharts/apexcharts.min.js"></script>
        <script src="{{ asset('assets') }}/js/main.min.js"></script>
        <script src="{{ asset('assets') }}/js/pages/dashboard.js"></script>
        <script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/datatables.js') }}"></script>
        <script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('assets/js/lightbox.js') }}"></script>
    </body>
</html>
