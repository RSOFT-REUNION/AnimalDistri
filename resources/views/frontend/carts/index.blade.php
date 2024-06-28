@extends('frontend.layouts.layout')
@section('title', __('Mon Panier') )

@section('main-content')

    <div style="margin-top: -15px;" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 custom-breadcrumb">
                <li class="breadcrumb-item">
                    <a class="link-dark" href="{{ route('index') }}">
                        <i class="fa-solid fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item active link-dark" aria-current="page">Mon panier</li>
            </ol>
        </nav>
    </div>

    @include('frontend.carts.cart_fragment')

    <div class="text-center mt-4 mb-5">
        <a href="{{ route('index')}}" class="btn btn-warning btn-lg hvr-grow-shadow"><i
                    class="fa-solid fa-circle-left"></i> Continuer mes achats </a>
    </div>

@endsection
