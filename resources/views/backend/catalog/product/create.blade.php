<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="modal-create" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body mb-3 m-2 ml-4 mr-4">
                <form class="justify-content-center" action="{{ route('backend.catalog.products.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="form-group row">
                        <div class="col">
                            {{-- NOM DU PRODUIT --}}
                            <div class="form-group">
                                <label class="form-control-label" for="name">Nom du produit <span class="small text-danger">(obligatoire)</span></label>
                                <input type="text" id="name" name="name"
                                       class="@error('name') is-invalid @enderror form-control" required
                                       value="{{ old('name') }}">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- PRIX DE BASE --}}
                            <div class="form-group">
                                <label class="form-control-label" for="price_ht">Prix de base <span class="small text-danger">(obligatoire)</span></label>
                                <div class="input-group pb-2">
                                    <button class="btn btn-primary disabled" type="button" id="button-addon1">Prix HT</button>
                                    <input type="number" id="price_ht" name="price_ht"
                                           step="0.01" min="0"
                                           class="@error('price_ht')is-invalid @enderror form-control text-right" required
                                           value="{{ old('price_ht') }}">
                                    <button class="btn btn-outline-primary disabled" type="button" id="button-addon1"><i class="fa-regular fa-euro-sign"></i></button>
                                </div>
                                {{-- TVA --}}
                                <input type="radio" class="btn-check" name="tva" id="tva_0" checked value="0">
                                <label class="btn btn-outline-primary btn-sm hvr-grow" for="tva_0">Sans TVA</label>

                                <input type="radio" class="btn-check" name="tva" id="tva_210" value="210">
                                <label class="btn btn-outline-primary btn-sm hvr-grow" for="tva_210"> 2,10 % </label>

                                <input type="radio" class="btn-check hvr-shrink" name="tva" id="tva_850" value="850">
                                <label class="btn btn-outline-primary btn-sm hvr-grow" for="tva_850"> 8,50 % </label>
                                <div id="tva" class="form-text">
                                    <i class="fa-light fa-circle-info">
                                    </i> Le prix TTC sera calculé automatiquement à partir du prix HT et de la TVA.
                                </div>
                            </div>
                        </div>

                        {{-- IMAGE --}}
                        <div class="col-4">
                            <div class="input-group mb-3">
                                <label class="input-group-text col justify-content-center hvr-border-fade"
                                style="cursor:pointer; border-radius: 3px;" for="image">
                                    <p class="text-dark" id="p">
                                        <br>
                                        <i class="fa-light fa-image"></i>
                                        <br>Importer une image<br>
                                        <br>
                                        <span class="form-text">
                                            <i class="fa-light fa-circle-info"></i>
                                            <br>Formats de fichier acceptés: <br>
                                            JPG, PNG ou SVG. <br>
                                            La taille de l'image doit être <br>
                                            inférieure à 2 Mo.
                                        </span>
                                    </p>
                                    <img id="preview-image-before-upload" src=""
                                         style="max-height: 250px; max-width:200px;">
                                </label>
                                <input type="file" id="image" name="image"
                                       class="form-control @error('image') is-invalid @enderror" hidden
                                       accept=".jpeg, .png, .jpg, .gif, .svg"
                                       value="{{ old('image') }}">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- CATEGORIE --}}
                    <div class="form-group row">
                        <div class="col">
                            <label class="form-control-label" for="product_categories[]">Catégories </label>
                            <select class="form-select tomselectmultiplecategories @error('product_categories') is-invalid @enderror" multiple
                                    id="product_categories[]" name="product_categories[]">
                                <option value="">Aucune catégorie</option>
                                @foreach($categories_list as $category_list)
                                    @if($category_list->category_id == null)
                                        <option {{ in_array($category_list->id, old('product_categories') ?? []) ? 'selected' : '' }}
                                                value="{{ $category_list->id }}">{{ $category_list->name }}</option>
                                        @foreach($category_list->childrenCategories as $childrenCategories)
                                            <option {{ in_array($childrenCategories->id, old('product_categories') ?? []) ? 'selected' : '' }}
                                                    value="{{ $childrenCategories->id }}">{{ $category_list->name }} -> {{ $childrenCategories->name }}</option>
                                            @foreach($childrenCategories->childrenCategories as $childrenChildrenCategories)
                                                @if($childrenCategories->id != $childrenChildrenCategories->id)
                                                    <option {{ in_array($childrenChildrenCategories->id, old('product_categories') ?? []) ? 'selected' : '' }}
                                                            value="{{ $childrenChildrenCategories->id }}">{{ $category_list->name }} -> {{ $childrenCategories->name }} -> {{ $childrenChildrenCategories->name }}</option>
                                                    @foreach($childrenChildrenCategories->childrenCategories as $fourthLevelCategory)
                                                        @if($childrenChildrenCategories->id != $fourthLevelCategory->id)
                                                            <option {{ in_array($fourthLevelCategory->id, old('product_categories') ?? []) ? 'selected' : '' }}
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
                                    id="brand_id" name="brand_id">
                                <option value=""> Aucune marque </option>
                                @foreach($brands_list as $brand)
                                     <option @if( old('brand_id') == $brand->id) selected @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
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
                               class="@error('short_description') is-invalid @enderror form-control">{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between pt-3">
                        <p class="small text-danger"></p>
                        <div class="d-flex">
                            <div class="form-check form-switch d-flex align-items-center mx-3">
                                <input type="checkbox" id="active" name="active"
                                       role="switch" checked
                                       class="form-check-input">
                                <label class="form-check-label" for="active">Activer</label>
                            </div>
                            <button type="submit" class="btn btn-primary text-nowrap">Créer un produit</button>
                        </div>

                    </div>

                </form>
            </div>
        </div>

    </div>
</div>


{{-- scripts --}}
<script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
<script type="text/javascript">

    // PREVIEW IMAGE
    $(document).ready(function (e) {
        $('#images').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image-before-upload').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
            $('#p').hide();
        });

    });
</script>






