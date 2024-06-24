@extends('backend.layouts.layout')
@section('title', __('Profile Utilisateur') )

@section('main-content')
    <div class="row m-2">
        <div class="col-lg-4 order-lg-2">

            <div class="card  border-left-primary shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Réinitialiser le mot de passe</h6>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <form method="post" action="{{ route('backend.profile.updatepassword') }}" class="mt-6 space-y-6 needs-validation"  autocomplete="off" novalidate>
                                @csrf

                                <div class="form-group">
                                    <label class="form-control-label" for="currentPassword">Mot de passe actuel <span class="small text-danger">*</span></label>
                                    <input id="currentPassword" type="password" name="currentPassword" placeholder="Entrer le mot de passe actuel"
                                           class="@error('currentPassword') is-invalid @enderror form-control" required>
                                    @error('currentPassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label" for="newPassword">Nouveau mot de passe <span class="small text-danger">*</span></label>
                                    <input id="newPassword" type="password" name="newPassword" placeholder="Entrer le nouveau mot de passe"
                                           class="@error('newPassword') is-invalid @enderror form-control" required>
                                    @error('newPassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label" for="confirmNewPassword">Confirmer le nouveau mot de passe <span class="small text-danger">*</span></label>
                                    <input id="confirmNewPassword" type="password" name="confirmNewPassword" placeholder="Confirmer le nouveau mot de passe"
                                           class="@error('confirmNewPassword') is-invalid @enderror form-control" required>
                                    @error('confirmNewPassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2 justify-content-center">
                                    <button class="btn btn-success hvr-grow"><i class="fa-solid fa-pen-to-square"></i>
                                        Modifier
                                    </button>&nbsp;&nbsp;
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-8 order-lg-1">

            <div class="card  border-left-primary shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mes informations</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('backend.profile.edit') }}" autocomplete="off" class="needs-validation" novalidate>
                        @csrf

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Nom<span class="small text-danger">*</span></label>
                                        <input id="name" type="text" name="name"
                                               class="@error('name') is-invalid @enderror form-control" required
                                               value="{{ old('name', Auth::user()->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Adresse Email<span
                                                class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="@error('email') is-invalid @enderror form-control" name="email"
                                               placeholder="example@example.com" required
                                               value="{{ old('email', Auth::user()->email) }}">
                                        @error("email")
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex gap-2 justify-content-center">
                            <button type="submit" class="btn btn-success hvr-grow"><i class="fa-solid fa-pen-to-square"></i>
                                Modifier
                            </button>&nbsp;&nbsp;
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection
