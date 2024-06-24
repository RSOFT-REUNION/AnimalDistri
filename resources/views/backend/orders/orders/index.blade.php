@extends('backend.layouts.layout')
@section('title', __('Gestion des commandes'))

@section('main-content')

    <div class="row m-2">
        <div class="col">
            <div class="card border-left-primary shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Suivi des Commandes</h6>
                </div>

                <div class="card-body">

                    <div class="table-responsive mb-3">
                        <table id="datatable" class="table datatable table-hover table-bordered w-100">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%;">#</th>
                                <th scope="col" class="text-center">Nom du client</th>
                                <th scope="col" class="text-center">Date de la commande</th>
                                <th scope="col" class="text-center">Mode de livraison</th>
                                <th scope="col" class="text-center">Total</th>
                                <th scope="col" class="text-center">Statut</th>
                                <th scope="col" class="text-center" style="width: 5%;"><i
                                        class="fa-duotone fa-arrows-minimize"></i></th>
                            </tr>
                            </thead>

                            @foreach ($orders as $order)
                                <tr>
                                    <td class="text-center">
                                        @if($order->ref_order)
                                            {{ $order->ref_order }}
                                        @else
                                            {{ $order->id }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $order->user_name }}</td>
                                    <td class="text-center">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="text-center">{{ $order->getDeliverName() }}</td>
                                    <td class="text-center">{{ formatPriceToFloat($order->total_ttc) }} €</td>
                                    <td class="text-center">{{ $order->getStatus() }}</td>
                                    <td class="text-center">
                                        @can('orders.orders.update')
                                             <a href="{{ route('backend.orders.orders.edit', $order->id) }}"
                                                 class="btn btn-success btn-sm" title="Modifier"><i
                                                     class="fa-solid fa-pen-to-square"></i></a>
                                         @endcan
                                    {{-- @can('orders.orders.delete')
                                             <button type="button" class="btn btn-danger btn-sm" title="Supprimer"
                                                 data-bs-toggle="modal" data-bs-target="#deleteModal{{ $order->id }}">
                                                 <i class="fa-solid fa-trash"></i>
                                             </button>
                                         @endcan --}}
                                    </td>
                                </tr>
                                {{-- @include('backend.layouts.modal-delete', [
                                    'id' => $order->id,
                                    'title' =>
                                        'Êtes-vous sûr de vouloir supprimer la commande ' . $order->name . ' ?',
                                    'route' => 'backend.orders.orders.destroy',
                                ]) --}}
                            @endforeach

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
