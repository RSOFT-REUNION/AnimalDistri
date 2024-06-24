<div class="table-responsive mb-3">
    <table id="datatable" class="table datatable table-hover table-bordered w-100">
        <thead>
        <tr>
            <th scope="col" class="text-center" style="width: 5%;">#</th>
            <th scope="col" class="text-center"></th>
            <th scope="col" class="text-center">Nom</th>
            <th scope="col" class="text-center">Prix de base</th>
            <th scope="col" class="text-center">Prix remisé</th>
            <th scope="col" class="text-center no-sort" style="width: 10%;"><i class="fa-duotone fa-arrows-minimize"></i></th>
        </tr>
        </thead>

    @foreach ($discount->products as $product)

            <tr id="product{{ $product->id }}">
                <td class="text-center align-middle">{{ $product->id }}</td>
                <td class="text-center align-middle"><img src="{{ getProductInfos($product->product_id)->getFirstImagesURL(80, 80) }}"></td>
                <td class="text-center align-middle">{{ $product->product->name }}
                </td>
                <td class="text-center align-middle">
                    {{ formatPriceToFloat(getProductInfos($product->product_id)->price_ttc) }} € TTC @if(getProductInfos($product->product_id)->stock_unit == 'kg')<br>le Kg @endif
                </td>
                <td class="text-center align-middle">
                    <div class="d-flex">
                        <div class="flex-fill">
                            @if($product->fixed_priceTTC)
                                {{ formatPriceToFloat($product->fixed_priceTTC) }} € @if(getProductInfos($product->product_id)->stock_unit == 'kg')<br>le Kg @endif
                            @else
                                {{ formatPriceToFloat(getProductInfos($product->product_id)->price_ttc - (getProductInfos($product->product_id)->price_ttc * $discount->percentage) / 100) }} € TTC @if(getProductInfos($product->product_id)->stock_unit == 'kg')<br>le Kg @endif
                            @endif</div>
                    </div>
                </td>

                <td class="text-center align-middle">
                    <form action='{{ route('backend.catalog.discounts.destroy_product', [$discount ,$product]) }}' method="post"> @csrf
                        <button type="submit" class="btn btn-danger"><i class="fa-regular fa-trash"></i></button>
                        <button title="Forcer le prix" class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#forcepricettc{{ $product->id }}"><i class="fa-solid fa-euro-sign"></i></button>
                    </form>
                </td>
            </tr>

        <!-- Modal Force Price TTC -->
            <!-- Modal -->
            <div class="modal fade" id="forcepricettc{{ $product->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('backend.catalog.discounts.update_force_priceTTC', [$discount ,$product]) }}" method="post"> @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 " id="staticBackdropLabel">Forcer le prix de {{ getProductInfos($product->product_id)->name }}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Nouveux prix <span
                                            class="small text-danger">*</span></label>
                                    <input id="fixed_priceTTC" type="number" name="fixed_priceTTC" step="0.01" min="0" max="{{ getProductInfos($product->product_id)->price_ttc / 100 }}"
                                           class="@error('fixed_priceTTC') is-invalid @enderror form-control" required
                                           value="{{ old('fixed_priceTTC', $product->fixed_priceTTC / 100) }}">
                                    @error('fixed_priceTTC')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="fixed_priceTTC" class="form-text">0 indique que la réduction appliquée est celle de la promotion</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @endforeach
    </table>
</div>

<script>
    $('.datatable').DataTable( {
        order: [],
        "columnDefs": [ {
            "targets"  : 'no-sort',
            "orderable": false,
        }],
        language: {
            processing:     "Traitement en cours...",
            search:         "<i class=\"fa-solid fa-magnifying-glass\"></i>",
            lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
            info:           "_TOTAL_ &eacute;l&eacute;ments",
            infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix:    "",
            loadingRecords: "Chargement en cours...",
            zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable:     "Aucune donnée disponible dans le tableau",
            paginate: {
                first:      "<i class=\"fa-solid fa-backward-fast\"></i>",
                previous:   "<i class=\"fa-solid fa-backward-step\"></i>",
                next:       "<i class=\"fa-solid fa-forward-step\"></i>",
                last:       "<i class=\"fa-solid fa-forward-fast\"></i>"
            },
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        }
    } );

</script>


