@extends('backend.layouts.layout')
@section('title', __('Gestion des images du carrousel') )

@section('main-content')

    <div class="row m-2">
        <div class="col">
            @can('content.carousel.create')
                <div class="d-flex gap-2 justify-content-end mb-3 me-5">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('backend.content.carrousel.create') }}" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-plus"></i> Ajouter une image</a>
                    </div>
                </div>
            @endcan
            <div class="card border-left-primary shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des images du carrousel</h6>
                </div>

                <div class="card-body">
                    <div class="mb-3">

                        <table id="datatable" class="table datatable table-hover table-bordered w-100">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center no-sort" style="width: 5%;">#</th>
                                <th scope="col" class="text-center" style="width: 20%;">Image</th>
                                <th scope="col" class="text-center">Nom</th>
                                <th scope="col" class="text-center" width="5%">Activer</th>
                                <th scope="col" class="text-center no-sort" width="8%"><i class="fa-duotone fa-arrows-minimize"></i></th>
                            </tr>
                            </thead>

                            @foreach ($sliders as $slide)
                                <tr>
                                    <td class="text-center align-middle">{{ $slide->id }}</td>
                                    <td class="text-center align-middle"><img style="max-height: 50px;" src="/storage/upload/content/carousel/{{ $slide->image }}" alt="{{ $slide->name }}"></td>
                                    <td class="text-center align-middle">{{ $slide->name }}</td>
                                    <td class="text-center align-middle">{{ getActive($slide->active) }}</td>
                                    <td class="text-center align-middle">
                                        @can('specific.labels.update')
                                            <a href="{{ route('backend.content.carrousel.edit', $slide->id) }}"
                                               class="btn btn-success btn-sm hvr-grow" title="Modifier"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        @endcan
                                        @can('specific.labels.delete')
                                            <button type="button" class="btn btn-danger btn-sm hvr-grow"
                                                    title="Supprimer"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $slide->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                                @include('backend.layouts.modal-delete', ['id' => $slide->id, 'title' => 'Êtes-vous sûr de vouloir supprimer l\'image '.$slide->name.' ?', 'route' => 'backend.content.carrousel.destroy'])
                            @endforeach

                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
