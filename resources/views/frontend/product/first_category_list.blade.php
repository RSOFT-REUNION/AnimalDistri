@extends('frontend.layouts.layout')

@section('title', 'Nos produits')

@section('main-content')

    <div style="margin-top: -15px;" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3">
                <li class="breadcrumb-item">
                    <a class="link-dark" href="{{ route('index') }}">
                        <i class="fa-solid fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item active link-dark" aria-current="page">Nos Produit</li>
            </ol>
        </nav>
    </div>

    <div class="text-center">
        <h1 class="mb-5">Nos produits</h1>
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
