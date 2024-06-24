
    <div class="card border-left-success shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">Données de vente</h6>
        </div>
        <div class="card-body">
            {{-- STOCK --}}
            <div class="form-group row">
                <div class="col-6">
                    <label class="form-control-label" for="stock">Quantité en stock <span class="small text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" id="stock" name="stock"
                               @if($product->stock_unit == 'kg') step="0.001" @endif  {{-- rajouter min="0" si stock négatif possible --}}
                               class="@error('stock') required is-invalid @enderror form-control" required
                               value="{{ old('stock', $product->stock / 1000) }}">
                        <select class="@error('stock_unit') is-invalid @enderror form-select" required
                                id="stock_unit"
                                name="stock_unit">
                            <option @if($product->stock_unit == 'unit') selected @endif value="unit">unité(s)</option>
                            <option @if($product->stock_unit == 'kg') selected @endif value="kg">kg (vente en vrac)</option>
                        </select>
                    </div>
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('stock_unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="weight_group" class="col-6">
                    <label class="form-control-label" for="weight">Poids à l'unité</label>
                    <div class="input-group">
                        <input type="number" id="weight" name="weight"
                               step="0.01" min="0" @if($product->stock_unit == 'kg') disabled @endif
                               class="@error('weight') is-invalid @enderror form-control"
                               value="{{ old('weight', $product->weight / 100) }}">
                        <select class="@error('weight_unit') is-invalid @enderror form-select"
                                @if($product->stock_unit == 'kg') disabled @endif
                                id="weight_unit"
                                name="weight_unit">
                            <option @if($product->weight_unit == 'kg') selected @endif value="kg">Kg (Kilogramme)</option>
                            <option @if($product->weight_unit == 'litre') selected @endif value="litre">L (Litre)</option>
                        </select>
                    </div>
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('weight_unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


            </div>
            {{-- PRIX HT / TTC / TVA --}}
            <div class="form-group row">
                    <div class="form-group col">
                        <label class="form-control-label" for="price_ht">Prix de base <span class="small text-danger">*</span></label>
                        <div class="input-group pb-2">
                            <button class="btn btn-primary disabled" type="button">Prix HT</button>
                            <input type="number" id="price_ht" name="price_ht"
                                   step="0.01" min="0"
                                   class="@error('price_ht')is-invalid @enderror form-control text-right" required
                                   value="{{ old('price_ht', $product->price_ht / 100) }}">
                            <button class="btn btn-outline-primary disabled" type="button"><i class="fa-regular fa-euro-sign"></i></button>
                        </div>
                        {{-- TVA --}}
                        <input type="radio" class="btn-check" name="tva" id="tva_0" @if(($product->tva == 0) or (old('tva') == 0)) checked @endif value="0">
                        <label class="btn btn-outline-primary btn-sm hvr-grow" for="tva_0">Sans TVA</label>

                        <input type="radio" class="btn-check" name="tva" id="tva_210" @if(($product->tva == 210) or (old('tva') == 210)) checked @endif value="210">
                        <label class="btn btn-outline-primary btn-sm hvr-grow" for="tva_210"> 2,10 % </label>

                        <input type="radio" class="btn-check hvr-shrink" name="tva" id="tva_850" @if(($product->tva == 850) or (old('tva') == 850)) checked @endif value="850">
                        <label class="btn btn-outline-primary btn-sm hvr-grow" for="tva_850"> 8,50 % </label>
                    </div>
                <div class="col">
                    <label class="form-control-label invisible" for="price_ttc">Prix TTC </label>
                    <div class="input-group">
                        <button class="btn btn-secondary disabled" type="button">Prix TTC</button>
                        <input type="number" id="price_ttc" name="price_ttc"
                               step="0.01" min="0"
                               class="@error('price_ttc') is-invalid @enderror form-control" disabled
                               value="{{ old('price_ttc', $product->price_ttc / 100) }}">
                        <button class="btn btn-outline-secondary disabled" type="button"><i class="fa-regular fa-euro-sign"></i></button>
                        @error('price_ttc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="recalculate_ttc" style="margin-top: .25rem; font-size: .875em; color: #6c757d;">Calcul automatique en fonction de la valeur HT et de la TVA.</div>

                </div>
            </div>
        </div>
    </div>



<script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
<script type="text/javascript">


    $(document).ready(function (e) {

        // Désactive le poids à l'unité si stock en kilogrammes

        // ----  à la modification de l'unité de stock
        $('#stock_unit').change(function(){
            if( $('#stock_unit').val() == 'kg') {
                $('#stock').attr('step', 0.001);
                $('#weight').attr('disabled', true);
                $('#weight_unit').attr('disabled', true);
            } else  {
                $('#stock').attr('step', 1);
                $('#weight').attr('disabled', false);
                $('#weight_unit').attr('disabled', false);
            }
        });


        // recalcule à la voléé le prix TTC quand on change les valeurs TVA et/ou prix HT
        function recalculateTTC () {
            var tva = Number($('input[name="tva"]:checked').val());
            var ht = Number($('#price_ht').val());
            var recalculated_ttc = ht * ( tva / 10000 ) + ht;
            $('#recalculate_ttc').html('Calcul automatique en fonction de la valeur HT et de la TVA. Nouveau TTC après sauvegarde : ');
            recalculated_ttc = String(recalculated_ttc.toFixed(2)) + ' €';
            $('#recalculate_ttc').append(recalculated_ttc);
        }
        $('input[name="tva"]').change(recalculateTTC);
        $('#price_ht').change(recalculateTTC);
    });
</script>
