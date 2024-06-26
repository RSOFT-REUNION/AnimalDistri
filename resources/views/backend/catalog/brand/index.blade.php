@extends('backend.layouts.layout')
@section('title', __('Gestion des marques') )

@section('main-content')

    <div class="row m-2">
        <div class="col">

            @can('catalog.brands.create')
                <div class="d-flex gap-2 justify-content-end mb-3 me-5">
                    <button
                        hx-target="#modal-create"
                        hx-trigger="click"
                        data-bs-toggle="modal"
                        data-bs-target="#modal-create"
                        class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-plus">
                        </i> Ajouter une marque
                    </button>
                </div>
                @include('backend.catalog.brand.create')
            @endcan

            <div class="card border-left-primary shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des Marques & Fournisseurs</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table id="datatable" class="table datatable table-hover table-bordered w-100">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%;">#</th>
                                <th scope="col" class="text-center">Logo</th>
                                <th scope="col" class="text-center">Nom</th>
                                <th scope="col" class="text-center" style="max-width: 350px;">Description</th>
                                <th scope="col" class="text-center" width="5%">Produits</th>
                                <th scope="col" class="text-center" width="5%">Activé</th>
                                <th scope="col" class="text-center" style="width: 8%;"><i
                                        class="fa-duotone fa-arrows-minimize"></i></th>
                            </tr>
                            </thead>

                            @foreach ($brands as $brand)
                                <tr>
                                    <td class="text-center">{{ $brand->id }}</td>
                                    <td class="text-center align-middle">
                                        @if($brand->image != null)
                                            <img src="{{ getImageUrl('/upload/catalog/brands/'.$brand->image, 50, 50) }}" alt="{{ $brand->name }}">
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">{{ $brand->name }}</td>
                                    <td class="text-center text-wrap" style="max-width: 350px;">{{ $brand->short_description ?? 'Aucune description' }}</td>
                                    <td  class="text-center align-middle">{{  count($brand->products->where('active', 1)) }}</td>
                                    <td  class="text-center align-middle">{{ getActive($brand->active) }}</td>
                                    <td class="text-center">
                                        @can('catalog.brands.update')
                                            <a href="{{ route('backend.catalog.brands.edit', $brand->id) }}"
                                               class="btn btn-success btn-sm hvr-grow" title="Modifier"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        @endcan
                                        @can('catalog.brands.delete')
                                            <button type="button" class="btn btn-danger btn-sm hvr-grow"
                                                    title="Supprimer"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $brand->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.layouts.modal-delete', ['id' => $brand->id, 'title' => 'Êtes-vous sûr de vouloir supprimer la marque '.$brand->name.' ?', 'route' => 'backend.catalog.brands.destroy'])
                            @endforeach

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
