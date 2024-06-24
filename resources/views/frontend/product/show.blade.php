@extends('frontend.layouts.layout')

@section('title', $product->name)

@section('main-content')

    <div style="margin-top: 60px;" class="mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('product.first_category_list') }}">Nos Produits</a></li>
                @if(@getCategoryParentInfo($product->category->category_id))
                    @if(@getCategoryParentInfo(getCategoryParentInfo($product->category->category_id)->category_id) != null)
                        <li class="breadcrumb-item"><a href="/nos-produits/{{ getCategoryParentInfo(getCategoryParentInfo($product->category->category_id)->category_id)->slug }}">{{ getCategoryParentInfo(getCategoryParentInfo($product->category->category_id)->category_id)->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item"><a href="/nos-produits/{{ getCategoryParentInfo($product->category->category_id)->slug }}">{{ getCategoryParentInfo($product->category->category_id)->name }}</a></li>
                @endif
                @if($product->category)
                    <li class="breadcrumb-item"><a href="/nos-produits/{{ $product->category->slug }}">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>

    <div class="position-relative">
        <h1 class="text-center mb-5"  data-aos="flip-up">{{ $product->name }}</h1>
        <div class="position-absolute top-0" style="right: 25px;">
            <div class="d-flex justify-content-end">
                <div><button class="btn btn-warning rounded-5" data-bs-toggle="modal" data-bs-target="#composition"><i class="fa-solid fa-circle-info"></i></button></div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="composition" tabindex="-1" aria-labelledby="composition" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Ingrédients, Allergènes, etc...</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {!! nl2br($product->composition) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 col-12" data-aos="fade-up-right">
            @foreach($product->images as $image)
                @if($image->id == $product->fav_image)
                    <img src="{{ $image->getImageUrl() }}" class="img-fluid" alt="{{ $product->name }}">
                @endif
            @endforeach
        </div>

        <div class="col-md-7 col-12" data-aos="fade-left">

            <h4 class="text-center mb-5">{{ $product->short_description }}</h4>
            <div class="row row-cols-2 align-items-center mb-4">
                <div class="col align-self-start">
                    <p>
                        Ref: {{ $product->code_article }}<br>
                        @if($product->stock_unit == 'kg')
                            Stock : {{ formatStockToFloat($product->stock) }} Kg<br>
                        @else
                            Stock : {{ formatStockToFloat($product->stock) }}<br>
                            Poids à l'unité : {{ formatPriceToFloat($product->weight) .' '. $product->weight_unit }}
                        @endif

                    </p>
                </div>
                <div class="col">
                    @if(array_key_exists($product->id,$discountProducts))
                        @if($product->stock_unit == 'kg')
                            <h2 class="text-end text-decoration-line-through">{{ formatPriceToFloat($product->price_ttc) }} € / Kg</h2>
                            @if($discountProducts[$product->id]['fixed_priceTTC'])
                                <p class="text-end">
                                    Prix HT: <span class="text-decoration-line-through">{{ formatPriceToFloat($product->price_ht) }} € / Kg</span>
                                    <b>{{ formatPriceToFloat($discountProducts[$product->id]['fixed_priceTTC']) }} € / Kg</b>
                                    <br>TVA: {{ formatPriceToFloat($product->tva) }} %
                                </p>
                            @else
                                <p class="text-end">
                                    Prix HT: <span class="text-decoration-line-through">{{ formatPriceToFloat($product->price_ht) }} € / Kg</span>
                                    <b>{{ formatPriceToFloat($product->price_ht - ($product->price_ht * $discountProducts[$product->id]['discountPercentage']) / 100) }} € / Kg</b>
                                    <br>TVA: {{ formatPriceToFloat($product->tva) }} %
                                </p>
                            @endif
                        @else
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
                        @endif
                    @else
                        @if($product->stock_unit == 'kg')
                            <p class="text-end">Prix HT au Kg: {{ formatPriceToFloat($product->price_ht) }} €<br>
                                TVA: {{ formatPriceToFloat($product->tva) }} %</p>
                            <h1 class="text-end">{{ formatPriceToFloat($product->price_ttc) }} € le Kg</h1>
                        @else
                            <p class="text-end">Prix HT: {{ formatPriceToFloat($product->price_ht) }} €<br>
                            TVA: {{ formatPriceToFloat($product->tva) }} %</p>
                            <h1 class="text-end">{{ formatPriceToFloat($product->price_ttc) }} €</h1>
                        @endif
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

                                @if($product->stock_unit == 'kg')
                                    @if($discountProducts[$product->id]['fixed_priceTTC'])
                                        <div class="text-center">
                                            <h1 style="font-size: 44px;" class="mt-3 text-center text-danger">{{ formatPriceToFloat($discountProducts[$product->id]['fixed_priceTTC'] / 10) }} €</h1>
                                            <p style="margin-top: -12px;">les 100 grammes</p>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <h1 style="font-size: 44px;" class="mt-3 text-center text-danger">{{ formatPriceToFloat(($product->price_ttc - ($product->price_ttc * $discountProducts[$product->id]['discountPercentage']) / 100) / 10) }} €</h1>
                                            <p style="margin-top: -12px;">les 100 grammes</p>
                                        </div>
                                    @endif
                                @else
                                    @if($discountProducts[$product->id]['fixed_priceTTC'])
                                        <h1 style="font-size: 44px;" class="mt-3 text-center text-danger">{{ formatPriceToFloat($discountProducts[$product->id]['fixed_priceTTC']) }} €</h1>
                                    @else
                                        <h1 style="font-size: 44px;" class="mt-3 text-center text-danger">{{ formatPriceToFloat($product->price_ttc - ($product->price_ttc * $discountProducts[$product->id]['discountPercentage']) / 100) }} €</h1>
                                    @endif
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
                            @if($product->stock_unit == 'kg')
                                <select class="form-control text-end me-3" style="width: 100px;" name="quantity" id="quantity">
                                    @for ($i = 1; $i <= $product->stock / 100; $i++)
                                        <option value="{{ $i }}00">{{ $i }}00 grammes</option>
                                    @endfor
                                </select>
                            @else
                                <select class="form-control text-end me-3" style="width: 75px;" name="quantity" id="quantity">
                                    @for ($i = 1; $i <= $product->stock / 1000; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            @endif
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

        </div>
    </div>

    {!! $product->content !!}

@endsection
