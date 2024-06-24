@extends('backend.layouts.layout')
@section('title', $deliver->exists ? 'Modification de l\'option de livraison'. $deliver->name : __('Créer une option de livraison'))

@section('main-content')
    <form
        action="{{ route($deliver->exists ? 'backend.orders.delivery.update' : 'backend.orders.delivery.store', $deliver) }}"
        method="post" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method($deliver->exists ? 'put' : 'post')

        <div class="d-flex gap-2 justify-content-end mb-3 me-5">
            <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input"
                       @if(!$deliver->exists) checked @endif
                       @if($deliver->active) checked @endif
                       type="checkbox" role="switch" id="active" name="active">
                <label class="form-check-label" for="active">Activer</label>
            </div>
            <button type='button' class="btn btn-danger hvr-float-shadow"
                    onclick="location.href='{{ route('backend.orders.delivery.index') }}'">
                <i class="fa-solid fa-rotate-left"></i>&nbsp;Annuler
            </button>
            <button type="submit" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-pen-to-square"></i>
                @if ($deliver->exists)
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
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Nom <span
                                            class="small text-danger">*</span> : </label>
                                    <input id="name" type="text" name="name"
                                           class="@error('name') is-invalid @enderror form-control" required
                                           value="{{ old('name', $deliver->name) }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="price_ttc">Prix TTC <span
                                            class="small text-danger">*</span> : </label>
                                    <input id="price_ttc" type="text" name="price_ttc"
                                           class="@error('price_ttc') is-invalid @enderror form-control" required
                                           value="{{ old('price_ttc', $deliver->price_ttc) }}">
                                    @error('price_ttc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="description">Description :</label>
                            <input type="text" name="description" id="description"
                                   class="@error('description') is-invalid @enderror form-control"
                                   value="{{ old('description', $deliver->description) }}"></input>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4 col-12">
                <div class="card border-left-secondary shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-secondary">Image</h6>
                    </div>
                    <div class="card-body">
                        @if ($deliver->exists)
                            <div class="text-center">
                                <img class="w-100" src="/storage/upload/order/delivery/{{ $deliver->image }}"  alt="{{ $deliver->name }}">
                            </div>
                        @endif
                        <div class="form-group mt-3">
                            <label class="form-control-label" for="image">
                                @if ($deliver->exists)
                                    Changer l'image :
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
            </div>

        </div>


    </form>
@endsection
