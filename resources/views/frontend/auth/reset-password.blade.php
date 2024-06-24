@extends('frontend.layouts.layout')
@section('title', __('Rèinitialiser le mot de passe') )

@section('main-content')

    <div style="margin-top: 60px;">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Rèinitialiser le mot de passe</li>
            </ol>
        </nav>
    </div>


    <div class="row row-flex">
        <div class="col-12 col-md-3 content p-5"></div>
        <div class="col-12 col-md-6 content p-5">

            <h3 class="text-center mb-3">Rèinitialiser le mot de passe</h3>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-group mb-4">
                    <label class="form-control-label" for="email">Adresse e-mail : <span class="small text-danger">*</span></label>
                    <input id="email" type="text" name="email"
                           class="@error('email') is-invalid @enderror form-control" required
                           value="{{ old('email', $request->email) }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-control-label" for="password">Mot de passe : <span
                            class="small text-danger">*</span></label>
                    <input id="password" type="password" name="password"
                           class="@error('password') is-invalid @enderror form-control" required>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-control-label" for="password_confirmation">Confirmer le mot de passe :
                        <span class="small text-danger">*</span></label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="@error('password_confirmation') is-invalid @enderror form-control" required>
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <button class="btn btn-primary  btn-lg w-100 hvr-grow-shadow">
                        {{ __('Reset Password') }}
                    </button>
                </div>

            </form>
        </div>
        <div class="col-12 col-md-3 content p-5"></div>
    </div>

@endsection
