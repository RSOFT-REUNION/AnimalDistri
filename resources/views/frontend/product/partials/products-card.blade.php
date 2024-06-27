<div class="card content mt-3">
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

    <a class="mt-2" href="{{ route('product.show', $product->slug) }}">
        <img src="{{ $product->getFirstImagesURL(300, 300, 'fill-max') }}" class="d-block w-100 rounded-5"
             alt="{{ $product->name }}">
    </a>
    <div class="card-body">
        <h4 class="card-title"><b>{{ $product->name }}</b></h4>
        <p class="card-title">{{ $product->short_description }}</p>
        @auth()
        @if(array_key_exists($product->id,$discountProducts))
            <div class="d-flex justify-content-center align-items-center">
                <h4 class="text-decoration-line-through text-danger">{{ formatPriceToFloat($product->price_ttc) }}
                    €</h4>
                @if($discountProducts[$product->id]['fixed_priceTTC'])
                    <h2 class="m-3">{{ formatPriceToFloat($discountProducts[$product->id]['fixed_priceTTC']) }} €</h2>
                @else
                    <h2 class="m-3">{{ formatPriceToFloat($product->price_ttc - ($product->price_ttc * $discountProducts[$product->id]['discountPercentage']) / 100) }}
                        €</h2>
                @endif
            </div>
        @else
            <h2 class="m-3">{{ formatPriceToFloat($product->price_ttc) }} €</h2>
        @endif
        <hr>
        <div class="text-center align-items-center">
            @if($product->stock > 0)
                <form>  @csrf
                    <div class="input-group mb-2 w-75 mx-auto" style="cursor: pointer;">
                        <span class="input-group-text minus">-</span>
                        <input type="number" name="quantity" id="quantity" class="form-control w-25" min="1"
                               max="{{ $product->stock / 1000 }}" value="1">
                        <span class="input-group-text plus">+</span>
                    </div>
                    <span type="button" class="btn btn-primary btn-lg hvr-grow hvr-icon-buzz-out" id="add_cart"
                          hx-post="{{ route('cart.add_product', $product) }}"
                          hx-target="#cart_modal"
                          hx-swap="outerHTML"
                          hx-trigger="click"
                          hx-on="htmx:afterOnLoad: showAlert()"><i class="fa-solid fa-cart-plus hvr-icon"></i> Ajouter
                        </span>
                </form>
            @else
                <button type="button" class="btn btn-danger mt-4 btn-lg btn-lg" disabled>En rupture de stock</button>
            @endif
        </div>
        @endauth
    </div>
</div>
