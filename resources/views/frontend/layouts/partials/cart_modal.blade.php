<!-- Offcanvas Modal -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="cart_modal" aria-labelledby="cart_modal">
    <div class="offcanvas-header bg-primary text-white">
        <h5 id="offcanvasRightLabel">Mon panier <i class="fa-duotone fa-cart-shopping"></i>
            <span class="ms-1 badge rounded-pill bg-danger">{{ \App\Http\Controllers\Frontend\ShoppingCart\CartController::count_product() }}</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @if(count($cart->product) > 0)

            <div class="d-none d-lg-block">
                <div class="row d-flex justify-content-between align-items-center text-center">
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-4">
                        Désignation
                    </div>
                    <div class="col-md-2">
                        Quantité
                    </div>
                    <div class="col-md-3">
                        Total
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
                            <img src="{{ getImageUrl(removeStorageFromURL($product->fav_image), 80, 80, 'fill-max') }}" class="img-fluid" alt="{{ $product->name }}">
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('product.show', getProductInfos($product->product_id)->slug) }}" class="text-black text-decoration-none">
                            <p class="lead fw-normal mb-2">{{ getProductInfos($product->product_id)->name  }}</p>
                        </a>
                    </div>
                    <div class="col-md-2 text-center">
                        <label class="d-lg-none"><b>Quantité :</b></label>
                        @if($product->stock_unit == 'kg')
                            <b>{{ $product->quantity }}<p class="text-center">grammes</p></b>
                        @else
                            <b>{{ $product->quantity }}</b>
                        @endif
                    </div>
                    <div class="col-md-3">
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
                    <div class="col-md-1 text-center">
                        <button type="button" class="btn text-danger p-0" data-bs-toggle="modal" data-bs-target="#deleteproduct{{ $product->id }}"><i class="fas fa-trash fa-lg"></i></button>
                    </div>
                </div>
                <hr>
            @endforeach
            <h3 class="text-center mt-3">Total TTC : {{ formatPriceToFloat($cart->countProductsPrice(@$delivery_chose->price_ttc, 0)) }} €</h3>
            <p class="text-center mb-3">Le total de la commande inclut la TVA.</p>
            <a href="{{ route('cart.index') }}" class="btn btn-success btn-lg hvr-grow-shadow" id="commander"><i class="fa-solid fa-cart-shopping-fast"></i> Commander</a>

        @else
            <h4 class="mt-5">Vous n'avez aucun produits dans votre panier</h4>
        @endif
    </div>
    <div class="offcanvas-footer text-center mb-3 mt-3">
        <button class="btn btn-warning btn-lg hvr-grow-shadow" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-circle-left"></i> Continuer mes achats </button>
    </div>

</div>

@foreach($cart->product as $product)
<!-- Modal -->
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
@endforeach
