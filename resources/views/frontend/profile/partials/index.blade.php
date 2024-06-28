@extends('frontend.profile.dashboard')
@section('title', __('Mon Compte') )

@section('dashboard-breadcrumb')
    <div style="margin-top: -15px;" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 custom-breadcrumb">
                <li class="breadcrumb-item">
                    <a class="link-dark" href="{{ route('index') }}">
                        <i class="fa-solid fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item active link-dark" aria-current="page">Mon compte</li>
            </ol>
        </nav>
    </div>
@endsection

@section('dashboard-content')

    @if(empty(Auth::user()->email_verified_at))
        <div class="row bg-warning align-items-center p-3 rounded-4 mb-4">
            <div class="col-md-2 text-center"><i class="fa-solid fa-triangle-exclamation fa-4x"></i></div>
            <div class="col-md-7"><p>{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p></div>
            <div class="col-md-3">
                <form method="POST" action="{{ route('verification.send') }}" class="p-0 m-0">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg w-100 hvr-grow-shadow">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>
            </div>
        </div>
        <div class="form-group text-center">

        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success fade show top-message"><i class="fa-solid fa-check"></i> {{ __('A new verification link has been sent to the email address you provided during registration.') }}</div>
        @endif
    @endif

    <div class="row row-flex">
        <div class="col-md-3 col-12 mb-4">
            <div class="card bg-gray rounded-4 hvr-grow-shadow w-100">
                <a href="{{ route('info.edit') }}">
                    <div class="card-body text-center text-black">
                        <i class="fa-solid fa-circle-info fa-4x mb-3"></i>
                        <p>Mes informations</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-12 mb-4">
            <div class="card bg-gray rounded-4 hvr-grow-shadow w-100">
                <a href="{{ route('orders.show') }}">
                    <div class="card-body text-center text-black">
                        <i class="fa-solid fa-basket-shopping fa-4x mb-3"></i>
                        <p>Mes commandes</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-12 mb-4">
            <div class="card bg-gray rounded-4 hvr-grow-shadow w-100">
                <a href="{{ route('address.index') }}">
                    <div class="card-body text-center text-black">
                        <i class="fa-solid fa-address-card fa-4x mb-3"></i>
                        <p>Mes adresses</p>
                    </div>
                </a>
            </div>
        </div>

@endsection
