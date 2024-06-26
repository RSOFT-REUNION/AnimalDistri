<div class="position-relative" id="list_product" hx-get="{{ route('product.list', $category_curent->slug) }}"
     hx-trigger="loadProducts from:body">

    <div class="htmx-indicator position-absolute top-50 start-50 translate-middle" role="status" aria-hidden="true">
        <span class="spinner-border text-primary" style="width: 5rem; height: 5rem;"></span>
    </div>

    <div class="htmx-style">

        <div class="row d-flex mb-4 align-items-center">
            <div class="col-md-2 align-items-center">
                <h5 class="d-none d-lg-block">{{ $products->total() }} Produits</h5>
            </div>
            <div class="col-md-10 align-items-center">
                @include('frontend.product.partials.list_product-filtre')
            </div>
        </div>

        @include('frontend.product.partials.products')

        <div id="pagination-links" class="p-3" hx-boost="true" hx-target="#list_product"
             hx-indicator=".htmx-indicator, .htmx-style">
            {{ $products->links() }}
        </div>

    </div>

</div>
