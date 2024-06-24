@extends('frontend.profile.dashboard')
@section('title', __('Mes commandes') )


@section('dashboard-breadcrumb')
    <div style="margin-top: 60px;" class="mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Mon compte</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Mes commandes</li>
            </ol>
        </nav>
    </div>
@endsection

@section('dashboard-content')
    <div class="text-end mb-4">
        <a class="hvr-grow-shadow btn btn-warning" href="{{ route('dashboard') }}"><i class="fa-solid fa-circle-left"></i> Retour</a>
    </div>

    <h2>Mes commandes</h2>

    <div class="row d-flex justify-content-between align-items-center text-center">
        <div class="col-md-3">
            Date
        </div>
        <div class="col-md-4">
            Réference
        </div>
        <div class="col-md-2">
            Total TTC
        </div>
        <div class="col-md-1">
            Status
        </div>
        <div class="col-md-2">
            Détails
        </div>
    </div>
    <hr>

    @foreach($orders as $order)
        <div class="row d-flex justify-content-between align-items-center text-center">
            <div class="col-md-3">
                {{ formatDateInFrench($order->created_at->format('Y-m-d')) }}
            </div>
            <div class="col-md-4">
                @if($order->ref_order)
                    {{ $order->ref_order }}
                @else
                    {{ $order->id }}
                @endif
            </div>
            <div class="col-md-2">
                <b>{{ formatPriceToFloat($order->total_ttc) }} €</b>
            </div>
            <div class="col-md-1">
                {{ $order->getStatus() }}
            </div>
            <div class="col-md-2">
                <button class="btn btn-warning rounded-5 text-end" data-bs-toggle="modal" data-bs-target="#order{{ $order->id }}"><i class="fa-solid fa-circle-info"></i></button>
            </div>
        </div>
        <hr>
        @include('frontend.profile.partials.orders_order_modal')
    @endforeach

@endsection
