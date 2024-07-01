@extends('frontend.layouts.layout')
@section('title', __('Changement du mot de passe') )

@section('main-content')

    <div style="margin-top: -15px;" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3">
                <li class="breadcrumb-item"><a class="link-dark" href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item active link-dark" aria-current="page">Changement du mot de passe</li>
            </ol>
        </nav>
    </div>


    <div class="row row-flex">
        <div class="col-12 col-md-3 content p-5"></div>
        <div class="col-12 col-md-6 content p-5">

            <h3 class="text-center mb-3">Changement du mot de passe</h3>

            <form method="post" action="{{ route('password.changePassword') }}" class="mt-6 space-y-6">
                @csrf

                <div class="form-group mb-4">
                    <label class="form-control-label" for="update_password_password">{{ __('New Password') }} : <span
                            class="small text-danger">*</span></label>
                    <input id="update_password_password" type="password" name="password" autocomplete="new-password"
                           class="@error('password') is-invalid @enderror form-control" required>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-control-label" for="update_password_password_confirmation">{{ __('Confirm Password') }} : <span
                            class="small text-danger">*</span></label>
                    <input id="update_password_password_confirmation" type="password" name="password_confirmation"  autocomplete="new-password"
                           class="@error('password_confirmation') is-invalid @enderror form-control" required>
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <button class="btn btn-primary  btn-lg w-100 hvr-grow-shadow">
                        {{ __('Changer le mot de passe') }}
                    </button>
                </div>

            </form>
        </div>
        <div class="col-12 col-md-3 content p-5"></div>
    </div>

@endsection
