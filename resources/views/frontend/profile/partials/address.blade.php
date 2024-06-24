@extends('frontend.profile.dashboard')
@section('title', __('Mes adresses') )


@section('dashboard-breadcrumb')
    <div style="margin-top: 60px;" class="mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Mon compte</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Mes adresses</li>
            </ol>
        </nav>
    </div>
@endsection

@section('dashboard-content')
    <div class="text-end mb-4">
        <a class="hvr-grow-shadow btn btn-warning" href="{{ route('dashboard') }}"><i class="fa-solid fa-circle-left"></i> Retour</a>
    </div>

    <h2 >Mes adresses</h2>
    <p>Retrouvez ici les adresses enregistrées lors de vos précédents achats sur notre site.</p>

    <div class="text-end mb-5">
        <a href="{{ route('address.create') }}" class="btn btn-success hvr-grow-shadow"><i class="fa-solid fa-plus"></i> Ajouter une nouvelle adresse</a>
    </div>

    @include('frontend.profile.partials.address_list')

@endsection
