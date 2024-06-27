<div class="card border-left-secondary shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-secondary">Complémentaires (Spécifiques selon le client)</h6>
    </div>
    <div class="card-body">


        <div class="form-group">
            <label class="form-control-label" for="composition">Composition</label>
            <textarea name="composition" id="composition" class="@error('composition') is-invalid @enderror form-control">{{ old('composition', $product->composition) }}</textarea>
            <div id="composition" class="form-text">Indiquez ici les matériaux, la provenance des ingrédients, les allergènes.</div>
            @error('composition')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-control-label" for="composition">Constituants analytiques</label>
            <textarea name="constituants" id="constituants" class="@error('constituants') is-invalid @enderror form-control">{{ old('constituants', $product->constituants) }}</textarea>
            @error('constituants')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label class="form-control-label" for="composition">Mode d'emploi </label>
            <textarea name="mode_emploi" id="mode_emploi" class="@error('mode_emploi') is-invalid @enderror form-control">{{ old('mode_emploi', $product->mode_emploi) }}</textarea>
            @error('mode_emploi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label class="form-control-label" for="additifs">Additifs </label>
            <textarea name="additifs" id="additifs" class="@error('additifs') is-invalid @enderror form-control">{{ old('additifs', $product->additifs) }}</textarea>
            @error('additifs')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label class="form-control-label" for="tags">Tags </label>
            <textarea type="text" id="tags" name="tags"
                      style="height: 100px;"
                      class="@error('tags') is-invalid @enderror form-control">{{ old('tags', $product->tags) }}</textarea>
            <div id="composition" class="form-text">Pour le référencement et les statistiques de vente.</div>
            @error('tags')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        {{--<div class="col">
            <label class="form-control-label" for="tags">Tags </label>
            <select class="form-select tomselect @error('tags') is-invalid @enderror"
                    id="tags"
                    name="tags">
                <option value=""></option>
                --}}{{-- @foreach($tags as $tag)
                     <option @if($product->tags == $tag->id) selected @endif value="{{ $tag->id }}"> {{ $brand->name }}</option>
                 @endforeach--}}{{--
            </select>
            @error('tags')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>--}}
    </div>
</div>
