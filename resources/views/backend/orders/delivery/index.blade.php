@extends('backend.layouts.layout')
@section('title', __('Gestion de la livraison'))

@section('main-content')

    <div class="row m-2">
        <div class="col">
            @can('orders.delivery.create')
                <div class="d-flex gap-2 justify-content-end mb-3 me-5">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('backend.orders.delivery.create') }}" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-plus"></i> Ajouter une option de livraison</a>
                    </div>
                </div>
            @endcan
            <div class="card border-left-primary shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des options de livraison</h6>
                </div>

                <div class="card-body">
                    <table id="datatable" class="table datatable table-hover table-bordered w-100">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center no-sort" style="width: 5%;">#</th>
                            <th scope="col" class="text-center" style="width: 20%;">Image</th>
                            <th scope="col" class="text-center">Nom</th>
                            <th scope="col" class="text-center">Prix</th>
                            <th scope="col" class="text-center" width="5%">Activer</th>
                            <th scope="col" class="text-center no-sort" width="8%"><i class="fa-duotone fa-arrows-minimize"></i></th>
                        </tr>
                        </thead>

                        @foreach ($delivery as $deliver)
                            <tr>
                                <td class="text-center align-middle">{{ $deliver->id }}</td>
                                <td class="text-center align-middle"><img style="max-height: 50px;" src="/storage/upload/order/delivery/{{ $deliver->image }}" alt="{{ $deliver->name }}"></td>
                                <td class="text-center align-middle">{{ $deliver->name }}</td>
                                <td class="text-center align-middle">
                                    @if($deliver->price_ttc == 0) Gratuit @else {{ $deliver->price_ttc }} €@endif
                                </td>
                                <td class="text-center align-middle">{{ getActive($deliver->active) }}</td>
                                <td class="text-center align-middle">
                                    @can('orders.delivery.update')
                                        <a href="{{ route('backend.orders.delivery.edit', $deliver->id) }}"
                                           class="btn btn-success btn-sm hvr-grow" title="Modifier"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                    @endcan
                                    @can('orders.delivery.delete')
                                        <button type="button" class="btn btn-danger btn-sm hvr-grow"
                                                title="Supprimer"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $deliver->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                            @include('backend.layouts.modal-delete', ['id' => $deliver->id, 'title' => 'Êtes-vous sûr de vouloir supprimer '.$deliver->name.' ?', 'route' => 'backend.orders.delivery.destroy'])
                        @endforeach


                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
