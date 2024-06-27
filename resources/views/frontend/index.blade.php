@extends('frontend.layouts.layout')
@section('title', __('Bienvenue') )

@section('main-content')

    <div class="text-center">
        <h1 class="mb-5">Nos produits</h1>
    </div>

    <div class="container_slider mb-4">
        @foreach($first_category_list as $category)
            <div id="{{ $category->id }}" role="button" class="slider_section" style="background-image: url('{{ getImageUrl('/upload/catalog/category/'.$category->image, 800, 800) }}')">
                <div class="slider_content">
                    <p><a href="{{ route('product.list', $category->slug) }}" class="text-decoration-none text-white">{{ $category->name }}</a></p>
                </div>
                <a href="{{ route('product.list', $category->slug) }}" class="slider_overlay"></a>
            </div>
        @endforeach
    </div>

    {!! $page->content !!}

    <div class="row row-flex mb-5">
        <h2 class="mb-4">Découvrez nos produits</h2>
        @if(count($products_random) > 0)
            @foreach($products_random as $product)
                <div class="col-md-2 col-12 hvr-float-shadow mb-4">
                    @include('frontend.product.partials.products-card')
                </div>
            @endforeach
        @else
            <h3>Aucun produit ne correspond</h3>
        @endif
    </div>

@endsection
