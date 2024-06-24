@if(count($products) > 0)
    <div class="row row-flex" id="list_product">
        @foreach($products as $product)
            <div class="col-md-3 col-12 hvr-grow mb-4">
                @include('frontend.product.partials.products-card')
            </div>
        @endforeach
    </div>
@else
    <h3>Aucun produit ne correspond a votre recherche</h3>
@endif
