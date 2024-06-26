@extends('backend.layouts.layout')
@section('title', __('Modifier une marque'))

@section('main-content')
    <form action="{{ route('backend.catalog.brands.update', $brand) }}" method="post" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="d-flex gap-2 justify-content-end mb-3 me-5">
            <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input" @if (!$brand->exists) checked @endif
                    @if ($brand->active) checked @endif type="checkbox" role="switch" id="active"
                    name="active">
                <label class="form-check-label" for="active">Activer</label>
                <button type='button' class="btn btn-outline-secondary hvr-shadow ml-3"
                    onclick="location.href='{{ route('backend.catalog.brands.index') }}'">
                    <i class="fa-solid fa-arrow-left"></i> Retourner à la liste
                </button>
                <button type="submit" class="btn btn-success hvr-float-shadow ml-2"><i class="fa-solid fa-check"></i>
                    Enregistrer
                </button>
            </div>
        </div>

        <div class="row m-2">
            <div class="col">
                <div class="card border-left-primary shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Modification d'une marque</h6>
                    </div>

                    <div class="card-body row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-control-label" for="name">Nom <span
                                        class="small text-danger">*</span></label>
                                <input id="name" type="text" name="name"
                                    class="@error('name') is-invalid @enderror form-control" required
                                    value="{{ old('name', $brand->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="short_description">Description courte</label>
                                <textarea name="short_description" id="short_description" row="3"
                                    class="@error('short_description') is-invalid @enderror form-control">{{ old('short_description', $brand->short_description) }}</textarea>
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
                                    @if ($brand->image)
                                        <div>
                                            <img id="preview-image-before-upload" src="{{ getImageUrl('/upload/catalog/brands/'.$brand->image, 250, 250) }}"
                                                 style="max-height: 250px; max-width:200px;" alt="Logo actuel">
                                            <div class="form-text">Cliquez sur l'image pour modifier</div>
                                        </div>
                                    @else
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
                                    @endif
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
                </div>
            </div>
        </div>
    </form>

    {{-- scripts --}}
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript">
        // PREVIEW IMAGE
        $(document).ready(function(e) {
            $('#image').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image-before-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
                $('#p').hide();
            });
        });
    </script>
@endsection
