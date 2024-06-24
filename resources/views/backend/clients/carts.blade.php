@extends('backend.layouts.layout')
@section('title', __('Liste des paniers clients') )

@section('main-content')

    <div class="row m-2">
        <div class="col">
            <div class="card border-left-primary shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des paniers</h6>
                </div>

                <div class="card-body">

                    <div class="table-responsive mb-3">
                        <table id="datatable" class="table datatable table-hover table-bordered w-100">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%;">#</th>
                                <th scope="col" class="text-center">Utilisateur</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center no-sort" style="width: 10%;"><i
                                        class="fa-duotone fa-arrows-minimize"></i></th>
                            </tr>
                            </thead>

                            @foreach ($carts as $cart)
                                <tr>
                                    <td class="text-center">{{ $cart->id }}</td>
                                    <td class="text-center">{{ $cart->getUser($cart->user_id) }}</td>
                                    <td class="text-center">{{ $cart->getStatus($cart->status) }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#cart{{ $cart->id }}"><i class="fa-regular fa-circle-info"></i></button>
                                    </td>
                                </tr>
                                @include('backend.clients.partial.cartsproductsmodal')
                            @endforeach

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
