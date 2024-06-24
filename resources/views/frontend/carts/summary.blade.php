@extends('frontend.layouts.layout')
@section('title', __('Récapitulatif de la commande') )

@section('main-content')

    <div style="margin-top: 60px;" class="mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Récapitulatif de la commande</li>
            </ol>
        </nav>
    </div>

    @if ($error_message)
        <div class="text-center">
            <button type="button" class="btn btn-danger mb-3 btn-lg" disabled>{{ $error_message }}</button>
        </div>
    @endif

    <div class="d-none d-lg-block">
        <div class="row d-flex justify-content-between align-items-center text-center">
            <div class="col-md-3">

            </div>
            <div class="col-md-4">
                Désignation
            </div>
            <div class="col-md-2">
                Prix TTC
            </div>
            <div class="col-md-1">
                Quantité
            </div>
            <div class="col-md-2">
                Total
            </div>
        </div>

        <hr>
    </div>
    @foreach($cart->product as $product)
        <div class="row d-flex justify-content-between align-items-center mt-3 mb-3 text-center">
            <div class="col-md-3 mb-2">
                <img src="{{ getImageUrl(removeStorageFromURL($product->fav_image), 200, 200, 'fill-max') }}" class="w-50" alt="{{ $product->name }}">
            </div>
            <div class="col-md-4 mb-2">
                <p class="lead fw-normal mb-2">{{ getProductInfos($product->product_id)->name  }}</p>
            </div>
            <div class="col-md-2 mb-2">
                @if($product->discount_id)
                    <h6 class="text-decoration-line-through text-danger">{{ formatPriceToFloat($product->price_ttc) }} €</h6>
                    @if($discountProducts[$product->product_id]['fixed_priceTTC'])
                        <h5 class="m-3">{{ formatPriceToFloat($discountProducts[$product->product_id]['fixed_priceTTC']) }} €@if($product->stock_unit == 'kg')<br>le Kg @endif</h5>
                    @else
                        <h5 class="m-3">{{ formatPriceToFloat($product->price_ttc - ($product->price_ttc * $discountProducts[$product->product_id]['discountPercentage']) / 100) }} €@if($product->stock_unit == 'kg')<br>le Kg @endif</h5>
                    @endif
                @else
                    <h5 class="mb-0">{{ formatPriceToFloat($product->price_ttc) }} €@if($product->stock_unit == 'kg')<br>le Kg @endif</h5>
                @endif
            </div>
            <div class="col-md-1 mb-2">
                @if($product->stock_unit == 'kg')
                    <label class="d-lg-none"><b>Quantité : </b></label> {{ $product->quantity }} grammes
                @else
                    <label class="d-lg-none"><b>Quantité : </b></label> {{ $product->quantity }}
                @endif
            </div>
            <div class="col-md-2 mb-2">
                @if($product->discount_id)
                    @if($product->stock_unit == 'kg')
                        <h6 class="text-decoration-line-through text-danger">{{ formatPriceToFloat($product->price_ttc  * $product->quantity / 1000) }} €</h6>
                        @if($discountProducts[$product->product_id]['fixed_priceTTC'])
                            <h5 class="m-3">{{ formatPriceToFloat($discountProducts[$product->product_id]['fixed_priceTTC'] * $product->quantity / 1000) }} €</h5>
                        @else
                            <h5 class="m-3">{{ formatPriceToFloat((($product->price_ttc - ($product->price_ttc * $discountProducts[$product->product_id]['discountPercentage']) / 100)  * $product->quantity) / 1000) }} €</h5>
                        @endif
                    @else
                        <h6 class="text-decoration-line-through text-danger">{{ formatPriceToFloat($product->price_ttc  * $product->quantity) }} €</h6>
                        @if($discountProducts[$product->product_id]['fixed_priceTTC'])
                            <h5 class="m-3">{{ formatPriceToFloat($discountProducts[$product->product_id]['fixed_priceTTC'] * $product->quantity) }} €</h5>
                        @else
                            <h5 class="m-3">{{ formatPriceToFloat(($product->price_ttc - ($product->price_ttc * $discountProducts[$product->product_id]['discountPercentage']) / 100)  * $product->quantity )   }} €</h5>
                        @endif
                    @endif
                @else
                    <h5 class="mb-0">{{ formatPriceToFloat($cart->priceProductQuantity($product->id)) }} €</h5>
                @endif
            </div>
        </div>
        <hr>
    @endforeach

    <div class="mb-5">
        <h3 id="sous-total_produit" class="text-end mt-4">Total ({{ $cart->countProduct() }} article(s)) :  {{ formatPriceToFloat($cart->countProductsPrice(0,0)) }} €</h3>
    </div>

<div class="row row-flex justify-content-center align-items-center">
    @if($user_address->id != $user_address->favorite)
        <div class="col-md-5 col-12 mb-3">
            <div class="card bg-gray content">
                <div class="card-body">
                    <div class="text-center">
                        <img class="mb-3" style="width: 100px;" src="{{ asset('frontend/images/location.png') }}">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h5>Adresse de facturation :</h5>
                            <h5>{{ $user_address_fac->alias }}</h5>
                            <p>{{ $user_address_fac->name }}<br>
                                {{ $user_address_fac->address }}
                                {{ $user_address_fac->address2 }}
                                <br>
                                @foreach($cities as $city)
                                    @if($city->postal_code == $user_address_fac->cities)
                                        {{ $city->postal_code }} - {{ $city->city }}
                                    @endif
                                @endforeach
                                - {{ $user_address_fac->country }}
                                <br>
                                Téléphone : {{ $user_address_fac->phone }}
                                @if($user_address_fac->other_phone)
                                    / {{ $user_address_fac->other_phone }}
                                @endif
                            </p>
                        </div>
                        <div class="col-6">
                            <h5>Adresse de livraison :</h5>
                            <h5>{{ $user_address->alias }}</h5>
                            <p>{{ $user_address->name }}<br>
                                {{ $user_address->address }}
                                {{ $user_address->address2 }}
                                <br>
                                @foreach($cities as $city)
                                    @if($city->postal_code == $user_address->cities)
                                        {{ $city->postal_code }} - {{ $city->city }}
                                    @endif
                                @endforeach
                                - {{ $user_address->country }}
                                <br>
                                Téléphone : {{ $user_address->phone }}
                                @if($user_address->other_phone)
                                    / {{ $user_address->other_phone }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-4 col-12 mb-3">
            <div class="card bg-gray content">
                <div class="card-body">
                    <div class="text-center">
                        <img class="w-25 mb-3" src="{{ asset('frontend/images/location.png') }}">
                    </div>
                    <h5>{{ $user_address->alias }}</h5>
                    <p>{{ $user_address->name }} -
                        {{ $user_address->address }}
                        {{ $user_address->address2 }}
                        <br>
                        @foreach($cities as $city)
                            @if($city->postal_code == $user_address->cities)
                                {{ $city->postal_code }} - {{ $city->city }}
                            @endif
                        @endforeach
                        - {{ $user_address->country }}
                        <br>
                        Téléphone : {{ $user_address->phone }}
                        @if($user_address->other_phone)
                            / {{ $user_address->other_phone }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif
        <div class="col-md-4 col-12 mb-3">
            <div class="card bg-gray content">
                <div class="card-body">
                    <div class="row align-items-center text-center">
                        <div class="text-center">
                            <img class="w-25 mb-3 mt-3" src="{{ getImageUrl(('/upload/order/delivery/'.$deliver->image), 100, 100) }}" alt="{{ $deliver->name }}">
                        </div>
                        <h4 class="flex-fill">{{ $deliver->name }}</h4>
                        <h2 class=""><b>@if($deliver->price_ttc == 0) <b>Gratuit</b> @else {{ $deliver->price_ttc }} €@endif</b></h2>
                        @empty(!@$cart->delivery_date)
                            <div class="text-center">
                                <h5>{{ formatDateInFrench($cart->delivery_date) }} :
                                    @if($cart->delivery_slot == 'matin') Entre 9h et 13h @elseif($cart->delivery_slot == 'aprem') Entre 14h et 18h @endif</h5>
                            </div>
                        @endempty
                        <p class="text-center">{{ $deliver->description }}</p>
                    </div>
                </div>
            </div>
        </div>


    <div class="col-md-2 col-12 mb-3">
        @if($cart->loyality == 0)
            <div class="card bg-warning content">
                <div class="card-body">
                    <div class="text-center">
                        <img class="w-50 mb-3 mt-3" src="{{ asset('frontend/images/discount.png') }}">
                        <h4 class="mx-auto">Je ne souhaite pas utiliser mes points</h4>
                    </div>
                </div>
            </div>
        @elseif($cart->loyality == 5)
            <div class="card bg-warning content">
                <div class="card-body">
                    <div class="text-center">
                        <img class="w-50 mb-3 mt-3" src="{{ asset('frontend/images/discount.png') }}">
                        <h2 class="mx-auto">- 5 <i class="fa-solid fa-percent"></i></h2>
                        <p><b>300</b> point de fidélité seront utilisé.</p>
                    </div>
                </div>
            </div>
        @elseif($cart->loyality == 10)
            <div class="card bg-warning content">
                <div class="card-body">
                    <div class="text-center">
                        <img class="w-50 mb-3 mt-3" src="{{ asset('frontend/images/discount.png') }}">
                        <h2 class="mx-auto">- 10 <i class="fa-solid fa-percent"></i></h2>
                        <p><b>500</b> point de fidélité seront utilisé.</p>
                    </div>
                </div>
            </div>
        @elseif($cart->loyality == 15)
            <div class="card bg-warning content">
                <div class="card-body">
                    <div class="text-center">
                        <img class="w-50 mb-3 mt-3" src="{{ asset('frontend/images/discount.png') }}">
                        <h2 class="mx-auto">- 15 <i class="fa-solid fa-percent"></i></h2>
                        <p><b>1 000</b> point de fidélité seront utilisé.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

    <div class="p-3">
        <h2 id="sous-total" class="text-end mt-4">Sous-total ({{ $cart->countProduct() }} article(s)) :  {{ formatPriceToFloat($cart->total_ttc) }} €</h2>
        @if($cart->loyality == 5)
            <h4 class="text-end">Remise de 5% (<b>- {{ formatPriceToFloat($cart->countProductsPrice(0,0) * 5 / 100) }} €</b>) <br> Hors cout de livraison</h4>
        @endif
        @if($cart->loyality == 10)
            <h4 class="text-end">Remise de 10%  (<b>- {{ formatPriceToFloat($cart->countProductsPrice(0,0) * 10 / 100) }} €</b>) <br> Hors cout de livraison</h4>
        @endif
        @if($cart->loyality == 15)
            <h4 class="text-end">Remise de 15% (<b>- {{ formatPriceToFloat($cart->countProductsPrice(0,0) * 15 / 100) }} €</b>) <br> Hors cout de livraison</h4>
        @endif
        <p class="text-end" >Le total de la commande inclut la TVA et la livraison.</p>
    </div>





    <div class="text-center">
        <form action="{{ route('orders.cart_validation') }}" method="post"> @csrf
            <input type="hidden" name="payment_id" value="PAYMENT_TEST">

            {{-- Renvoit vers la plateforme de payement <form action="{{ route('orders.send_payment') }}" method="post"> @csrf --}}
            <input type="hidden" name="cart" value="{{ $cart->id }}">
            <input type="hidden" name="user_address_delivery" value="{{ $user_address->id }}">
            <input type="hidden" name="user_address_invoice" value="{{ $user_address_fac->id }}">
            <input type="hidden" name="deliver" value="{{ $deliver->id }}">
            <button type="submit" class="btn btn-lg btn-success hvr-grow-shadow"><i class="fa-regular fa-credit-card fa-2x"></i><br>Payer ma commande</button>
        </form>
    </div>

@endsection
