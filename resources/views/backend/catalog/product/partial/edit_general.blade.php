<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informations générales du produit</h6>
    </div>
    <div class="card-body">


        {{-- NOM DU PRODUIT --}}
        <div class="form-group row">
            <div class="col">
                <label class="form-control-label" for="name">Nom du produit <span class="small text-danger">*</span></label>
                <input type="text" id="name" name="name"
                       class="@error('name') is-invalid @enderror form-control" required
                       value="{{ old('name', $product->name) }}">
                <div id="price_ttc" class="form-text text-truncate w-75">   Lien du produit : <a target="_blank" href="{{ route('product.show', $product->slug) }}">{{ route('product.show', $product->slug) }}</a></div>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-3">
                <label class="form-control-label" for="erp_id">Code SAP</label>
                <input type="text" id="erp_id" name="erp_id"
                       class="@error('erp_id') is-invalid @enderror form-control"
                       value="{{ old('erp_id', $product->erp_id) }}">
                @error('erp_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- CODE BARRE --}}
        <div class="form-group">
            <label class="form-control-label" for="barcode">Code Barre </label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-barcode"></i></span>
                <input type="text" id="barcode" name="barcode"
                       class="@error('barcode') is-invalid @enderror form-control"
                       value="{{ old('barcode', $product->barcode) }}">
            </div>
            @error('barcode')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group row">
            {{-- CATEGORIE --}}
            <div class="col">
                <label class="form-control-label" for="product_categories[]">Catégories </label>
                <select class="form-select tomselectmultiplecategories @error('product_categories') is-invalid @enderror" multiple
                        aria-label="product_categories"
                        id="product_categories[]" name="product_categories[]">
                    <option value="" selected>Aucune catégorie</option>
                    @foreach($categories_list as $category_list)
                        @if($category_list->category_id == null)
                            <option {{ in_array($category_list->id, $product_categories ?? []) ? 'selected' : '' }}
                                {{ in_array($category_list->id, old('product_categories') ?? []) ? 'selected' : '' }}
                                    value="{{ $category_list->id }}"> {{ $category_list->name }}</option>
                            @foreach($category_list->childrenCategories as $childrenCategories)
                                <option {{ in_array($childrenCategories->id, $product_categories ?? []) ? 'selected' : '' }}
                                        {{ in_array($childrenCategories->id, old('product_categories') ?? []) ? 'selected' : '' }}
                                        value="{{ $childrenCategories->id }}">{{ $category_list->name }} -> {{ $childrenCategories->name }}</option>
                                @foreach($childrenCategories->childrenCategories as $childrenChildrenCategories)
                                    @if($childrenCategories->id != $childrenChildrenCategories->id)
                                        <option {{ in_array($childrenChildrenCategories->id, $product_categories ?? []) ? 'selected' : '' }}
                                                {{ in_array($childrenChildrenCategories->id, old('product_categories') ?? []) ? 'selected' : '' }}
                                                value="{{ $childrenChildrenCategories->id }}">{{ $category_list->name }} -> {{ $childrenCategories->name }} -> {{ $childrenChildrenCategories->name }}</option>
                                        @foreach($childrenChildrenCategories->childrenCategories as $fourthLevelCategory)
                                            @if($childrenChildrenCategories->id != $fourthLevelCategory->id)
                                                <option {{ in_array($fourthLevelCategory->id, $product_categories ?? []) ? 'selected' : '' }}
                                                        {{ in_array($fourthLevelCategory->id, old('product_categories') ?? []) ? 'selected' : '' }}
                                                        value="{{ $fourthLevelCategory->id }}">{{ $category_list->name }} -> {{ $childrenCategories->name }} -> {{ $childrenChildrenCategories->name }} -> {{ $fourthLevelCategory->name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endforeach
                        @endif
                    @endforeach
                </select>
                @error('product_categories')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>



            {{-- MARQUE --}}
            <div class="col">
                <label class="form-control-label" for="brand_id">Marque </label>
                <select class="form-select tomselect @error('brand_id') is-invalid @enderror"
                        id="brand_id"
                        name="brand_id">
                    <option value=""> Aucune marque </option>
                    @foreach($brands_list as $brand)
                         <option @if( old('brand_id', $product->brand_id) == $brand->id) selected @endif value="{{ $brand->id }}"> {{ $brand->name }}</option>
                     @endforeach
                </select>
                @error('brand_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- DESCRIPTION COURTE --}}
        <div class="form-group">
            <label class="form-control-label" for="short_description">Description courte <span class="small text-body-secondary">(facultatif)</span></label>
            <textarea id="short_description" name="short_description" rows="2"
                      class="@error('short_description') is-invalid @enderror form-control">{{ old('short_description', $product->short_description) }}</textarea>
            @error('short_description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


    </div>
</div>

