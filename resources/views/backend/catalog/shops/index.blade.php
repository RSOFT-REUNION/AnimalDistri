@extends('backend.layouts.layout')
@section('title', __('Gestion des magasins') )

@section('main-content')

    <div class="row m-2">
        <div class="col">

            @can('content.carousel.create')
                <div class="d-flex gap-2 justify-content-end mb-3 me-5">
                    <a href="{{ route('backend.catalog.shops.create') }}"
                       class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-plus"></i> Ajouter un magasin</a>
                </div>
            @endcan

            <div class="card border-left-primary shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des magasins</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table id="datatable" class="table datatable table-hover table-bordered w-100">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%;">#</th>
                                <th scope="col" class="text-center">Nom</th>
                                <th scope="col" class="text-center">Adresse</th>
                                <th scope="col" class="text-center">Horaires</th>
                                <th scope="col" class="text-center">Visibilité</th>
                                <th scope="col" class="text-center" width="5%">Activer</th>
                                <th scope="col" class="text-center no-sort" width="8%"><i class="fa-duotone fa-arrows-minimize"></i></th>
                            </tr>
                            </thead>

                            @foreach ($shops as $shop)
                                <tr>
                                    <td class="text-center">{{ $shop->id }}</td>
                                    <td>{{ $shop->name }}</td>
                                    <td>{{ $shop->getShopAddress($shop->id) }}</td>
                                    <td>{{ $shop->schedules }}</td>
                                    <td>{{ $shop->visibility }}</td>
                                    <td class="text-center align-middle">{{ getActive($shop->active) }}</td>
                                    <td class="text-center">
                                        @can('catalog.shops.update')
                                            <a href="{{ route('backend.catalog.shops.edit', $shop->id) }}"
                                               class="btn btn-success btn-sm hvr-grow" title="Modifier"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        @endcan
                                        @can('catalog.shops.delete')
                                            <button type="button" class="btn btn-danger btn-sm hvr-grow"
                                                    title="Supprimer"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $shop->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.layouts.modal-delete', ['id' => $shop->id, 'title' => 'Êtes-vous sûr de vouloir supprimer le magasin '.$shop->name.' ?', 'route' => 'backend.catalog.shops.destroy'])
                            @endforeach

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
