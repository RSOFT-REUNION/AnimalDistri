@extends('backend.layouts.layout')
@section('title', __('Gestion des administrateurs') )

@section('main-content')

    <div class="m-4">
        <ul class="nav nav-pills mb-3" id="myTab">
            @canany(filtrerPermission('settings.teams.administrators'))
                <li class="nav-item">
                    <a href="#Administrateurs" class="nav-link active" data-bs-toggle="tab">Administrateurs</a>
                </li>
            @endcanany
            @canany(filtrerPermission('settings.teams.roles'))
                <li class="nav-item">
                    <a href="#Roles" class="nav-link" data-bs-toggle="tab">Roles</a>
                </li>
            @endcanany
        </ul>
        <div class="tab-content">
            @canany(filtrerPermission('settings.teams.administrators'))
                <div class="tab-pane fade show active mb-3" id="Administrateurs">
                    {!! app('App\Http\Controllers\Backend\Settings\Teams\AdministratorsController')->index() !!}
                </div>
            @endcanany
            @canany(filtrerPermission('settings.teams.roles'))
                <div class="tab-pane fade  mb-3" id="Roles">
                    {!! app('App\Http\Controllers\Backend\Settings\Teams\RolesController')->index() !!}
                </div>
            @endcanany
        </div>
    </div>

@endsection
