@extends('backend.layouts.layout')
@section('title', __('Gestion des produits') )

@section('main-content')

    <div class="row m-2">
        <div class="col">
            <div class="d-flex gap-2 justify-content-end mb-3 me-5">
                @can('catalog.products.import')
                    <button type='button' class="btn btn-info hvr-float-shadow text-white" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fa-solid fa-file-import"></i>&nbsp;Importation
                    </button>
                    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Importer un fichier</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('backend.catalog.products.import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="file" name="csv" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                            <button class="btn btn-primary" type="submit">Envoyer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('catalog.products.create')
                        <button
                            hx-target="#modal-create"
                            hx-trigger="click"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-create"
                            class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-plus">
                            </i> Ajouter un produit
                        </button>
                    @include('backend.catalog.product.create',['categories' => $categories_list] )
                @endcan
            </div>

            <div class="card border-left-primary shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des produits</h6>

                </div>

                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table id="datatable" class="table datatable table-hover table-bordered w-100">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%;">#</th>
                                <th scope="col" class="text-center">Image</th>
                                <th scope="col" class="text-center">Nom</th>
                                <th scope="col" class="text-center">Catégories</th>
                                <th scope="col" class="text-center">Marque</th>
                                <th scope="col" class="text-center">Prix HT</th>
                                <th scope="col" class="text-center">TVA</th>
                                <th scope="col" class="text-center">Prix TTC</th>
                                <th scope="col" class="text-center">Stock</th>
                                <th scope="col" class="text-center">Activé</th>
                                <th scope="col" class="text-center" style="width: 8%;"><i
                                        class="fa-duotone fa-arrows-minimize"></i></th>
                            </tr>
                            </thead>

                            @foreach ($products as $product)
                                <tr>
                                    <td class="text-center align-middle">{{ $product->id }}</td>
                                    <td class="text-center align-middle">
                                        <img src="{{ $product->getFirstImagesURL(50, 50) }}" alt="{{ $product->name }}" style="width: 50px;">
                                    </td>
                                    <td class="text-center align-middle" ><div class="d-inline-block text-wrap" style="max-width: 350px;">{{ $product->name }}</div>
                                        <br> <div class="d-inline-block text-truncate fw-lighter fst-italic" style="max-width: 300px;">Lien du produit : <a target="_blank" href="{{ route('product.show', $product->slug) }}"><span class="" >{{ route('product.show', $product->slug) }}</span></a></div> </td>
                                    <td class="text-center align-middle">
                                        @forelse ($product->categories as $category)
                                            <span>{{ $category->name }}</span><br>
                                        @empty
                                            <div>Aucune catégorie</div>
                                        @endforelse
                                    </td>
                                    <td class="text-center align-middle">{{ $product->brand->name ?? 'Aucune marque' }}</td>
                                    <td class="text-center align-middle">{{ formatPriceToFloat($product->price_ht) }} €</td>
                                    <td class="text-center align-middle">{{ formatPriceToFloat($product->tva) }} %</td>
                                    <td class="text-center align-middle">{{ formatPriceToFloat($product->price_ttc) }} €</td>
                                    <td class="text-center align-middle">{{ $product->getStockQuantity($product) }}</td>
                                    <td class="text-center align-middle">{{ getActive($product->active) }}</td>

                                    <td class="text-center align-middle">
                                        @can('catalog.products.update')
                                            <a href="{{ route('backend.catalog.products.edit', $product->id) }}"
                                               class="btn btn-success btn-sm hvr-grow" title="Modifier"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        @endcan
                                        @can('catalog.products.delete')
                                            <button type="button" class="btn btn-danger btn-sm hvr-grow"
                                                    title="Supprimer"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $product->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.layouts.modal-delete', ['id' => $product->id, 'title' => 'Êtes-vous sûr de vouloir supprimer le produit '.$product->name.' ?', 'route' => 'backend.catalog.products.destroy'])
                            @endforeach
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
