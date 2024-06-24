@extends('backend.layouts.layout')
@section('title', 'Details de la commande : '.$order->ref_order)

@section('main-content')

    <div class="d-flex gap-2 justify-content-end mb-3 me-5">
        <form action="{{ route('backend.orders.updateStatus', $order) }}" method="post"> @csrf
            <div class="d-flex gap-2 justify-content-end ">
                <div class="form-group">
                    <select class="m-0 form-select @error('status') is-invalid @enderror" aria-label="status_id"
                            id="status_id" name="status_id">
                        @foreach($status_list as $status)
                            <option value="{{ $status->id }}" @if($status->id == $order->status_id) selected @endif> {{ $status->status }}</option>
                        @endforeach
                    </select>
                    @error('status_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button href="" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-floppy-disk"></i> Modifier le status</button>
            </div>
        </form>
    </div>

    <div class="row m-2">
        <div class="col">
            <div class="card  border-left-danger shadow mb-4">
                <div class="row text-center align-items-center">
                    <div class="col-3">
                        <div class="m-3 text-secondary">
                            <i class="fa-duotone fa-calendar fa-3x"></i><br><h4>{{ formatDateInFrench($order->created_at->format('Y-m-d')) .' '. $order->created_at->format('H:i') }}</h4>
                        </div>
                    </div>
                    <div class="col-2 text-success"><i class="fa-solid fa-money-check-dollar fa-3x"></i><br><h3>{{ formatPriceToFloat($order->total_ttc) }} €</h3></div>
                    <div class="col-2 text-dark"><i class="fa-duotone fa-clipboard-list-check fa-3x mb-2"></i><br><h4>{{ $order->getStatus() }}</h4></div>
                    <div class="col-2 text-warning"><i class="fa-duotone fa-list fa-3x "></i><br><h3>{{ count($order->product) }}</h3></div>
                    <div class="col-2 text-danger"><img class="w-25 mb-3 mt-3" src="{{ asset('frontend/images/discount.png') }}"><br>
                        <h5>
                            @if($order->user_loyality_used == 0)
                                Aucune remise
                            @elseif($order->user_loyality_used == 5)
                                - 5% (<b>- {{ formatPriceToFloat($order->countProductsPrice(0,0) * 5 / 100) }} €</b>)
                            @elseif($order->user_loyality_used == 10)
                                - 10% (<b>- {{ formatPriceToFloat($order->countProductsPrice(0,0) * 10 / 100) }} €</b>)
                            @elseif($order->user_loyality_used == 15)
                                - 15% (<b>- {{ formatPriceToFloat($order->countProductsPrice(0,0) * 15 / 100) }} €</b>)
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row m-2">
        <div class="col">
            <div class="card border-left-primary shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Livraison</h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        <p>Mode de livraison : <b>{{ $order->getDeliverName() }}</b></p>
                        <p>Frais de livraison : <b>@if($order->delivery_price == 0) Gratuit @else {{ $order->delivery_price }} €  @endif</b></p>
                        @if($order->delivery_id == 2)
                            <p>Date de livraison : <b>{{ formatDateInFrench($order->delivery_date) }}</b><br>
                            Heure de livraison :  <b>@if($order->delivery_date == 'matin') Entre 9h et 13h @else Entre 14h et 18h @endif </b></p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <div class="col">
            <div class="card border-left-dark shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Client ({{ $order->user_name }} - {{ $order->user_email }})</h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h4>Adresse facturation</h4>
                            <p>{{ $order->user_civilite .' '. $order->user_name }}<br>
                            {{ $order->user_delivery_address }}<br>
                            @if($order->user_delivery_address2)
                                {{ $order->user_delivery_address2 }}<br>
                            @endif
                            {{ $order->user_delivery_cities }} - {{ $order->getCity() }}<br>
                            {{ $order->user_delivery_phone }}</p>
                        </div>
                        @if($order->delivery_id == 2)
                            <div class="col border-left-dark">
                                <h4>Adresse de livraison</h4>
                                @empty(!$order->user_invoice_address)
                                    <p>{{ $order->user_invoice_civilite .' '. $order->user_invoice_first_name .' '. $order->user_invoice_last_name }}<br>
                                        {{ $order->user_invoice_address }}<br>
                                        @if($order->user_invoice_address2)
                                            {{ $order->user_invoice_address2 }}<br>
                                        @endif
                                        {{ $order->user_invoice_cities }} - {{ $order->getInvoiceCity() }}<br>
                                        {{ $order->user_invoice_phone }}</p>
                                @else
                                    <p>{{ $order->user_civilite .' '. $order->user_name }}<br>
                                        {{ $order->user_delivery_address }}<br>
                                        @if($order->user_delivery_address2)
                                            {{ $order->user_delivery_address2 }}<br>
                                        @endif
                                        {{ $order->user_delivery_cities }} - {{ $order->getCity() }}<br>
                                        {{ $order->user_delivery_phone }}</p>
                                @endif
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row m-2">
        <div class="col">
            <div class="card border-left-warning shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Liste des produits</h6>
                </div>

                <div class="card-body">
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
                    @foreach($order->product as $product)
                        <div class="row d-flex justify-content-between align-items-center mt-3 mb-3 text-center">
                            <div class="col-md-3">
                                <img src="{{ getImageUrl(removeStorageFromURL($product->fav_image), 200, 200, 'fill-max') }}" class="w-50" alt="{{ $product->name }}">
                            </div>
                            <div class="col-md-4">
                                <p class="lead fw-normal mb-2">{{ getProductInfos($product->product_id)->name  }}</p>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-1">
                                @if($product->stock_unit == 'kg')
                                    <b>{{ $product->quantity }} grammes</b>
                                @else
                                    <b>{{ $product->quantity }}</b>
                                @endif
                            </div>
                            <div class="col-md-2">
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
                                    <h5 class="mb-0">{{ formatPriceToFloat($order->priceProductQuantity($product->id)) }} €</h5>
                                @endif
                            </div>
                        </div>
                        <hr>
                    @endforeach

                    <div class="mb-5">
                        <h4 id="sous-total_produit" class="text-end mt-4">Total ({{ $order->countProduct() }} article(s)) :  {{ formatPriceToFloat($order->countProductsPrice(0,0)) }} €</h4>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
