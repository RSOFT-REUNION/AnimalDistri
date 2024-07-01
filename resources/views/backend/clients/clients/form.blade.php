@extends('backend.layouts.layout')
@section('title', $client->exists ? 'Modification du client '. $client->name : __('Créer un client'))

@section('main-content')
    <form
        action="{{ route($client->exists ? 'backend.clients.client.update' : 'backend.clients.client.store', $client) }}"
        method="post" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method($client->exists ? 'put' : 'post')

        <div class="d-flex gap-2 justify-content-end mb-3 me-5">
            <div class="form-check form-switch d-flex align-items-center">
                <input class="form-check-input"
                       @if(!$client->exists) checked @endif
                       @if($client->active) checked @endif
                       type="checkbox" role="switch" id="active" name="active">
                <label class="form-check-label" for="active">Activer</label>
            </div>
            <button type='button' class="btn btn-danger hvr-float-shadow"
                    onclick="location.href='{{ route('backend.clients.client.index') }}'">
                <i class="fa-solid fa-rotate-left"></i>&nbsp;Annuler
            </button>
            <button type="submit" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-pen-to-square"></i>
                @if ($client->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
        </div>

        <div class="row m-2">
            <div class="col-md-8 col-12">
                <div class="card border-left-primary shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informations</h6>
                    </div>
                    <div class="card-body">
                        <h3>{{ $client->civility .' '. $client->last_name.' '. $client->first_name}}</h3>
                        <p>Adresse mail : {{ $client->email }}</p>
                        <p>Téléphone : {{ $client->phone }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="card border-left-warning shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Groupe</h6>
                    </div>
                    <div class="card-body">
                        <div class="m-0w">
                            <select class="form-select tomselect @error('groups_id') is-invalid @enderror" aria-label="groups_id"
                                    id="groups_id" name="groups_id">
                                <option value="Null"> Aucun groupe </option>
                                @foreach($groups_list as $group)
                                    <option @if($group->id == $client->groups_id) selected @endif value="{{ $group->id }}"> {{ $group->name }}</option>
                                @endforeach
                            </select>
                            @error('groups_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </div>

@include('backend.clients.clients.partial.addresses')


@endsection
