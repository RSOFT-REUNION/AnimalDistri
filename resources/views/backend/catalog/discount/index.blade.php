@extends('backend.layouts.layout')
@section('title', __('Gestion des Promotions') )

@section('main-content')

    <div class="row m-2">
        <div class="col">
                <div class="d-flex gap-2 justify-content-end mb-3 me-5">
                    @can('catalog.discount.import')
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
                                        <form action="{{ route('backend.catalog.discounts.import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <label for="discount_list" class="form-label">Liste des promotions</label>
                                            <input type="file" name="discount_list" class="form-control mb-3" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

                                            <label for="discount_products" class="form-label">Produits des promotions</label>
                                            <input type="file" name="discount_products" class="form-control mb-3" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">

                                            <div class="text-center">
                                                <button class="btn btn-primary" type="submit">Envoyer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                    @can('catalog.discount.create')
                        <a href="{{ route('backend.catalog.discounts.create') }}" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-plus"></i> Ajouter une promotion</a>
                    @endcan
                </div>

            <div class="card border-left-primary shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des promotions</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table id="datatable" class="table datatable table-hover table-bordered w-100">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%;">#</th>
                                <th scope="col" class="text-center">Nom</th>
                                <th scope="col" class="text-center">Remise</th>
                                <th scope="col" class="text-center">Date de début</th>
                                <th scope="col" class="text-center">Date de fin</th>
                                <th scope="col" class="text-center"  style="width: 5%;">Activé</th>
                                <th scope="col" class="text-center no-sort" width="8%"><i
                                        class="fa-duotone fa-arrows-minimize"></i></th>
                            </tr>
                            </thead>

                            @foreach ($discounts as $discount)
                                <tr>
                                    <td class="text-center">{{ $discount->id }}</td>
                                    <td class="text-center">{{ $discount->name }} </td>
                                    <td class="text-center">{{ $discount->percentage }} %</td>
                                    <td class="text-center">@if($discount->isCurrentlyActive()) <span class="badge bg-primary">En cours</span> @endif {{ $discount->start_date }}</td>
                                    <td class="text-center">{{ $discount->end_date }}</td>
                                    <td class="text-center">{{ getActive($discount->active) }}</td>
                                    <td class="text-center">
                                        @can('catalog.discounts.update')
                                            <a href="{{ route('backend.catalog.discounts.edit', $discount->id) }}"
                                               class="btn btn-success btn-sm hvr-grow" title="Modifier"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        @endcan
                                        @can('catalog.discounts.delete')
                                            <button type="button" class="btn btn-danger btn-sm hvr-grow"
                                                    title="Supprimer"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $discount->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.layouts.modal-delete', ['id' => $discount->id, 'title' => 'Êtes-vous sûr de vouloir supprimer cette promotion '.$discount->name.' ?', 'route' => 'backend.catalog.discounts.destroy'])
                            @endforeach

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
