@extends('backend.layouts.layout')
@section('title', __('Adresse du client') )

@section('main-content')

    <div class="d-flex gap-2 justify-content-end mb-3 me-5">
        <a href="{{ route('backend.clients.client.index') }}" class="btn btn-danger hvr-float-shadow"><i class="fa-solid fa-rotate-left"></i> Retour</a>
    </div>

    <div class="row m-2">
        <div class="col">
            <div class="card border-left-primary shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Adresse du client {{ $client->name }} {{ $client->first_name }}</h6>
                </div>

                <div class="card-body">

                    <div class="table-responsive mb-3">
                        <table id="datatable" class="table datatable table-hover table-bordered w-100">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">Nom</th>
                                <th scope="col" class="text-center">Adresse</th>
                                <th scope="col" class="text-center">Suite</th>
                                <th scope="col" class="text-center">Autre</th>
                                <th scope="col" class="text-center">Code Postal</th>
                                <th scope="col" class="text-center">Ville</th>
                                <th scope="col" class="text-center">Pays</th>
                                <th scope="col" class="text-center">Téléphone</th>
                                <th scope="col" class="text-center">Autre Téléphone</th>
                            </tr>
                            </thead>

                            @foreach ($addresses as $address)
                                <tr>
                                    <td class="text-center">{{ $address->name }}</td>
                                    <td class="text-center">{{ $address->address }}</td>
                                    <td class="text-center">{{ $address->address2 }}</td>
                                    <td class="text-center">{{ $address->other }}</td>
                                    <td class="text-center">{{ $address->postal_code }}</td>
                                    <td class="text-center">{{ $address->city }}</td>
                                    <td class="text-center">{{ $address->country }}</td>
                                    <td class="text-center">{{ $address->phone }}</td>
                                    <td class="text-center">{{ $address->other_phone }}</td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
