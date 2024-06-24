@extends('backend.layouts.layout')
@section('title', __('Information générales') )

@section('main-content')
    <form action="{{ route('backend.settings.informations.update') }}" method="post"
          class="mt-6 space-y-6">
        @csrf

        <div class="d-flex gap-2 justify-content-end mb-3 me-5">
            <button type="submit" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-pen-to-square"></i> Modifier</button>
        </div>

        <div class="row m-2">
            <div class="col">
                <div class="card border-left-primary shadow mb-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informations</h6>
                    </div>


                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-control-label" for="address">Adresse :<span
                                    class="small text-danger">*</span></label>
                            <textarea id="address" name="address"
                                      class="@error('address') is-invalid @enderror form-control"
                                      aria-label="With textarea">{{ $infos->address }}</textarea>

                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-control-label" for="phone">Téléphone :<span
                                            class="small text-danger">*</span></label>
                                    <input id="phone" type="text" name="phone"
                                           class="@error('phone') is-invalid @enderror form-control" required
                                           value="{{ old('phone', $infos->phone) }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-control-label" for="address">Fax :</label>
                                    <input id="fax" type="text" name="fax"
                                           class="@error('fax') is-invalid @enderror form-control"
                                           value="{{ old('fax', $infos->fax) }}">
                                    @error('fax')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="address">E-mail :<span
                                    class="small text-danger">*</span></label>
                            <input id="email" type="text" name="email"
                                   class="@error('email') is-invalid @enderror form-control" required
                                   value="{{ old('email', $infos->email) }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
