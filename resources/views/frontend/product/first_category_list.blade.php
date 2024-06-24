@extends('frontend.layouts.layout')

@section('title', 'Nos produits')

@section('main-content')

    <div style="margin-top: 60px;" class="mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Nos Produits</li>
            </ol>
        </nav>
    </div>

    <div class="text-center">
        <h1 class="mb-3">Nos produits</h1>
        <h3 class="mb-5">Des choix de grande qualité</h3>
    </div>

    <div class="container_slider">
        @foreach($first_category_list as $category)
            <div id="{{ $category->id }}" role="button" class="slider_section" style="background-image: url('{{ getImageUrl('/upload/catalog/category/'.$category->image, 800, 800) }}')">
                <div class="slider_content">
                    <p><a href="{{ route('product.list', $category->slug) }}" class="text-decoration-none text-white">{{ $category->name }}</a></p>
                </div>
                <a href="{{ route('product.list', $category->slug) }}" class="slider_overlay"></a>
            </div>
        @endforeach
    </div>

@endsection
