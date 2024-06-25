@extends('frontend.layouts.layout')
@section('title', __('Bienvenue') )

@section('main-content')

    {!! $page->content !!}

    <div class="row row-flex mb-5">
        <h2 class="mb-4">Découvrez nos produits</h2>
        @if(count($products_random) > 0)
            @foreach($products_random as $product)
                <div class="col-md-3 col-12 hvr-float-shadow mb-4">
                    @include('frontend.product.partials.products-card')
                </div>
            @endforeach
        @else
            <h3>Aucun produit ne correspond</h3>
        @endif
    </div>

@endsection
