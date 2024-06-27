@extends('frontend.layouts.layout')

@section('title', $product->name)

@section('main-content')



    <div style="margin-top: -15px;" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 custom-breadcrumb">
                <li class="breadcrumb-item">
                    <a class="link-dark" href="{{ route('index') }}">
                        <i class="fa-solid fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a class="link-dark" href="{{ route('product.first_category_list') }}">Nos Produits</a>
                </li>

                @if($product->categories->isNotEmpty())
                    @php
                        // Get the first category of the product
                        $category = $product->categories->first();
                        // Initialize an empty array to store the category hierarchy
                        $categoryHierarchy = [];
                        // Function to recursively get parent categories
                        function getCategoryHierarchy($category) {
                            $hierarchy = [];
                            while ($category) {
                                array_unshift($hierarchy, $category);
                                $category = getCategoryParentInfo($category->category_id);
                            }
                            return $hierarchy;
                        }
                        // Get the full hierarchy for the first category
                        $categoryHierarchy = getCategoryHierarchy($category);
                    @endphp

                    @foreach($categoryHierarchy as $cat)
                        <li class="breadcrumb-item">
                            <a class="link-dark" href="/nos-produits/{{ $cat->slug }}">{{ $cat->name }}</a>
                        </li>
                    @endforeach
                @endif

                <li class="breadcrumb-item active link-dark" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>


    </div>

    <div class="row align-items-center mb-5">
        <div class="col-md-5 col-12" data-aos="fade-up-right">
                <div id="slider" class="flexslider">
                    <ul class="slides">
                        @foreach($product->images as $image)
                            <li>
                                <img src="{{ getImageUrl('/upload/catalog/products/'.$product->id.'/'.$image->name, 500, 500, 'fill-max') }}" alt="{{ $image->name }}">
                            </li>
                        @endforeach
                    </ul>
                </div>
                @if(count($product->images) > 1)
                    <div id="carousel" class="flexslider d-flex justify-content-center">
                        <ul class="slides">
                            @foreach($product->images as $image)
                                <li class="d-flex">
                                    <img src="{{ getImageUrl('/upload/catalog/products/'.$product->id.'/'.$image->name, 200, 200, 'fill-max') }}" alt="{{ $image->name }}">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
        </div>

        <div class="col-md-7 col-12" data-aos="fade-left">

            <h1 data-aos="flip-up" class="text-dark">{{ $product->name }}</h1>
            <p class="text-primary mb-4">Code EAN : {{ $product->barcode }}</p>
            <h5 class="mb-4">{{ $product->short_description }}</h5>

            @auth()


            <div class="row row-cols-2 align-items-center mb-4">
                <div class="col align-self-start">
                    <p>
                        Ref: {{ $product->erp_id }}<br>
                        Stock : {{ $product->stock / 1000 }}<br>
                        Poids à l'unité : {{ formatPriceToFloat($product->weight) .' '. $product->weight_unit }}
                    </p>
                </div>
                <div class="col">
                    @if(array_key_exists($product->id,$discountProducts))
                            <h2 class="text-end text-decoration-line-through">{{ formatPriceToFloat($product->price_ttc) }} €</h2>
                            @if($discountProducts[$product->id]['fixed_priceTTC'])
                                @php
                                    $prixPromoHT = $discountProducts[$product->id]['fixed_priceTTC'] / (1 + $product->tva / 100);
                                @endphp
                                <p class="text-end">
                                    Prix HT: <span class="text-decoration-line-through">{{ formatPriceToFloat($product->price_ht) }} €</span> <b>{{ formatPriceToFloat($discountProducts[$product->id]['fixed_priceTTC'] - $prixPromoHT) }} €</b>
                                    <br>TVA: {{ formatPriceToFloat($product->tva) }} %
                                </p>
                            @else
                                <p class="text-end">
                                    Prix HT: <span class="text-decoration-line-through">{{ formatPriceToFloat($product->price_ht) }} €</span>
                                    <b>{{ formatPriceToFloat($product->price_ht - ($product->price_ht * $discountProducts[$product->id]['discountPercentage']) / 100) }} €</b>
                                    <br>TVA: {{ formatPriceToFloat($product->tva) }} %
                                </p>
                            @endif
                    @else
                            <p class="text-end">Prix HT: {{ formatPriceToFloat($product->price_ht) }} €<br>
                            TVA: {{ formatPriceToFloat($product->tva) }} %</p>
                            <h1 class="text-end">{{ formatPriceToFloat($product->price_ttc) }} €</h1>
                    @endif
                </div>
            </div>

            @if(array_key_exists($product->id,$discountProducts))
                <div class="d-flex justify-content-center mb-4">
                    <div class="card w-75 shadow hvr-float bg-gray">
                        <div class="card-body position-relative">
                            @if($discountProducts[$product->id]['fixed_priceTTC'])
                                <h3 class="position-absolute top-0 start-100 translate-middle"><span class="badge text-bg-danger">
                                    Promo
                                </span></h3>
                            @else
                                <h3 class="position-absolute top-0 start-100 translate-middle"><span class="badge text-bg-danger">
                                    Promo -{{ $discountProducts[$product->id]['discountPercentage'] }} %
                                </span></h3>
                            @endif
                            <div class="d-flex justify-content-end">
                                    @if($discountProducts[$product->id]['fixed_priceTTC'])
                                        <h1 style="font-size: 44px;" class="mt-3 text-center text-danger">{{ formatPriceToFloat($discountProducts[$product->id]['fixed_priceTTC']) }} €</h1>
                                    @else
                                        <h1 style="font-size: 44px;" class="mt-3 text-center text-danger">{{ formatPriceToFloat($product->price_ttc - ($product->price_ttc * $discountProducts[$product->id]['discountPercentage']) / 100) }} €</h1>
                                    @endif
                                <p class=" flex-grow-1 text-center align-self-center mt-3">Offre valable <br>{{ ucfirst(formatDateInFrench($discountProducts[$product->id]['start_date'])) }} au {{ ucfirst(formatDateInFrench($discountProducts[$product->id]['end_date'])) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="text-center mb-4">
                @if($product->stock > 0)
                    <form>  @csrf
                        <div class="d-flex justify-content-center">
                                <select class="form-control text-end me-3" style="width: 75px;" name="quantity" id="quantity">
                                    @for ($i = 1; $i <= $product->stock / 1000; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <button type="button" class="btn btn-primary btn-lg hvr-grow-shadow hvr-icon-buzz-out" id="add_cart"
                                        hx-post="{{ route('cart.add_product', $product) }}"
                                        hx-target="#cart_modal"
                                        hx-swap="outerHTML"
                                        hx-trigger="click"
                                        hx-on="htmx:afterOnLoad: showAlert()"><i class="fa-solid fa-cart-plus hvr-icon"></i> Ajouter au panier
                                </button>
                        </div>
                    </form>
                @else
                    <h4 class="text-bg-danger rounded-3 w-50 p-2 mx-auto">Produit en rupture de stock</h4>
                @endif
            </div>

            @endauth

        </div>
    </div>

    <div class="px-5 mb-5">
        <ul class="nav nav-tabs bg-primary rounded-top shadow-sm" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="composition" data-bs-toggle="tab" data-bs-target="#composition-pane" type="button" role="tab" aria-controls="composition-pane" aria-selected="true">Composition</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="constituants" data-bs-toggle="tab" data-bs-target="#constituants-pane" type="button" role="tab" aria-controls="constituants-pane" aria-selected="true">Constituants Analytiques</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="mode_emploi-tab" data-bs-toggle="tab" data-bs-target="#mode_emploi-pane" type="button" role="tab" aria-controls="mode_emploi-pane" aria-selected="false">Mode d'emploi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="additifs-tab" data-bs-toggle="tab" data-bs-target="#additifs-pane" type="button" role="tab" aria-controls="additifs-pane" aria-selected="false">Additifs</button>
            </li>
        </ul>
        <div class="tab-content bg-light rounded-bottom shadow-sm" id="myTabContent">
            <div class="tab-pane fade show active p-3" id="composition-pane" role="tabpanel" aria-labelledby="composition" tabindex="0">
                {!! $product->composition !!}
            </div>
            <div class="tab-pane fade show p-3" id="constituants-pane" role="tabpanel" aria-labelledby="constituants" tabindex="0">
                {!! $product->constituants !!}
            </div>
            <div class="tab-pane fade p-3" id="mode_emploi-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                {!! $product->mode_emploi !!}
            </div>
            <div class="tab-pane fade p-3" id="additifs-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                {!! $product->additifs !!}
            </div>
        </div>
    </div>

    <div class="row row-flex mb-5">
        <h2 class="mb-4">Nos produits similaires</h2>
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
