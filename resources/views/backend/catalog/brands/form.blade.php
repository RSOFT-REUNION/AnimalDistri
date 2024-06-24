@extends('backend.layouts.layout')
@section('title', $brands->exists ? __('Modifier une marque') : __('Créer une marque'))

@section('main-content')
    <form action="{{ route($brands->exists ? 'backend.catalog.brands.update' : 'backend.catalog.brands.store', $brands) }}" method="post"  class="mt-6 space-y-6">
        @csrf
        @method($brands->exists ? 'put' : 'post')

        <div class="d-flex gap-2 justify-content-end mb-3 me-5">
            <!--<div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input"
                       @if(!$brands->exists) checked @endif
                       @if($brands->active) checked @endif
                       type="checkbox" role="switch" id="active" name="active">
                <label class="form-check-label" for="active">Activer</label>
            </div>-->
            <button type='button' class="btn btn-danger hvr-float-shadow"
                    onclick="location.href='{{ route('backend.catalog.brands.index') }}'">
                <i class="fa-solid fa-rotate-left"></i>&nbsp;Annuler
            </button>
            <button type="submit" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-pen-to-square"></i>
                @if ($brands->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
        </div>

    <div class="row m-2">
        <div class="col">
            <div class="card border-left-primary shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> @if($brands->exists)
                            Modification
                        @else
                            Création
                        @endif
                        d'une marque</h6>
                </div>

                <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Nom de la marque <span class="small text-danger">*</span></label>
                                    <input id="name" type="text" name="name"
                                           class="@error('name') is-invalid @enderror form-control" required
                                           value="{{ old('name', $brands->name) }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="description">Description </label>
                                    <input name="description" id="description" class="@error('description') is-invalid @enderror form-control">{{ old('description', $brands->description) }}</input>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    <input id="slug" type="text" name="slug" class="d-none" value="{{ $brands->slug }}">

                </div>
            </div>
        </div>
    </div>

    </form>

@endsection
