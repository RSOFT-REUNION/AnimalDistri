@extends('backend.layouts.layout')
@section('title', $product->exists ? __('Modifier un produit') : __('Créer un produit'))

@section('main-content')

    <form
        action="{{ route($product->exists ? 'backend.catalog.products.update' : 'backend.catalog.products.store', $product) }}"
        method="post" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method($product->exists ? 'put' : 'post')

        <!-- NAVIGATION TABS -->
        <div class="d-flex gap-2 justify-content-between mb-3 me-5">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-general" data-bs-toggle="pill" data-bs-target="#General"
                            type="button" role="tab">Général
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-images" data-bs-toggle="pill" data-bs-target="#Images"
                            type="button" role="tab">Images
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-specific" data-bs-toggle="pill" data-bs-target="#Specific"
                            type="button" role="tab">Infos spécifiques
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-content" data-bs-toggle="pill" data-bs-target="#Content"
                            type="button" role="tab">Contenu
                    </button>
                </li>
            </ul>
            <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input"
                       @if(!$product->exists) checked @endif
                       @if($product->active) checked @endif
                       type="checkbox" role="switch" id="active" name="active">
                <label class="form-check-label" for="active">Activer</label>
                <button type='button' class="btn btn-outline-secondary hvr-shadow ml-3"
                        onclick="location.href='{{ route('backend.catalog.products.index') }}'">
                    <i class="fa-solid fa-arrow-left"></i> Retourner à la liste
                </button>
                <button type="button" class="btn btn-danger hvr-float-shadow ml-2"
                        title="Annuler"
                        data-bs-toggle="modal"
                        data-bs-target="#cancelModal">
                    <i class="fa-solid fa-rotate-left"></i> Annuler
                </button>
                <button type="submit" class="btn btn-success hvr-float-shadow ml-2"><i
                        class="fa-solid fa-check"></i> Enregistrer
                </button>
            </div>
        </div>

        <!-- Modal de confirmation d'annulation des modifications -->
        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div></div>
                        <h5 class="modal-title" id="exampleModalLabel">Êtes-vous sûr ?</h5>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body text-center text-danger text-wrap">
                         Toutes vos modifications non-enregistrés sur le produit {{ $product->name }}
                        seront perdues.
                    </div>
                    <div class="modal-footer">
                        <button type='button' class="btn btn-danger hvr-float-shadow"
                                onclick="location.href='{{ route('backend.catalog.products.edit', $product) }}'">
                            <i class="fa-solid fa-xmark"></i> Supprimer les modifications en cours
                        </button>
                        <button type="button" class="btn btn-primary hvr-float-shadow" data-bs-dismiss="modal">
                             Continuer à modifier <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="tab-content" id="pills-tabContent">
            <!-- TAB INFORMATIONS GENERALES DU PRODUITS  -->
            <div class="tab-pane fade show active" id="General" role="tabpanel">
                <div class="row">
                    <div class="col-6">
                        @include('backend.catalog.product.partial.edit_general')
                    </div>
                    <div class="col-6">
                        <!--  DONNEES DE VENTE - prix et stock -->
                        @include('backend.catalog.product.partial.edit_priceandstock')
                    </div>
                </div>
            </div>

            <!-- TAB IMAGES  -->
            <div class="tab-pane fade" id="Images" role="tabpanel">
                <div class="card border-left-warning shadow mb-4 mx-auto">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Images</h6>
                    </div>
                    <div class="card-body text-center">
                        <iframe width="100%" height="600px" style="overflow:hidden;"
                                src=" {{ route('backend.catalog.products.list_image', $product) }}">
                        </iframe>
                    </div>
                </div>
            </div>

            <!--  TAB INFOS SPECIFIQUES  -->
            <div class="tab-pane fade" id="Specific" role="tabpanel">
                @include('backend.catalog.product.partial.edit_specific')
            </div>



            {{-- SCRIPTS JQUERY désactive l'envoi du formulaire quand on presse ENTRER dans n'importe quel input --}}
            {{-- !!! ne pas placer aprés contenu sinon BUG et contenu summernote ne s'affiche plus !!! --}}
            <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
            <script type="text/javascript">
                $(document).ready(function (e) {
                    $(document).on("keydown", ":input:not(textarea)", function(event) {
                        if (event.key == "Enter") {
                            event.preventDefault();
                        }
                    });
                });
            </script>


            <!--  TAB CONTENU  -->
            <div class="tab-pane fade" id="Content" role="tabpanel">
                <div class="card border-left-primary shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Contenu</h6>
                    </div>
                    <textarea id="content" name="content"
                              class="summernote">{{ old('content', $product->content) }}</textarea>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal d'ajout d'image -->
    <div class="modal fade" id="addImagesModal" tabindex="-1" role="dialog" aria-labelledby="addImageModalTitle"
         aria-hidden="true">

        <form action="{{ route('backend.catalog.products.add_image', $product)}}" method="put" class="mt-6 space-y-6"
              enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ajouter des images</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="file" accept=".jpeg, .png, .jpg, .gif, .svg" name="images[]" id="images"
                                   multiple
                                   class="@error('images') is-invalid @enderror form-control"
                                   value="{{ old('images') }}">
                            @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>

                        <button type="button" class="btn btn-success" id="add_image"
                                hx-post="{{ route('backend.catalog.products.add_image', $product) }}"
                                hx-target="#images_list"
                                hx-swap="outerHTML"
                        >Ajouter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>



@endsection
