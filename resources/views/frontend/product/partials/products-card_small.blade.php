<div class="card content position-relative">
    @if(array_key_exists($product->id, $discountProducts))
        <h4 class="position-relative">
            @if($discountProducts[$product->id]['fixed_priceTTC'])
                <span class="badge text-bg-danger position-absolute top-0 start-50 translate-middle">
                    Promo
                </span>
            @else
                <span class="badge text-bg-danger position-absolute top-0 start-50 translate-middle">
                    Promo -{{ $discountProducts[$product->id]['discountPercentage'] }} %
                </span>
            @endif
        </h4>
    @endif

    <a href="{{ route('product.show', $product->slug) }}">
        <img src="{{ $product->getFirstImagesURL(300, 300, 'fill-max') }}" class="d-block w-100 rounded-5" alt="{{ $product->name }}">
    </a>
    <div class="card-body">
        <h6 class="card-title text-center"><b>{{ $product->name }}</b></h6>
    </div>
    <div  class="card-footer text-center">

        @if(array_key_exists($product->id,$discountProducts))
            @if($product->stock_unit == 'kg')
                <h4 class="text-decoration-line-through text-danger">{{ formatPriceToFloat($product->price_ttc / 10) }} €</h4>
                @if($discountProducts[$product->id]['fixed_priceTTC'])
                    <h2 style="margin-top: -15px;">{{ formatPriceToFloat($discountProducts[$product->id]['fixed_priceTTC'] / 10) }} €</h2>
                @else
                    <h2 style="margin-top: -15px;">{{ formatPriceToFloat(($product->price_ttc - ($product->price_ttc * $discountProducts[$product->id]['discountPercentage']) / 100) / 10)  }} €</h2>
                @endif
                <p style="margin-top: -12px;">les 100 grammes</p>
            @else
                <h4 class="text-decoration-line-through text-danger">{{ formatPriceToFloat($product->price_ttc) }} €</h4>
                @if($discountProducts[$product->id]['fixed_priceTTC'])
                    <h2 style="margin-top: -15px;">{{ formatPriceToFloat($discountProducts[$product->id]['fixed_priceTTC']) }} €</h2>
                @else
                    <h2 style="margin-top: -15px;">{{ formatPriceToFloat($product->price_ttc - ($product->price_ttc * $discountProducts[$product->id]['discountPercentage']) / 100) }} €</h2>
                @endif
            @endif
        @else
            @if($product->stock_unit == 'kg')
                <h2 class="m-3">{{ formatPriceToFloat($product->price_ttc / 10) }} €</h2>
                <p style="margin-top: -18px;">les 100 grammes</p>
            @else
                <h2 class="m-3">{{ formatPriceToFloat($product->price_ttc) }} €</h2>
            @endif
        @endif

        @if($product->stock > 0)
            <form>  @csrf
                    @if($product->stock_unit == 'kg')
                        <div class="input-group w-75 mx-auto mb-2" style="cursor: pointer;">
                            <span class="input-group-text minus" >-</span>
                            <input type="number" name="quantity" id="quantity" class="form-control w-25" min="1" max="{{ $product->stock }}" value="100" step="100">
                            <span class="input-group-text plus">+</span>
                        </div>
                        <span type="button" class="btn btn-primary hvr-grow hvr-icon-buzz-out mb-3" id="add_cart"
                              hx-post="{{ route('cart.add_product', $product) }}"
                              hx-target="#cart_modal"
                              hx-swap="outerHTML"
                              hx-trigger="click"
                              hx-on="htmx:afterOnLoad: showAlert()"><i class="fa-solid fa-cart-plus hvr-icon"></i> Ajouter
                            </span>
                    @else
                        <div class="input-group mb-2 w-75 mx-auto" style="cursor: pointer;">
                            <span class="input-group-text minus" >-</span>
                            <input type="number" name="quantity" id="quantity" class="form-control w-25" min="1" max="{{ $product->stock / 1000 }}" value="1">
                            <span class="input-group-text plus">+</span>
                        </div>
                        <span type="button" class="btn btn-primary hvr-grow hvr-icon-buzz-out" id="add_cart"
                              hx-post="{{ route('cart.add_product', $product) }}"
                              hx-target="#cart_modal"
                              hx-swap="outerHTML"
                              hx-trigger="click"
                              hx-on="htmx:afterOnLoad: showAlert()"><i class="fa-solid fa-cart-plus hvr-icon"></i> Ajouter
                            </span>
                    @endif
            </form>
        @else
            <button type="button" class="btn btn-danger btn-sm mb-3" disabled>En rupture de stock</button>
        @endif
    </div>
</div>
