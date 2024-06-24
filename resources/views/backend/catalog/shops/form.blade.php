@extends('backend.layouts.layout')
@section('title', $shops->exists ? __('Modifier un magasin') : __('Créer un magasin'))

@section('main-content')
    <form action="{{ route($shops->exists ? 'backend.catalog.shops.update' : 'backend.catalog.shops.store', $shops) }}" method="post"  class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method($shops->exists ? 'put' : 'post')

        <div class="d-flex gap-2 justify-content-end mb-3 me-5">
            <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input"
                       @if(!$shops->exists) checked @endif
                        @if($shops->active) checked @endif
                        type="checkbox" role="switch" id="active" name="active">
                 <label class="form-check-label" for="active">Activer</label>
             </div>
            <button type='button' class="btn btn-danger hvr-float-shadow"
                    onclick="location.href='{{ route('backend.catalog.shops.index') }}'">
                <i class="fa-solid fa-rotate-left"></i>&nbsp;Annuler
            </button>
            <button type="submit" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-pen-to-square"></i>
                @if ($shops->exists)
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
                                <label class="form-control-label" for="name">Nom <span
                                        class="small text-danger">*</span></label>
                                <input id="name" type="text" name="name"
                                       class="@error('name') is-invalid @enderror form-control" required
                                       value="{{ old('name', $shops->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="description">Description</label>
                                <textarea name="description" id="description" class="@error('description') is-invalid @enderror form-control">{{ old('description', $shops->description) }}</textarea>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card border-left-success shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">Adresse</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-control-label" for="address">Adresse</label>
                                <input id="address" type="text" name="address"
                                       class="@error('address') is-invalid @enderror form-control"
                                       value="{{ old('address', $shops->address) }}">
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="postal_code">Code Postal</label>
                                        <input id="postal_code" type="text" name="postal_code"
                                               class="@error('postal_code') is-invalid @enderror form-control"
                                               value="{{ $shops->postal_code }}">
                                        @error('postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="city">Ville</label>
                                        <input id="city" type="text" name="city"
                                               class="@error('city') is-invalid @enderror form-control"
                                               value="{{ $shops->city }}">
                                        @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-4 col-12">
                    <div class="card border-left-warning shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-warning">Images</h6>
                        </div>
                        <div class="card-body">
                            @if (!'/storage/upload/content/carousel/'.$shops->image)
                                <img class="w-100" src="/storage/upload/catalog/shops/{{ $shops->image }}"  alt="{{ $shops->name }}">
                            @endif
                            <div class="form-group mt-3">
                                <label class="form-control-label" for="image">
                                    @if (!'/storage/upload/catalog/shops/'.$shops->image)
                                        Changer l'image :
                                    @else
                                        Image :
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

                    <div class="card border-left-secondary shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-secondary">Autres</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-control-label" for="schedules">Horaires </label>
                                <textarea name="schedules" id="schedules" class="@error('schedules') is-invalid @enderror form-control">{{ old('schedules', $shops->schedules) }}</textarea>
                                @error('schedules')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{--
                            <div class="form-group">
                                <label class="form-control-label" for="visibility">Visibilité <span class="small text-danger">*</span></label>
                                <select name="visibility" id="visibility" class="@error('visibility') is-invalid @enderror form-control" required>
                                    <option value="privé" {{ old('visibility', $shops->visibility) == 'privé' ? 'selected' : '' }}>Privé</option>
                                    <option value="public" {{ old('visibility', $shops->visibility) == 'public' ? 'selected' : '' }}>Public</option>
                                </select>
                                @error('visibility')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>--}}
                        </div>
                    </div>
                </div>

            </div>

</form>

@endsection
