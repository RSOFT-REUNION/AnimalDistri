<div class="row row-cols-auto justify-content-end">
    <div class="col">

    </div>
    <div class="col me-3 mb-3">
        <!--- Filtre Promotion --->
        <div class="form-check form-switch d-flex justify-content-center align-items-center" style="margin-top: 4px;">
            @if(request()->query('discount') == 'on')
                <input class="form-check-input fs-4 me-2" type="checkbox" role="switch" id="discount" name="discount" checked
                       hx-get="/nos-produits/{{ $category_curent->slug }}{{ arrayToString(request()->query()) }}&discount=none"
                       hx-target="#list_product" hx-replace-url="false"
                       hx-trigger="click" hx-indicator=".htmx-indicator, .htmx-style">
            @else
                <input class="form-check-input fs-4 me-2" type="checkbox" role="switch" id="discount" name="discount"
                       hx-get="/nos-produits/{{ $category_curent->slug }}{{ arrayToString(request()->query()) }}"
                       hx-target="#list_product" hx-replace-url="false"
                       hx-trigger="click" hx-indicator=".htmx-indicator, .htmx-style">
            @endif
            <label class="form-check-label" for="discount" style="margin-top: 6px;">Promotions</label>
        </div>
    </div>
    @auth()
    <div class="col mb-3">
        <!--- Filtre Stock --->
        <div class="form-check form-switch d-flex justify-content-center align-items-center" style="margin-top: 4px;">
            @if(request()->query('stock') == 'on')
                <input class="form-check-input fs-4 me-2" type="checkbox" role="switch" id="stock" name="stock" checked
                       hx-get="/nos-produits/{{ $category_curent->slug }}{{ arrayToString(request()->query()) }}&stock=none"
                       hx-target="#list_product" hx-replace-url="false"
                       hx-trigger="click" hx-indicator=".htmx-indicator, .htmx-style">
            @else
                <input class="form-check-input fs-4 me-2" type="checkbox" role="switch" id="stock" name="stock"
                       hx-get="/nos-produits/{{ $category_curent->slug }}{{ arrayToString(request()->query()) }}"
                       hx-target="#list_product" hx-replace-url="false"
                       hx-trigger="click" hx-indicator=".htmx-indicator, .htmx-style">
            @endif
            <label class="form-check-label" for="stock" style="margin-top: 6px;">En stock</label>
        </div>
    </div>
    @endauth
    <div class="col">
        <!--- Filtre  Chercher --->
        <div class="input-group">
            <input class="form-control" name="search" value="{{ request()->query('search') }}"
                   hx-get="/nos-produits/{{ $category_curent->slug }}{{ arrayToString(request()->query()) }}"
                   hx-target="#list_product" hx-replace-url="false"
                   hx-trigger="keyup changed delay:500ms, search" hx-indicator=".htmx-indicator, .htmx-style"/>
            <span class="input-group-text" id="search"><i class="fa-solid fa-magnifying-glass"></i></span>
        </div>
    </div>
    <div class="col">
        <!--- Trie --->
        <select class="form-select" name="sort" id="sort"
                hx-get="/nos-produits/{{ $category_curent->slug }}{{ arrayToString(request()->query()) }}"
                hx-trigger="input changed" hx-replace-url="false"
                hx-target="#list_product" hx-indicator=".htmx-indicator, .htmx-style">
            <option value="none" disabled selected>Trier par</option>
            <option @if(@request()->query('sort') == 'name' ) selected @endif value="name">Désignation</option>
            <option @if(@request()->query('sort') == 'price_asc' ) selected @endif value="price_asc">Prix
                croissant
            </option>
            <option @if(@request()->query('sort') == 'price_desc' ) selected @endif value="price_desc">Prix
                décroissant
            </option>
        </select>
    </div>
</div>
