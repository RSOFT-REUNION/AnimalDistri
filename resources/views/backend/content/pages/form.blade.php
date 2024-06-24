@extends('backend.layouts.layout')
@section('title', $pages->exists ? 'Modification de la page '. $pages->name : __('Créer une page'))

@section('main-content')
    <form action="{{ route($pages->exists ? 'backend.content.pages.update' : 'backend.content.pages.store', $pages) }}" method="post"  class="mt-6 space-y-6">
        @csrf
        @method($pages->exists ? 'put' : 'post')

        <div class="d-flex gap-2 justify-content-end mb-3 me-5">
            <div class="form-check form-switch d-flex align-items-center me-3">
                <input class="form-check-input"
                       @if(!$pages->exists) checked @endif
                       @if($pages->is_menu) checked @endif
                       type="checkbox" role="switch" id="is_menu" name="is_menu">
                <label class="form-check-label" for="is_menu">Menu</label>
            </div>
                <div class="form-check form-switch d-flex align-items-center @if($pages->id == 1) d-none @endif" >
                    <input class="form-check-input"
                           @if(!$pages->exists) checked @endif
                           @if($pages->active) checked @endif
                           type="checkbox" role="switch" id="active" name="active">
                    <label class="form-check-label" for="active">Activer</label>
                </div>
            <button type='button' class="btn btn-danger hvr-float-shadow"
                    onclick="location.href='{{ route('backend.content.pages.index') }}'">
                <i class="fa-solid fa-rotate-left"></i>&nbsp;Annuler
            </button>
            <button type="submit" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-pen-to-square"></i>
                @if ($pages->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
        </div>

        <div class="form-group d-none">
            <label class="form-control-label" for="slug">Slug</label>
            <input id="slug" type="text" name="slug" disabled
                   class="@error('slug') is-invalid @enderror form-control"
                   value="{{ $pages->slug }}">
        </div>

    <div class="row m-2">
        <div class="col-12">
            <div class="card border-left-primary shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations</h6>
                </div>

                <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Nom <span class="small text-danger">*</span></label>
                                    <input id="name" type="text" name="name"
                                    class="@error('name') is-invalid @enderror form-control" required
                                           value="{{ old('name', $pages->name) }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="m-0w">
                                    <label for="category_id" class="form-label">Categorie</label>
                                    <select class="form-select tomselect @error('categorie') is-invalid @enderror" aria-label="category_id"
                                            id="category_id" name="category_id">
                                        <option value=""> Aucune categorie </option>
                                        @foreach($categories_list as $category_list)
                                            <option @if($category_list->id == $pages->category_id) selected @endif value="{{ $category_list->id }}"> {{ $category_list->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('categorie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="m-0w">
                            <div class="form-group">
                                <label class="form-control-label" for="description">Description</label>
                                <textarea name="description" id="description" class="@error('description') is-invalid @enderror form-control">{{ old('description', $pages->description) }}</textarea>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                </div>
            </div>

            <div class="card border-left-success shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contenu</h6>
                </div>
                <textarea id="content" name="content" class="summernote">{{ old('content', $pages->content) }}</textarea>
            </div>

        </div>
    </div>

    </form>

@endsection
