@extends('backend.layouts.layout')
@section('title', $group->exists ? 'Modification du groupe '. $group->name : __('Créer un groupe'))

@section('main-content')
    <form
        action="{{ route($group->exists ? 'backend.clients.groups.update' : 'backend.clients.groups.store', $group) }}"
        method="post" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method($group->exists ? 'put' : 'post')

        <div class="d-flex gap-2 justify-content-end mb-3 me-5">
            <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input"
                       @if(!$group->exists) checked @endif
                       @if($group->active) checked @endif
                       type="checkbox" role="switch" id="active" name="active">
                <label class="form-check-label" for="active">Activer</label>
            </div>
            <button type='button' class="btn btn-danger hvr-float-shadow"
                    onclick="location.href='{{ route('backend.clients.groups.index') }}'">
                <i class="fa-solid fa-rotate-left"></i>&nbsp;Annuler
            </button>
            <button type="submit" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-pen-to-square"></i>
                @if ($group->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
        </div>


                <div class="card border-left-primary shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informations</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Nom <span
                                            class="small text-danger">*</span> : </label>
                                    <input id="name" type="text" name="name"
                                           class="@error('name') is-invalid @enderror form-control" required
                                           value="{{ old('name', $group->name) }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">ERP ID : </label>
                                    <input id="erp_id" type="text" name="erp_id"
                                           class="@error('erp_id') is-invalid @enderror form-control" required
                                           value="{{ old('erp_id', $group->erp_id) }}">
                                    @error('erp_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="description">Description :</label>
                            <input type="text" name="description" id="description"
                                   class="@error('description') is-invalid @enderror form-control"
                                   value="{{ old('description', $group->description) }}"></input>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            {{--
                <div class="card border-left-warning shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">S'affiche uniquement selon le template du site internet</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-control-label" for="description">Description :</label>
                            <input type="text" name="description" id="description"
                                   class="@error('description') is-invalid @enderror form-control"
                                   value="{{ old('description', $slide->description) }}"></input>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="url">Lien du bouton :</label>
                                    <input type="text" name="url" id="url"
                                           class="@error('url') is-invalid @enderror form-control"
                                           value="{{ old('url', $slide->url) }}"></input>
                                    @error('url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="title_url">Texte du bouton :</label>
                                    <input type="text" name="title_url" id="title_url"
                                           class="@error('title_url') is-invalid @enderror form-control"
                                           value="{{ old('title_url', $slide->title_url) }}"></input>
                                    @error('title_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4 col-12">
                <div class="card border-left-secondary shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Images</h6>
                    </div>
                    <div class="card-body">
                        @if ($slide->exists)
                            <div class="text-center">
                                <img class="w-100" src="/storage/upload/content/carousel/{{ $slide->image }}"  alt="{{ $slide->name }}">
                            </div>
                        @endif
                        <div class="form-group mt-3">
                            <label class="form-control-label" for="image">
                                @if ($slide->exists)
                                    Changer l'image :
                                @else
                                    Image <span class="small text-danger">*</span> :
                                @endif
                            </label>
                            <input type="file" name="image" id="image"
                                   class="@error('image') is-invalid @enderror form-control"
                                   value="{{ old('image') }}"></input>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                --}}
    </form>
@endsection
