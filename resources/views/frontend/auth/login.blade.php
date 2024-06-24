@extends('frontend.layouts.layout')
@section('title', __('Connexion') )

@section('main-content')

    <div style="margin-top: 60px;">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Connexion') }}</li>
            </ol>
        </nav>
    </div>

    <div class="row row-flex align-items-center">
        <div class="col-12 col-md-1 content p-5"></div>
        <div class="col-12 col-md-6 content p-5">
            @if(@$_GET["page"])
                <form method="POST" action="{{ route('login', ['page' => 'cart']) }}">
            @else
                <form method="POST" action="{{ route('login') }}">
            @endif

                @csrf

                <h3 class="text-center mb-5">Connexion à votre compte</h3>
                <p>Renseignez votre adresse e-mail et votre mot de passe pour accéder à votre compte</p>

                <div class="form-group mb-4">
                    <label class="form-control-label" for="email">Adresse e-mail : <span class="small text-danger">*</span></label>
                    <input id="email" type="text" name="email"
                           class="@error('email') is-invalid @enderror form-control" required
                           value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-control-label" for="password">Mot de passe : <span class="small text-danger">*</span></label>
                    <input id="password" type="password" name="password"
                           class="@error('password') is-invalid @enderror form-control" required
                           value="{{ old('password') }}">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex">
                    <div class="form-check form-switch mb-3 pl-5 flex-grow-1">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">{{ __('Remember me') }}</label>
                    </div>
                    @if (Route::has('password.request'))
                        <div class="mb-3 justify-content-end">
                            <a class="text-decoration-none blackcolor" href="{{ route('password.request') }}">
                                <i class="fa-solid fa-lock"></i> {{ __('Forgot your password?') }}
                            </a>
                        </div>
                    @endif
                </div>

                <div class="form-group text-center mb-5">
                    <button type="submit" class="btn btn-primary btn-lg hvr-grow-shadow w-100">
                        {{ __('Login') }}
                    </button>
                </div>

            </form>
        </div>
        <div class="col-12 col-md-4 content p-5 text-center">
            <h2 class="mb-3">Pas encore inscrit ?</h2>
            <a href="{{ route('register') }}" class="btn btn-lg btn-warning hvr-grow-shadow">Créer votre compte</a>
        </div>
    </div>
@endsection
