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
                <form class="justify-content-center" action="{{ route('backend.catalog.brands.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="form-group row">
                        <div class="col">
                            {{-- NOM DU PRODUIT --}}
                            <div class="form-group">
                                <label class="form-control-label" for="name">Nom <span class="small text-danger">(obligatoire)</span></label>
                                <input type="text" id="name" name="name"
                                       class="@error('name') is-invalid @enderror form-control" required
                                       value="{{ old('name') }}">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- DESCRIPTION COURTE --}}
                            <div class="form-group">
                                <label class="form-control-label" for="short_description">Description courte <span class="small text-body-secondary">(facultatif)</span></label>
                                <textarea id="short_description" name="short_description" rows="4"
                                        class="@error('short_description') is-invalid @enderror form-control">{{ old('short_description') }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                        <br>Ajouter un logo<br>
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


                    <div class="d-flex justify-content-between pt-3">
                        <p class="small text-danger"></p>
                        <div class="d-flex">
                            <div class="form-check form-switch d-flex align-items-center mx-3">
                                <input type="checkbox" id="active" name="active"
                                       role="switch" checked
                                       class="form-check-input">
                                <label class="form-check-label" for="active">Activer</label>
                            </div>
                            <button type="submit" class="btn btn-primary text-nowrap">Créer</button>
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
        $('#image').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image-before-upload').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
            $('#p').hide();
        });

    });
</script>






