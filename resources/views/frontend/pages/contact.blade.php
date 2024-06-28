@extends('frontend.layouts.layout')
@section('title', __('contactez-nous') )

@section('main-content')

    <div style="margin-top: -15px;" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 custom-breadcrumb">
                <li class="breadcrumb-item">
                    <a class="link-dark" href="{{ route('index') }}">
                        <i class="fa-solid fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item active link-dark" aria-current="page">Contactez-nous</li>
            </ol>
        </nav>
    </div>


    <div class="text-center mb-5">
        <h1>Contact</h1>
        <h3>Nous joindre facilement</h3>
    </div>

    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <h2 class="text-center mb-4">Ecrivez-nous</h2>
                        <div class="form-group mb-4">
                            <label class="form-control-label" for="name">Nom : <span
                                    class="small text-danger">*</span></label>
                            <input id="name" type="text" name="name"
                                   class="@error('name') is-invalid @enderror form-control" required
                                   value="{{ old('name') }}">
                            @error('name')
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

                        <div class="form-group mb-4">
                            <label class="form-control-label" for="subject">Sujet : <span
                                    class="small text-danger">*</span></label>
                            <input id="subject" type="text" name="subject"
                                   class="@error('subject') is-invalid @enderror form-control" required
                                   value="{{ old('subject') }}">
                            @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-control-label" for="message">Message : <span
                                    class="small text-danger">*</span></label>
                            <textarea rows="4" id="message" type="text" name="message"
                                   class="@error('message') is-invalid @enderror form-control" required>{{ old('message') }}</textarea>
                            @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    <div class="text-center">
                        <button class="btn btn-warning hvr-grow-shadow">
                            <i class="fa-regular fa-paper-plane"></i> {{ __('Envoyer') }}
                        </button>
                    </div>

                    <div class="mt-5">
                        <p>Tous les champs comportant <span class="text-red-500">*</span> sont obligatoire.</p>
                        <p class="mt-3">
                            Aügur utilise les données recueillies pour traiter vos demandes. Pour en savoir plus sur
                            la gestion de vos données personnelles et pour exercer vos droits, reportez-vous à nos
                            <a href="{{ route('termsofservice') }}" class="font-bold text-black">conditions générales d'utilisation</a>
                        </p>
                    </div>

            </div>
    </div>
@endsection
