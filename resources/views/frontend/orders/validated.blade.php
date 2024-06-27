@extends('frontend.layouts.layout')
@section('title', __('Commande valider') )

@section('main-content')

    <div style="margin-top: 60px;" class="mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Commande validée</li>
            </ol>
        </nav>
    </div>

    <h2 class="text-center mb-5">Votre commande est validée, elle sera traitée dans les plus brefs délais.</h2>
    <h3 class="text-center mb-5">Merci d'avoir passé votre commande ! </h3>

    <div class="text-center">
        <a class="hvr-grow-shadow btn btn-warning btn-lg mb-2" href="{{ route('orders.show') }}"><i class="fa-solid fa-basket-shopping"></i> Consulter mes commandes</a>
    </div>

@endsection
