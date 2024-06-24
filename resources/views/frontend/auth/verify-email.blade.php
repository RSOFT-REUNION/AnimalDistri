@extends('frontend.layouts.layout')
@section('title', __('Vérification de l\'adresse mail') )

@section('main-content')

    <div style="margin-top: 60px;">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Vérification de l'adresse mail</li>
            </ol>
        </nav>
    </div>

    <div class="row row-flex">
        <div class="col-12 col-md-3 content p-5"></div>
        <div class="col-12 col-md-6 content p-5">

            <h3 class="text-center mb-5">Vérification de l'adresse mail</h3>
            <p>{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>

                    <div class="form-group text-center">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                                <button type="submit" class="btn btn-primary btn-lg w-100 hvr-grow-shadow">
                                    {{ __('Resend Verification Email') }}
                                </button>
                                <br><br>
                        </form>
                        <form method="POST" action="{{ route('logout') }}"> @csrf <button class="btn btn-danger btn-lg mt-2">{{ __('Log Out') }}</button> </form>
                    </div>

        </div>
        <div class="col-12 col-md-3 content p-5"></div>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success fade show top-message"><i class="fa-solid fa-check"></i> {{ __('A new verification link has been sent to the email address you provided during registration.') }}</div>
    @endif
@endsection
