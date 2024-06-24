@extends('backend.layouts.layout')
@section('title', $administrator->exists ? __('Modifier un administrateur') : __('Créer un administrateur'))


@section('main-content')
    <div class="row m-4">
        <div class="col">

            <div class="card border-left-primary shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        @if($administrator->exists)
                            Modification
                        @else
                            Création
                        @endif
                        d'un administrateur
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route($administrator->exists ? 'backend.settings.teams.administrators.update' : 'backend.settings.teams.administrators.store', $administrator) }}" method="post"  class="mt-6 space-y-6">
                    @csrf
                    @method($administrator->exists ? 'put' : 'post')

                        <div class="form-group focused">
                            <label class="form-control-label" for="name">Nom<span class="small text-danger">*</span></label>
                            <input id="name" type="text" name="name"
                                   class="@error('name') is-invalid @enderror form-control" required
                                   value="{{ old('name', $administrator->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="email">Email<span class="small text-danger">*</span></label>
                            <input id="email" type="email" name="email"
                                   class="@error('email') is-invalid @enderror form-control" required
                                   value="{{ old('email', $administrator->email) }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(!$administrator->exists)
                            <div class="form-group">
                                <label class="form-control-label" for="password">Mot de passe<span class="small text-danger">*</span></label>
                                <input id="password" type="password" name="password"
                                       class="@error('password') is-invalid @enderror form-control" required
                                       value="{{ old('password') }}">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="m-0w">
                            <label for="permissions" class="form-label">Roles</label>
                            <select class="form-select tomselectmultiple @error('roles') is-invalid @enderror" multiple aria-label="Roles" id="roles" name="roles[]">
                                @foreach($roles as $role)
                                    @if ($role!='SuperAdmin')
                                        <option value="{{ $role }}" {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }} {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @else
                                        @if (Auth::user()->hasRole('SuperAdmin'))
                                            <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                                {{ $role }}
                                            </option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                            @error('roles')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 justify-content-center mt-3">
                            <button type='button' class="btn btn-danger" onclick="location.href='{{ route('backend.settings.teams.index') }}'">
                                <i class="fa-solid fa-rotate-left"></i>&nbsp;Annuler
                            </button>
                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i>
                                @if($administrator->exists)
                                    Modifier
                                @else
                                    Créer
                                @endif
                            </button>&nbsp;&nbsp;
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
