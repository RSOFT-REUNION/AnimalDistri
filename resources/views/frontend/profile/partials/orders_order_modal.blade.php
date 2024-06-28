<div class="modal fade" id="order{{ $order->id }}" tabindex="-1" aria-labelledby="order{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">{{ $order->ref_order }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <h3 class="text-center">{{ $order->getStatus() }} - {{ $order->payment_id }}</h3>

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
                    <h3 id="sous-total_produit" class="text-end mt-4">Total ({{ $order->countProduct() }} article(s)) :  {{ formatPriceToFloat($order->countProductsPrice(0,0)) }} €</h3>
                </div>


                <div class="row row-flex justify-content-center align-items-center">
                    <div class="col-md-4 col-12">
                        <div class="card bg-gray content">
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="w-25 mb-3" src="{{ asset('frontend/images/location.png') }}">
                                </div>
                                <p><b>{{ $order->user_name }}</b><br>
                                    {{ $order->user_delivery_address }}
                                    @if($order->user_delivery_address2)
                                        - {{ $order->user_delivery_address2 }}
                                    @endif
                                    <br>
                                    {{ $order->user_delivery_cities }} - {{ $order->getCity() }}
                                    <br>
                                    Téléphone : {{ $order->user_delivery_phone }}
                                    @if($order->user_delivery_other_phone)
                                        / {{ $order->user_delivery_other_phone }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="card bg-gray content">
                            <div class="card-body">
                                <div class="row align-items-center text-center">
                                    <div class="text-center">
                                       <img class="w-25 mb-3 mt-3" src="{{ getImageUrl(('/upload/order/delivery/'.$order->getDeliverImage()), 100, 100) }}" alt="{{ $order->getDeliverName()}}">
                                    </div>
                                    <h4 class="flex-fill">{{ $order->getDeliverName() }}</h4>
                                    <h2 class=""><b>@if($order->delivery_price == 0) <b>Gratuit</b> @else {{ $order->delivery_price }} €@endif</b></h2>
                                    <p class="text-center">{{ $order->getDeliverDescription() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="p-3">
                    <h2 id="sous-total" class="text-end mt-4">Sous-total ({{ $order->countProduct() }} article(s)) :  {{ formatPriceToFloat($order->total_ttc) }} €</h2>
                    <p class="text-end" >Le total de la commande inclut la TVA et la livraison.</p>
                </div>

            </div>
        </div>
    </div>
</div>
