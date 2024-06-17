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
        <title>Circl - Responsive Admin Dashboard Template</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
        <link href="{{ asset('assets') }}/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('assets') }}/plugins/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="{{ asset('assets') }}/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
        <link href="{{ asset('assets') }}/plugins/apexcharts/apexcharts.css" rel="stylesheet">


        <!-- Theme Styles -->
        <link href="{{ asset('assets') }}/css/main.min.css" rel="stylesheet">
        <link href="{{ asset('assets') }}/css/custom.css" rel="stylesheet">

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
                        <a class="nav-link" id="sidebar-toggle" href="#"><i data-feather="arrow-left"></i></a>
                      </li>
                    </ul>
                    </div>
                    <a href="{{ url('/') }}">
                        <div class="authent-logo">
                            <h4 class="text-primary" style="font-weight: 600; margin-top: 10px;">MATER</h4>
                        </div>
                    </a>
                    <div class="" id="headerNav">
                      <ul class="navbar-nav">
                        {{-- <li class="nav-item dropdown">
                          <a class="nav-link search-dropdown" href="#" id="searchDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="search"></i></a>
                          <div class="dropdown-menu dropdown-menu-end dropdown-lg search-drop-menu" aria-labelledby="searchDropDown">
                            <form>
                              <input class="form-control" type="text" placeholder="Type something.." aria-label="Search">
                            </form>
                          </div>
                        </li> --}}
                        <li class="nav-item dropdown">
                          <a class="nav-link profile-dropdown" href="#" id="profileDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{ asset('assets') }}/images/pic1.jpg" alt=""></a>
                          <div class="dropdown-menu dropdown-menu-end profile-drop-menu" aria-labelledby="profileDropDown">
                            <p class="dropdown-item">Selamat Datang,<br>{{ Auth::user()->nama }}</p>
                            <a class="dropdown-item" href="#"><i data-feather="user"></i>Profile</a>
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
                  <li class="sidebar-title">
                    Main
                  </li>
                  <li class="active-page">
                    <a href="index.html"><i data-feather="home"></i>Dashboard</a>
                  </li>
                  <li class="sidebar-title">
                    Apps
                  </li>
                  <li>
                    <a href="email.html"><i data-feather="inbox"></i>Email</a>
                  </li>
                  <li>
                    <a href="calendar.html"><i data-feather="calendar"></i>Calendar</a>
                  </li>
                  <li>
                    <a href="social.html"><i data-feather="user"></i>Social</a>
                  </li><li>
                    <a href="file-manager.html"><i data-feather="message-circle"></i>File Manager</a>
                  </li>
                  <li class="sidebar-title">
                    Elements
                  </li>
                  <li>
                    <a href="index.html"><i data-feather="code"></i>Components<i class="fas fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                      <li><a href="alerts.html"><i class="far fa-circle"></i>Alerts</a></li>
                      <li><a href="typography.html"><i class="far fa-circle"></i>Typography</a></li>
                      <li><a href="icons.html"><i class="far fa-circle"></i>Icons</a></li>
                      <li><a href="badge.html"><i class="far fa-circle"></i>Badge</a></li>
                      <li><a href="buttons.html"><i class="far fa-circle"></i>Buttons</a></li>
                      <li><a href="dropdowns.html"><i class="far fa-circle"></i>Dropdowns</a></li>
                      <li><a href="list-group.html"><i class="far fa-circle"></i>List Group</a></li>
                      <li><a href="toasts.html"><i class="far fa-circle"></i>Toasts</a></li>
                      <li><a href="modal.html"><i class="far fa-circle"></i>Modal</a></li>
                      <li><a href="pagination.html"><i class="far fa-circle"></i>Pagination</a></li>
                      <li><a href="popovers.html"><i class="far fa-circle"></i>Popovers</a></li>
                      <li><a href="progress.html"><i class="far fa-circle"></i>Progress</a></li>
                      <li><a href="spinners.html"><i class="far fa-circle"></i>Spinners</a></li>
                      <li><a href="accordion.html"><i class="far fa-circle"></i>Accordion</a></li>
                    </ul>
                  </li>
                  <li>
                    <a href="index.html"><i data-feather="gift"></i>Plugins<i class="fas fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                      <li><a href="block-ui.html"><i class="far fa-circle"></i>Block UI</a></li>
                      <li><a href="session-timeout.html"><i class="far fa-circle"></i>Session Timeout</a></li>
                      <li><a href="tree-view.html"><i class="far fa-circle"></i>Tree View</a></li>
                    </ul>
                  </li>
                  <li>
                    <a href="index.html"><i data-feather="edit"></i>Form<i class="fas fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                      <li><a href="form-elements.html"><i class="far fa-circle"></i>Form Elements</a></li>
                      <li><a href="form-layout.html"><i class="far fa-circle"></i>Form Layout</a></li>
                      <li><a href="form-validation.html"><i class="far fa-circle"></i>Form Validation</a></li>
                    </ul>
                  </li>
                  <li>
                    <a href="cards.html"><i data-feather="layers"></i>Cards</a>
                  </li>
                  <li>
                    <a href="index.html"><i data-feather="list"></i>Tables<i class="fas fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                      <li><a href="tables.html"><i class="far fa-circle"></i>Basic Tables</a></li>
                      <li><a href="data-tables.html"><i class="far fa-circle"></i>Data Tables</a></li>
                    </ul>
                  </li>
                  <li>
                    <a href="charts.html"><i data-feather="pie-chart"></i>Charts</a>
                  </li>
                  <li class="sidebar-title">
                    Other
                  </li>
                  <li>
                    <a href="index.html"><i data-feather="star"></i>Pages<i class="fas fa-chevron-right dropdown-icon"></i></a>
                    <ul class="">
                      <li><a href="invoice.html"><i class="far fa-circle"></i>Invoice</a></li>
                      <li><a href="404.html"><i class="far fa-circle"></i>404 Page</a></li>
                      <li><a href="500.html"><i class="far fa-circle"></i>500 Page</a></li>
                      <li><a href="blank-page.html"><i class="far fa-circle"></i>Blank Page</a></li>
                      <li><a href="login.html"><i class="far fa-circle"></i>Login</a></li>
                      <li><a href="register.html"><i class="far fa-circle"></i>Register</a></li>
                      <li><a href="lockscreen.html"><i class="far fa-circle"></i>Lockscreen</a></li>
                      <li><a href="price.html"><i class="far fa-circle"></i>Price</a></li>
                    </ul>
                  </li>
                  <li>
                    <a href="#"><i data-feather="check-circle"></i>Documentation</a>
                  </li>
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
    </body>
</html>
