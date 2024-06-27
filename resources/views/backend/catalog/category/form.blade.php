@extends('backend.layouts.layout')
@section('title', $category->exists ? __('Modifier une catégorie') : __('Créer une catégorie'))

@section('main-content')
    <form action="{{ route($category->exists ? 'backend.catalog.categories.update' : 'backend.catalog.categories.store', $category) }}" method="post"  class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method($category->exists ? 'put' : 'post')

        <div class="d-flex gap-2 justify-content-end mb-3 me-5">
            <div class="form-check form-switch d-flex align-items-center me-3">
                <input class="form-check-input"
                       @if($category->is_menu) checked @endif
                       type="checkbox" role="switch" id="is_menu" name="is_menu">
                <label class="form-check-label" for="is_menu">Menu</label>
            </div>
            <div class="form-check form-switch d-flex align-items-center" >
                <input class="form-check-input"
                       @if(!$category->exists) checked @endif
                       @if($category->active) checked @endif
                       type="checkbox" role="switch" id="active" name="active">
                <label class="form-check-label" for="active">Activer</label>
            </div>
            <button type='button' class="btn btn-danger hvr-float-shadow"
                    onclick="location.href='{{ route('backend.catalog.categories.index') }}'">
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
            <div class="col-md-8 col-12">
                <div class="card border-left-primary shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informations</h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label class="form-control-label" for="category_id">Categorie</label>
                            <select class="form-select tomselect @error('categorie') is-invalid @enderror" aria-label="category_id" id="category_id" name="category_id">
                                <option value="0" selected>Aucune catégorie</option>
                                @foreach($categories_list as $category_list)
                                    @if(($category_list->category_id == 0) && ($category->id != $category_list->id))
                                        <option @if($category_list->id == old('category_id')) selected @endif @if($category_list->id == $category->category_id) selected @endif value="{{ $category_list->id }}">
                                            {{ $category_list->name }}
                                        </option>
                                        @foreach($category_list->childrenCategories as $childrenCategories)
                                            @if($childrenCategories->id != $category->id)
                                                <option @if($childrenCategories->id == old('category_id')) selected @endif @if($childrenCategories->id == $category->category_id) selected @endif value="{{ $childrenCategories->id }}">
                                                    {{ $category_list->name }} -> {{ $childrenCategories->name }}
                                                </option>
                                                @foreach($childrenCategories->childrenCategories as $childrenChildrenCategories)
                                                    @if(($childrenCategories->id != $childrenChildrenCategories->id) && ($category->id != $childrenChildrenCategories->id))
                                                        <option @if($childrenChildrenCategories->id == old('category_id')) selected @endif @if($childrenChildrenCategories->id == $category->category_id) selected @endif value="{{ $childrenChildrenCategories->id }}">
                                                            {{ $category_list->name }} -> {{ $childrenCategories->name }} -> {{ $childrenChildrenCategories->name }}
                                                        </option>
                                                        @foreach($childrenChildrenCategories->childrenCategories as $childrenChildrenChildrenCategories)
                                                            @if(($childrenChildrenCategories->id != $childrenChildrenChildrenCategories->id) && ($category->id != $childrenChildrenChildrenCategories->id))
                                                                <option @if($childrenChildrenChildrenCategories->id == old('category_id')) selected @endif @if($childrenChildrenChildrenCategories->id == $category->category_id) selected @endif value="{{ $childrenChildrenChildrenCategories->id }}">
                                                                    {{ $category_list->name }} -> {{ $childrenCategories->name }} -> {{ $childrenChildrenCategories->name }} -> {{ $childrenChildrenChildrenCategories->name }}
                                                                </option>
                                                                @foreach($childrenChildrenChildrenCategories->childrenCategories as $childrenChildrenChildrenChildrenCategories)
                                                                    @if(($childrenChildrenChildrenCategories->id != $childrenChildrenChildrenChildrenCategories->id) && ($category->id != $childrenChildrenChildrenChildrenCategories->id))
                                                                        <option @if($childrenChildrenChildrenChildrenCategories->id == old('category_id')) selected @endif @if($childrenChildrenChildrenChildrenCategories->id == $category->category_id) selected @endif value="{{ $childrenChildrenChildrenChildrenCategories->id }}">
                                                                            {{ $category_list->name }} -> {{ $childrenCategories->name }} -> {{ $childrenChildrenCategories->name }} -> {{ $childrenChildrenChildrenCategories->name }} -> {{ $childrenChildrenChildrenChildrenCategories->name }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>


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

                        <div class="form-group">
                            <label class="form-control-label" for="description">Description</label>
                            <textarea name="description" id="description" class="@error('description') is-invalid @enderror form-control">{{ old('description', $category->description) }}</textarea>
                            @error('title')
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

            <div class="col-md-4 col-12">
                <div class="card border-left-warning shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Image</h6>
                    </div>

                    <div class="card-body">
                        @if ($category->exists)
                            @if($category->image != null)
                                <div class="text-center">
                                    <img class="w-100" src="/storage/upload/catalog/category/{{ $category->image }}"  alt="{{ $category->name }}">
                                </div>
                            @endif
                        @endif
                        <div class="form-group mt-3">
                            <input type="file" name="image" id="image"
                                   class="@error('image') is-invalid @enderror form-control"
                                   value="{{ old('image') }}"></input>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection
