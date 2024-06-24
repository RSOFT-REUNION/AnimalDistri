@extends('frontend.layouts.layout')
@section('title', __('Register') )

@section('main-content')

    <div style="margin-top: 60px;">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ __('Register') }}</li>
            </ol>
        </nav>
    </div>

    <h1 class="text-center mb-5">Bienvenue sur Augur</h1>
    <p>Créez en quelques minutes votre compte pour profiter pleinement de votre Programme de Fidélité, commander en ligne en Livraison à domicile ou en Click & Collect, et encore plein d'autres fonctionnalités.</p>


    <div class="row row-flex">
        <div class="col-12 col-md-2 content p-5"></div>
        <div class="col-12 col-md-8 content p-5">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row">
                    <div class="col-2">
                        <div class="form-group mb-4">
                            <label class="form-control-label" for="civility">Civilité : <span
                                    class="small text-danger">*</span></label>
                            <select class="form-select" aria-label="civility" name="civility" id="civility">
                                <option value="Mr" selected>Mr</option>
                                <option value="Mme">Mme</option>
                            </select>
                            @error('civility')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group mb-4">
                            <label class="form-control-label" for="last_name">Nom : <span
                                    class="small text-danger">*</span></label>
                            <input id="last_name" type="text" name="last_name"
                                   class="@error('last_name') is-invalid @enderror form-control" required
                                   value="{{ old('last_name') }}">
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group mb-4">
                            <label class="form-control-label" for="first_name">Prenom : <span
                                    class="small text-danger">*</span></label>
                            <input id="first_name" type="text" name="first_name"
                                   class="@error('first_name') is-invalid @enderror form-control" required
                                   value="{{ old('first_name') }}">
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-control-label" for="email">Adresse e-mail : <span
                            class="small text-danger">*</span></label>
                    <input id="email" type="email" name="email"
                           class="@error('email') is-invalid @enderror form-control" required
                           value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-4">
                            <label class="form-control-label" for="password">Mot de passe : <span
                                    class="small text-danger">*</span></label>
                            <input id="password" type="password" name="password"
                                   class="@error('password') is-invalid @enderror form-control" required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-4">
                            <label class="form-control-label" for="password_confirmation">Confirmer le mot de passe :
                                <span class="small text-danger">*</span></label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   class="@error('password_confirmation') is-invalid @enderror form-control" required>
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-control-label" for="address">Adresse <span
                                    class="small text-danger">*</span> : </label>
                            <input id="address" type="text" name="address"
                                   class="@error('address') is-invalid @enderror form-control" required
                                   value="{{ old('address') }}">
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label class="form-control-label" for="address2">Complément d'adresse : </label>
                            <input id="address2" type="text" name="address2"
                                   class="@error('address2') is-invalid @enderror form-control"
                                   value="{{ old('address2') }}">
                            @error('address2')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-control-label" for="cities">Code postal - Ville <span
                                    class="small text-danger">*</span> : </label>
                            <select class="form-select" aria-label="Default select example" name="cities" id="cities">
                                @foreach($cities  as $city)
                                    <option value="{{ $city->postal_code }}">{{ $city->city .' - '. $city->postal_code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-4">
                            <label class="form-control-label" for="phone">Numéro de téléphone : <span class="small text-danger">*</span></label>
                            <input id="phone" type="text" name="phone"
                                   class="@error('phone') is-invalid @enderror form-control" required
                                   value="{{ old('phone') }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-control-label" for="birthday">Date de naissance <span
                                    class="small text-danger">*</span> : </label>
                            <input type="date" id="birthday" name="birthday"
                                   class="@error('birthday') is-invalid @enderror form-control"
                                   value="{{ old('birthday') }}">
                            @error('birthday')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-check form-switch mb-3 pl-5">
                    <input type="checkbox" class="form-check-input" id="newsletter"
                           name="newsletter" {{ old('newsletter') ? 'checked' : '' }}>
                    <label class="form-check-label" for="newsletter">Je souhaite m'abonner à la newsletter</label>
                </div>

                <div class="form-check form-switch mb-5 pl-5">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} required>
                    <label class="form-check-label" for="remember">J'accepte les <a href="{{ route('legalnotice') }}" target="_blank" class="blackcolor">Mentions légales</a> et les <a class="blackcolor" href="{{ route('termsofservice') }}" target="_blank">CGU</a> <span class="small text-danger">*</span></label>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary btn-lg hvr-grow-shadow w-100">
                        {{ __('Register') }}
                    </button>
                </div>

            </form>
        </div>
        <div class="col-12 col-md-2 content p-5"></div>
    </div>
@endsection
