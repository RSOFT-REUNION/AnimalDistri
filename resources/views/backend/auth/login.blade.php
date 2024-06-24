<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('backend/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/hover.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('backend/img/favicon.ico') }}" rel="icon" type="image/png">
</head>
<body class="bg-gradient-primary min-vh-100 d-flex justify-content-center align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 my-5 shadow-lg">
                <div class="card-body p-0">
                    <div class="row align-items-center">
                        <div class="col-lg-6 d-none d-lg-block">
                            <img class="w-100 hvr-grow-rotate" src="{{ asset('backend/img/logo.png') }}">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Login') }}</h1>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger border-left-danger" role="alert">
                                        <ul class="pl-4 my-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('backend.login') }}">
                                    @csrf

                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="" value="{{ old('email') }}" required autofocus>
                                        <label for="email">{{ __('E-Mail Address') }}</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="" required>
                                        <label for="email">{{ __('Password') }}</label>
                                    </div>

                                    <div class="form-check form-switch fs-5 mb-3 pl-5">
                                        <input class="form-check-input" type="checkbox" role="switch" id="remember" name="remember"  {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">{{ __('Remember me') }}</label>
                                    </div>

                                    <div class="form-group ">
                                        <button type="submit" class="btn btn-lg btn-primary btn-user btn-block">
                                            {{ __('Login') }}
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="text-center">
                            <p><strong>Développé par <a href="http://www.rsoft.re/" target="_blank"
                                                        class="text-link">RSOFT RÉUNION</a></strong></p>
                            <p>Version 1.0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>
</body>
</html>
