@extends('frontend.layouts.layout')

@section('title', 'Liste de tous nous produits')

@section('main-content')

    <div style="margin-top: 60px;" class="mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('product.first_category_list') }}">Nos Produits</a></li>
                @if(@getCategoryParentInfo($category_curent->category_id))
                    @if(@getCategoryParentInfo(getCategoryParentInfo($category_curent->category_id)->category_id) != null)
                        <li class="breadcrumb-item"><a href="/nos-produits/{{ getCategoryParentInfo(getCategoryParentInfo($category_curent->category_id)->category_id)->slug }}">{{ getCategoryParentInfo(getCategoryParentInfo($category_curent->category_id)->category_id)->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item"><a href="/nos-produits/{{ getCategoryParentInfo($category_curent->category_id)->slug }}">{{ getCategoryParentInfo($category_curent->category_id)->name }}</a></li>
                @endif
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $category_curent->name }}</li>
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
        <h1>Il n'y as aucun produits dans cette categorie</h1>
    @endif

@endsection
