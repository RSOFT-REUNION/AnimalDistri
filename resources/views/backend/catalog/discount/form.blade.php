@extends('backend.layouts.layout')
@section('title', $discount->exists ? __('Modifier une promotion') : __('Créer une promotion'))

@section('main-content')

    <form id="createForm" class="justify-content-center" action="{{ route($discount->exists ? 'backend.catalog.discounts.update' : 'backend.catalog.discounts.store', $discount) }}"
          method="post" enctype="multipart/form-data">
        @csrf
        @method($discount->exists ? 'put' : 'post')

        <div class="d-flex gap-2 justify-content-end mb-3 me-5">
            <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input"
                       @if(!$discount->exists) checked @endif
                       @if($discount->active) checked @endif
                       type="checkbox" role="switch" id="active" name="active">
                <label class="form-check-label" for="active">Activer</label>
            </div>
            <button type='button' class="btn btn-danger hvr-float-shadow"
                    onclick="location.href='{{ route('backend.catalog.discounts.index') }}'">
                <i class="fa-solid fa-rotate-left"></i>&nbsp;Annuler
            </button>
            <button type="submit" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-pen-to-square"></i>
                @if ($discount->exists)
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
                        <h6 class="m-0 font-weight-bold text-primary">Informations</h6>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            {{-- NOM --}}
                            <div class="form-group col-8">
                                <label class="form-control-label" for="name">Nom de la promotion : <span
                                        class="small text-danger">*</span></label>
                                <input type="text" id="name" name="name"
                                       class="@error('name') is-invalid @enderror form-control required"
                                       value="{{ old('name', $discount->name ) }}">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- POURCENTAGE DE REMISE --}}
                            <div class="form-group col-4">
                                <label for="percentage" class="form-label">Pourcentage de remise : <span
                                        class="small text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="@error('percentage') is-invalid @enderror form-control"
                                           min="1" max="100" id="percentage" name="percentage"
                                           value="{{ old('percentage', $discount->percentage) }}">
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('percentage')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            {{--DATES --}}
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-control-label" for="start_date">Début : <span
                                            class="small text-danger">*</span></label>
                                    <input type="date" id="start_date" name="start_date"
                                           class="@error('start_date') is-invalid @enderror form-control"
                                           value="{{ old('start_date', $discount->start_date) }}">
                                    @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label class="form-control-label" for="end_date">Fin : <span
                                            class="small text-danger">*</span></label>
                                    <input type="date" id="end_date" name="end_date"
                                           class="@error('end_date') is-invalid @enderror form-control"
                                           value="{{ old('end_date', $discount->end_date) }}">
                                    @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- DESCRIPTION COURTE --}}
                            <div class="form-group">
                                <label class="form-control-label" for="short_description">Description courte <span
                                        class="small text-body-secondary">(facultatif)</span></label>
                                <textarea id="short_description" name="short_description" maxlength="255" rows="3"
                                          class="@error('short_description') is-invalid @enderror form-control">{{ old('short_description', $discount->short_description) }}</textarea>
                                <div id="price_ttc" class="form-text">Maximum 255 caractères.</div>
                                @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @include('backend.catalog.discount.partial.product_list')


@endsection
