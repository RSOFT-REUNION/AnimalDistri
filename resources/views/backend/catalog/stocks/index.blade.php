@extends('backend.layouts.layout')
@section('title', __('Gestion des stocks'))

@section('main-content')

    <div class="row m-2">
        <div class="col">
            <div class="card border-left-primary shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Suivi des stocks</h6>
                    @can('catalog.products.create')
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('backend.catalog.products.create') }}" class="btn btn-success my-2 hvr-grow"><i
                                    class="fa-solid fa-plus"></i> Ajouter un produit au stock</a>
                        </div>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table id="datatable" class="table datatable table-hover table-bordered w-100">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center" style="width: 5%;">#</th>
                                    <th scope="col" class="text-center">Produit</th>
                                    <th scope="col" class="text-center">Réference</th>
                                    <th scope="col" class="text-center">Dêpot / magasin </th>
                                    <th scope="col" class="text-center">Stock disponible</th>
                                    <th scope="col" class="text-center">Quantité reservé</th>
                                    <th scope="col" class="text-center">Quantité vendue</th>
                                    <th scope="col" class="text-center"><i class="fa-duotone fa-pen"></i></th>
                                </tr>
                            </thead>

                            @foreach ($stocks as $stock)
                                <tr>
                                    <td class="text-center">{{ $stock->id }}</td>
                                    <td>{{ $stock->reference }}</td>
                                    <td>{{ $stock->getShop() }}</td>
                                    <td>{{ $stock->quantity_in_stock }}</td>
                                    <td>{{ $stock->quantity_reserved }}</td>
                                    <td>{{ $stock->quantity_sold }}</td>
                                    <td class="text-center">
                                        @can('catalog.stocks.update')
                                            <form action="">
                                                <input type="text"><button></button>
                                            </form>
                                        @endcan
                                        @can('catalog.stocks.delete')
                                            <button type="button" class="btn btn-danger btn-sm" title="Supprimer"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $stock->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.layouts.modal-delete', [
                                    'id' => $stock->id,
                                    'title' =>
                                        'Êtes-vous sûr de vouloir supprimer le magasin ' . $stock->name . ' ?',
                                    'route' => 'backend.catalog.stocks.destroy',
                                ])
                            @endforeach

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
