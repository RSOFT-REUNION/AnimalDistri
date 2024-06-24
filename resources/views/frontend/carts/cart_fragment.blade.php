<div id="divpanier">
    @if(count($cart->product) > 0)
        <div class="row">
            <div class="col-md-9 col-12">
                <div class="d-none d-lg-block">
                    <div class="row d-flex justify-content-between align-items-center text-center">
                        <div class="col-md-2">

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
                            Total TTC
                        </div>
                        <div class="col-md-1">

                        </div>
                    </div>
                    <hr>
                </div>
                @foreach($cart->product as $product)
                    <div class="row d-flex justify-content-between align-items-center mt-3 mb-3 text-center">
                        <div class="col-md-2">
                            <a href="{{ route('product.show', getProductInfos($product->product_id)->slug) }}">
                                <img src="{{ getImageUrl(removeStorageFromURL($product->fav_image), 200, 200, 'fill-max') }}" class="img-fluid" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('product.show', getProductInfos($product->product_id)->slug) }}" class="text-black text-decoration-none">
                                <p class="lead fw-normal mb-2">{{ getProductInfos($product->product_id)->name  }}</p>
                            </a>
                        </div>
                        <div class="col-md-2 mb-3">
                            @if($product->discount_id)
                                <h6 class="text-decoration-line-through text-danger">{{ formatPriceToFloat($product->price_ttc) }} €</h6>
                                @if(@$discountProducts[$product->product_id]['fixed_priceTTC'])
                                    <h5 class="m-3">{{ formatPriceToFloat(@$discountProducts[$product->product_id]['fixed_priceTTC']) }} € @if($product->stock_unit == 'kg')<br>le Kg @endif</h5>
                                @else
                                    <h5 class="m-3">{{ formatPriceToFloat($product->price_ttc - ($product->price_ttc * @$discountProducts[$product->product_id]['discountPercentage']) / 100) }} € @if($product->stock_unit == 'kg')<br>le Kg @endif</h5>
                                @endif
                            @else
                                <h5 class="mb-0">{{ formatPriceToFloat($product->price_ttc) }} € @if($product->stock_unit == 'kg')<br>le Kg @endif</h5>
                            @endif
                        </div>
                        <div class="col-md-1 text-center mb-3">
                            <label class="d-lg-none"><b>Quantité :</b></label>
                            <form method="post">  @csrf
                                @if($product->stock_unit == 'kg')
                                    <div class="d-flex justify-content-center">
                                    <select class="form-control text-end me-3 text-center" style="width: 100px;" name="quantity" id="quantity"
                                            hx-post="{{ route('cart.update_quantity_product', $product->id) }}"
                                            hx-swap="outerHTML"
                                            hx-target="#divpanier">
                                        @for ($i = 1; $i <= getProductInfos($product->product_id)->stock / 100; $i++)
                                            <option value="{{ $i }}00" @if($product->quantity == $i.'00') selected @endif>{{ $i }}00</option>
                                        @endfor
                                    </select>
                                    </div>
                                    <p class="text-center">grammes</p>
                                @else
                                    <div class="d-flex justify-content-center">
                                        <select class="form-control text-end me-3" style="width: 50px;" name="quantity" id="quantity"
                                                hx-post="{{ route('cart.update_quantity_product', $product->id) }}"
                                                hx-swap="outerHTML"
                                                hx-target="#divpanier">
                                            @for ($i = 1; $i <= getProductInfos($product->product_id)->stock / 1000 ; $i++)
                                                <option value="{{ $i }}" @if($product->quantity == $i) selected @endif>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                @endif
                            </form>
                        </div>
                        <div class="col-md-2 mb-3">
                            @if($product->discount_id)
                                @if($product->stock_unit == 'kg')
                                    <h6 class="text-decoration-line-through text-danger">{{ formatPriceToFloat($product->price_ttc  * $product->quantity / 1000) }} €</h6>
                                    @if(@$discountProducts[$product->product_id]['fixed_priceTTC'])
                                        <h5 class="m-3">{{ formatPriceToFloat((@$discountProducts[$product->product_id]['fixed_priceTTC'] * $product->quantity) / 1000) }} €</h5>
                                    @else
                                        <h5 class="m-3">{{ formatPriceToFloat((($product->price_ttc - ($product->price_ttc * @$discountProducts[$product->product_id]['discountPercentage']) / 100)  * $product->quantity ) / 1000)   }} €</h5>
                                    @endif
                                @else
                                    <h6 class="text-decoration-line-through text-danger">{{ formatPriceToFloat($product->price_ttc  * $product->quantity) }} €</h6>
                                    @if(@$discountProducts[$product->product_id]['fixed_priceTTC'])
                                        <h5 class="m-3">{{ formatPriceToFloat($discountProducts[$product->product_id]['fixed_priceTTC'] * $product->quantity) }} €</h5>
                                    @else
                                        <h5 class="m-3">{{ formatPriceToFloat(($product->price_ttc - ($product->price_ttc * @$discountProducts[$product->product_id]['discountPercentage']) / 100)  * $product->quantity )   }} €</h5>
                                    @endif
                                @endif
                            @else
                                <h5 class="mb-0">{{ formatPriceToFloat($cart->priceProductQuantity($product->id)) }} €</h5>
                            @endif
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn text-danger p-0" data-bs-toggle="modal" data-bs-target="#deleteproduct{{ $product->id }}"><i class="fas fa-trash fa-lg"></i></button>
                            <div class="modal fade" id="deleteproduct{{ $product->id }}" tabindex="-1" aria-labelledby="deleteproduct{{ $product->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Retiré le produit du panier ?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Etez-vous sur de vouloir retiré {{ getProductInfos($product->product_id)->name  }} du panier ?</h4>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <a href="{{ route('cart.delete_product', $product->id) }}" class="btn btn-danger">Retiré</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
            <div class="col-md-3 col-12">
                @include('frontend.carts.partials.cart_summary')
                <div class="text-center">
                    <form action="{{ route('cart.chose_address') }}" method="post"> @csrf
                        <input id="ddd" name="ddd" type="hidden">
                        <button type="submit" class="btn btn-success btn-lg hvr-grow-shadow" id="commander"><i class="fa-solid fa-cart-shopping-fast"></i> Commander</button>
                    </form>
                </div>

            </div>
        </div>

    @else
        <h1 class="text-center m-5">Votre panier ne contient aucun produit</h1>
        <div class="text-center mb-5">
            <a class="btn btn-lg btn-primary hvr-grow-shadow" href="{{ route('index') }}"><i class="fa-solid fa-circle-left"></i> Retour a la page d'accueil</a>
        </div>
    @endif
</div>
