<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Westerlaken Foundation Marine Mammals and Sea Turtles Stranding Reporting">
        <meta name="keywords" content="westerlaken,foundation,marine,mammals,turtles,sea,stranding,reporting,report">
        <meta name="author" content="westerlakenfoundation">
        <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!-- Title -->
        <title>Marine Mammals and Sea Turtles Stranding Reporting System - Login</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
        <link href="{{ asset('assets') }}/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('assets') }}/plugins/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="{{ asset('assets') }}/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">

        <link rel="shortcut icon" href="{{ asset('assets/images/logowesterlaken.png') }}">

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
    <body class="login-page"  style="background-image: url('{{ asset('assets/images/bg.png') }}'); background-positon:center; background-size:cover; background-repeat:no-repeat;">
        <div class='loader'>
            <div class='spinner-grow text-primary' role='status'>
              <span class='sr-only'>Loading...</span>
            </div>
          </div>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-12 col-lg-4">
                    <div class="card login-box-container">
                        <div class="card-body">
                            <div class="authent-logo">
                                <a href="{{ url('/') }}"><img src="{{ asset('assets/images/logowesterlaken.png') }}" width="70" alt=""></a>
                                <h4 class="text-primary" style="font-weight: 600;">Marine Mammals and Sea Turtles Stranding Reporting System</h4>
                            </div>
                            <div class="authent-text">
                                <p>{{ __('messages.welcome') }}!</p>
                                <p>{{ __('messages.please_login') }}.</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-floating">

                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                                        <label for="email">Email address</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                      </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="password">
                                        <label for="password">Password</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                      </div>
                                </div>
                                <div class="d-grid">
                                <button type="submit" class="btn btn-info m-b-xs">Login</button>
                            </div>
                              </form>
                              <div class="authent-reg">
                                  <p>{{ __('messages.dont_have') }}? <a href="{{ url('/register') }}">Register</a></p>
                                  <div class="language-switcher mt-3">
                                        {{ __('messages.language') }} : <a href="{{ route('locale','id') }}">Indonesia</a> | <a href="{{ route('locale','en') }}">English</a>
                                    </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Javascripts -->
        <script src="{{ asset('assets') }}/plugins/jquery/jquery-3.4.1.min.js"></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="{{ asset('assets') }}/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
        <script src="{{ asset('assets') }}/js/main.min.js"></script>
    </body>
</html>
