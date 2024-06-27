@extends('frontend.layouts.layout')
@section('title', __('Register') )

@section('main-content')

    <div style="margin-top: -15px;" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3">
                <li class="breadcrumb-item">
                    <a class="link-dark" href="{{ route('index') }}">
                        <i class="fa-solid fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item active link-dark" aria-current="page">Demande de création de compte</li>
            </ol>
        </nav>
    </div>

    <h1 class="text-center mb-5">Bienvenue</h1>
    <p class="text-center">Rempliser le formulaire de demande de création de compte.</p>


    <div class="row row-flex">
        <div class="col-12 col-md-2 content p-5"></div>
        <div class="col-12 col-md-8 content p-5">
            <form method="POST" action="">
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
                    <label class="form-control-label" for="cities">Type de l'entreprise <span
                            class="small text-danger">*</span> : </label>
                    <select class="form-select" aria-label="Default select example" name="cities" id="cities">
                        <option value="Association">Association ou Pension</option>
                        <option value="Éleveurs">Éleveurs</option>
                        <option value="Commerce">Commerce</option>
                        <option value="GMS">GMS</option>
                        <option value="Revendeur">Revendeur</option>
                        <option value="Vétérinaire">Vétérinaire</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label class="form-control-label" for="entreprise_name">Nom de l'entreprise : </label>
                    <input id="entreprise_name" type="entreprise_name" name="entreprise_name"
                           class="@error('entreprise_name') is-invalid @enderror form-control"
                           value="{{ old('entreprise_name') }}">
                    @error('entreprise_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-control-label" for="siret">Siret : </label>
                    <input id="siret" type="text" name="siret"
                           class="@error('siret') is-invalid @enderror form-control"
                           value="{{ old('siret') }}">
                    @error('siret')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                        <div class="form-group mb-4">
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

                <div class="text-center mt-4">
                    <button class="btn btn-primary btn-lg hvr-grow-shadow w-100">
                        Envoyer la demande
                    </button>
                </div>

            </form>
        </div>
        <div class="col-12 col-md-2 content p-5"></div>
    </div>
@endsection
