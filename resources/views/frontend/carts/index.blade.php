@extends('frontend.layouts.layout')
@section('title', __('Mon Panier') )

@section('main-content')

    <div style="margin-top: 60px;" class="mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Mon panier</li>
            </ol>
        </nav>
    </div>

    @include('frontend.carts.cart_fragment')

    <div class="text-center mt-4 mb-5">
        <a href="{{ route('index')}}" class="btn btn-warning btn-lg hvr-grow-shadow"><i
                    class="fa-solid fa-circle-left"></i> Continuer mes achats </a>
    </div>

@endsection
