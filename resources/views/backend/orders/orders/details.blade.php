@extends('backend.layouts.layout')
@section('title', __('Détails de la commande') )

@section('main-content')
    <div class="row m-2">
        <div class="col">
            <div class="card border-left-primary shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Détails de la commande n° {{ $order->id }}</h6>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('backend.orders.orders.index') }}" class="btn btn-danger my-2 hvr-grow"><i class="fa-solid fa-rotate-left"></i> Retour</a>
                    </div>
                    <div>Quantité d'articles : {{ $items->count() }}</div>
                    <div>TOTAL TTC: {{ $order->TotalTTC($order->id) }} €</div>
                </div>

                <div class="card-body">

                    <div class="table-responsive mb-3">
                        <table id="datatable" class="table datatable table-hover table-bordered w-100">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">Produit</th>
                                <th scope="col" class="text-center">Prix de base</th>
                                <th scope="col" class="text-center">Quantité</th>
                                <th scope="col" class="text-center">Remise</th>
                                <th scope="col" class="text-center">Total</th>
                            </tr>
                            </thead>

                            @foreach ($items as $item)
                                <tr>
                                    <td class="text-center">{{ $item->order }}</td>
                                    <td class="text-center">{{ $item->title($item->product_id) }}</td>
                                    <td class="text-center">{{ $item->price($item->product_id) }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-center">{{ $item->discount }}</td>
                                    <td class="text-center">{{ $item->total($item->product_id) }} €</td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
