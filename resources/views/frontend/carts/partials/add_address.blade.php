<div class="row">
    <div class="col-md-1 col-12"></div>
    <div class="col-md-10 col-12">
        <form action="{{ route('cart.chose_delivery') }}" method="post">
            @csrf
            <input type="hidden" name="cart" value="{{ $cart->id }}">
            <input type="hidden" name="add_address" value="1">

            <div class="form-group">
                <label class="form-control-label" for="name">Nom <span
                        class="small text-danger">*</span> : </label>
                <input id="name" type="text" name="name"
                       class="@error('name') is-invalid @enderror form-control" required
                       value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-control-label" for="address">Adresse <span
                                class="small text-danger">*</span> : </label>
                        <input id="address" type="text" name="address"
                               class="@error('address') is-invalid @enderror form-control" required
                               value="{{ old('address') }}">
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-control-label" for="address2">Complément d'adresse : </label>
                        <input id="address2" type="text" name="address2"
                               class="@error('address2') is-invalid @enderror form-control"
                               value="{{ old('address2') }}">
                        @error('address2')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label class="form-control-label" for="country">Pays <span
                                class="small text-danger">*</span> : </label>
                        <input id="country" type="text" name="country" disabled
                               class="@error('country') is-invalid @enderror form-control" required
                               value="La Réunion">
                        @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <label class="form-control-label" for="cities">Code postal - Ville <span
                                class="small text-danger">*</span> : </label>
                        <select class="form-select" aria-label="Default select example" name="cities" id="cities">
                            @foreach($cities  as $city)
                                <option @if(@$cart->postal_code == $city->postal_code) selected @endif value="{{ $city->postal_code }}">{{ $city->city .' - '. $city->postal_code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label class="form-control-label" for="phone">Téléphone <span
                                class="small text-danger">*</span> : </label>
                        <input id="phone" type="text" name="phone"
                               class="@error('phone') is-invalid @enderror form-control" required
                               value="{{ old('phone') }}" placeholder="0692">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-control-label" for="other_phone">Autre Téléphone : </label>
                        <input id="other_phone" type="text" name="other_phone"
                               class="@error('other_phone') is-invalid @enderror form-control"
                               value="{{ old('other_phone') }}">
                        @error('other_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class=" text-center content mt-3">
                <button type="submit" class="btn btn-primary btn-lg hvr-grow-shadow">
                    <i class="fa-solid fa-circle-arrow-right"></i> Continuer</button>
            </div>

        </form>
    </div>
    <div class="col-md-1 col-12"></div>
</div>


