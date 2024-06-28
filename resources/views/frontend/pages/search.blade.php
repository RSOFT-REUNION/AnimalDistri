@extends('frontend.layouts.layout')

@section('title', 'Recherche')

@section('main-content')

    <div style="margin-top: -15px;" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 custom-breadcrumb">
                <li class="breadcrumb-item">
                    <a class="link-dark" href="{{ route('index') }}">
                        <i class="fa-solid fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item active link-dark" aria-current="page">Recherche</li>
            </ol>
        </nav>
    </div>


    <div class="text-center" data-aos="fade-left">
        <h2 class="mb-3">Recherche : <b>{{ $search }}</b></h2>
    </div>

    <div class="mb-5">
        @if(count($products) > 0)
            <div class="row row-flex">
                @foreach($products as $product)
                    <div class="col-md-3 col-12 hvr-grow mb-3">
                        @include('frontend.product.partials.products-card')
                    </div>
                @endforeach
            </div>
        @else
            <h4>Il n'y as aucun produits qui corresponds a la recherche</h4>
        @endif
    </div>

@endsection
