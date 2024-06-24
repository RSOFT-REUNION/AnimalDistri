@extends('backend.layouts.layout')
@section('title', $category->exists ? 'Modification de la categorie '. $category->name : __('Créer une categorie'))

@section('main-content')
    <form
        action="{{ route($category->exists ? 'backend.content.categories.update' : 'backend.content.categories.store', $category) }}"
        method="post" class="mt-6 space-y-6">
        @csrf
        @method($category->exists ? 'put' : 'post')

        <div class="d-flex gap-2 justify-content-end mb-3 me-5">
            <button type='button' class="btn btn-danger hvr-float-shadow"
                    onclick="location.href='{{ route('backend.content.categories.index') }}'">
                <i class="fa-solid fa-rotate-left"></i>&nbsp;Annuler
            </button>
            <button type="submit" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-pen-to-square"></i>
                @if ($category->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
        </div>

        <div class="row m-2">
            <div class="col-md-6 col-12">
                <div class="card border-left-primary shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informations</h6>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-control-label" for="name">Nom <span
                                    class="small text-danger">*</span></label>
                            <input id="name" type="text" name="name"
                                   class="@error('name') is-invalid @enderror form-control" required
                                   value="{{ old('name', $category->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group d-none">
                            <label class="form-control-label" for="slug">Slug</label>
                            <input id="slug" type="text" name="slug" disabled
                                   class="@error('slug') is-invalid @enderror form-control"
                                   value="{{ $category->slug }}">
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6 col-12">
                <div class="card border-left-warning shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Categorie</h6>
                    </div>

                    <div class="card-body">
                        <select class="form-select tomselect @error('categorie') is-invalid @enderror"
                                aria-label="category_id"
                                id="category_id" name="category_id">
                            <option value=""> Aucune categorie</option>
                            @foreach($categories_list as $category_list)
                                @if($category_list->id != $category->id)
                                    <option @if($category_list->id == old('category_id')) selected
                                            @endif @if($category_list->id == $category->category_id) selected
                                            @endif value="{{ $category_list->id }}"> {{ $category_list->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('categorie')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

        </div>

    </form>
@endsection
