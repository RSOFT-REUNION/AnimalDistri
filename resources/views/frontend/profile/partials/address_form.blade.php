@extends('frontend.profile.dashboard')
@section('title', __('Mes adresses') )


@section('dashboard-breadcrumb')

    <div style="margin-top: -15px;" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 custom-breadcrumb">
                <li class="breadcrumb-item">
                    <a class="link-dark" href="{{ route('index') }}">
                        <i class="fa-solid fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a class="link-dark" href="{{ route('dashboard') }}">
                        Mon compte
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a class="link-dark" href="{{ route('address.index') }}">
                        Mes adresses
                    </a>
                </li>
                <li class="breadcrumb-item active link-dark" aria-current="page">@if ($adresse->exists) Modification @else Ajout @endif d'une adresse</li>
            </ol>
        </nav>
    </div>

@endsection

@section('dashboard-content')
    <div class="text-end mb-4">
        <a class="hvr-grow-shadow btn btn-warning" href="{{ route('address.index') }}"><i class="fa-solid fa-circle-left"></i> Retour</a>
    </div>

    <h2>@if ($adresse->exists) Modification @else Ajout @endif d'une adresse</h2>

    <div class="p-3 w-100">
        <form
            action="{{ route($adresse->exists ? 'address.update' : 'address.store', $adresse) }}"
            method="post" class="mt-6 space-y-6" enctype="multipart/form-data">
            @csrf
            @method($adresse->exists ? 'put' : 'post')

            <div class="form-group">
                <label class="form-control-label" for="alias">Alias <span
                        class="small text-danger">*</span> : </label>
                <input id="alias" type="text" name="alias"
                       class="@error('alias') is-invalid @enderror form-control w-50" required
                       value="{{ old('alias', $adresse->alias) }}">
                @error('alias')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-2">
                    <div class="form-group mb-4">
                        <label class="form-control-label" for="civility">Civilité : <span
                                class="small text-danger">*</span></label>
                        <select class="form-select" aria-label="civility" name="civility" id="civility">
                            <option value="Mr" @if($adresse->civility == 'Mr') selected @endif>Mr</option>
                            <option value="Mme" @if($adresse->civility == 'Mme') selected @endif>Mme</option>
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
                               value="{{ old('last_name', $adresse->first_name) }}">
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
                               value="{{ old('first_name', $adresse->first_name) }}">
                        @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-control-label" for="address">Adresse <span
                                class="small text-danger">*</span> : </label>
                        <input id="address" type="text" name="address"
                               class="@error('address') is-invalid @enderror form-control" required
                               value="{{ old('address', $adresse->address) }}">
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-control-label" for="address2">Complément d'adresse : </label>
                        <input id="address2" type="text" name="address2"
                               class="@error('address2') is-invalid @enderror form-control"
                               value="{{ old('address2', $adresse->address2) }}">
                        @error('address2')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label class="form-control-label" for="country">Pays <span
                                class="small text-danger">*</span> : </label>
                        <input id="country" type="text" name="country" class="form-control" value="La Réunion" disabled>
                    </div>
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <label class="form-control-label" for="cities">Code postal - Ville <span
                                class="small text-danger">*</span> : </label>
                        <select class="form-select" aria-label="Default select example" name="cities" id="cities">
                            @foreach($cities  as $city)
                                <option @if($city->postal_code == $adresse->cities) selected @endif value="{{ $city->postal_code }}">{{ $city->city .' - '. $city->postal_code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label class="form-control-label" for="phone">Téléphone <span
                                class="small text-danger">*</span> : </label>
                        <input id="phone" type="text" name="phone"
                               class="@error('phone') is-invalid @enderror form-control" required
                               value="{{ old('phone', $adresse->phone) }}" placeholder="0692">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-control-label" for="other_phone">Autre Téléphone : </label>
                        <input id="other_phone" type="text" name="other_phone"
                               class="@error('other_phone') is-invalid @enderror form-control"
                               value="{{ old('other_phone', $adresse->other_phone) }}">
                        @error('other_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label class="form-control-label" for="other">Autre informations :</label>
                <input id="other" type="text" name="other"
                       class="@error('other') is-invalid @enderror form-control"
                       value="{{ old('other', $adresse->other) }}">
                @error('other')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2 justify-content-center mt-3">
                <button type="submit" class="btn btn-success">
                    @if ($adresse->exists)
                        <i class="fa-solid fa-pen-to-square"></i> Modifier
                    @else
                        <i class="fa-solid fa-plus"></i> Ajouter
                    @endif
                </button>&nbsp;&nbsp;
            </div>

        </form>
    </div>

@endsection
