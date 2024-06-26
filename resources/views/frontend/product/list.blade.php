@extends('frontend.layouts.layout')

@section('title', 'Liste de tous nous produits')

@section('main-content')

    <div style="margin-top: -15px;" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 custom-breadcrumb">
                <li class="breadcrumb-item"><a class="link-dark" href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item"><a class="link-dark" href="{{ route('product.first_category_list') }}">Nos Produits</a></li>
                @if($parentCategory = getCategoryParentInfo($category_curent->category_id))
                    @if($grandParentCategory = getCategoryParentInfo($parentCategory->category_id))
                        @if($greatGrandParentCategory = getCategoryParentInfo($grandParentCategory->category_id))
                            <li class="breadcrumb-item"><a class="link-dark" href="/nos-produits/{{ $greatGrandParentCategory->slug }}">{{ $greatGrandParentCategory->name }}</a></li>
                        @endif
                        <li class="breadcrumb-item"><a class="link-dark" href="/nos-produits/{{ $grandParentCategory->slug }}">{{ $grandParentCategory->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item"><a class="link-dark" href="/nos-produits/{{ $parentCategory->slug }}">{{ $parentCategory->name }}</a></li>
                @endif
                <li class="breadcrumb-item active link-dark" aria-current="page">{{ $category_curent->name }}</li>
            </ol>
        </nav>
    </div>


    @if(count($products) > 0)
        <!--- List des produits --->
        <div class="product-header text-center mb-5" data-aos="fade-down">
            <h1>{{ $category_curent->name }}</h1>
        </div>

        @if(!$category_list->isEmpty())
            <div data-aos="zoom-in" class="mb-5">
                @include('frontend.product.partials.list_category')
            </div>
        @endif

        <div data-aos="zoom-in">
            @include('frontend.product.partials.list_product')
        </div>
    @else
        <h2>Il n'y a aucun produit dans cette categorie</h2>
    @endif

@endsection
