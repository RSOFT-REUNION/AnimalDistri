@extends('backend.layouts.layout')
@section('title', __('Gestions des pages') )

@section('main-content')

    <div class="row m-2">
        <div class="col">

            @can('content.pages.create')
                <div class="d-flex gap-2 justify-content-end mb-3 me-5">
                    <a href="{{ route('backend.content.pages.create') }}" class="btn btn-success hvr-float-shadow"><i class="fa-solid fa-plus"></i> Ajouter une page</a>
                </div>
            @endcan

            <div class="card border-left-primary shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des pages</h6>
                </div>

                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table id="datatable" class="table datatable table-hover table-bordered w-100">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center no-sort" style="width: 5%;">#</th>
                                <th scope="col" class="text-center">Nom</th>
                                <th scope="col" class="text-center">Url</th>
                                <th scope="col" class="text-center">Categorie</th>
                                <th scope="col" class="text-center">Description</th>
                                <th scope="col" class="text-center" width="5%">Menu</th>
                                <th scope="col" class="text-center" width="5%">Activer</th>
                                <th scope="col" class="text-center no-sort" width="8%"><i class="fa-duotone fa-arrows-minimize"></i></th>
                            </tr>
                            </thead>

                            @foreach ($pages as $page)
                                <tr>
                                    <td class="text-center">{{ $page->id }}</td>
                                    <td>{{ $page->name }}</td>
                                    <td>{{ $page->slug }}</td>
                                    <td>{{ $page->getCategoryName($page->category_id) }}</td>
                                    <td>{{ $page->description }}</td>
                                    <td  class="text-center align-middle">{{ getActive($page->is_menu) }}</td>
                                    <td  class="text-center align-middle">{{ getActive($page->active) }}</td>
                                    <td class="text-center">
                                        @can('content.pages.update')
                                            <a href="{{ route('backend.content.pages.edit', $page->id) }}"
                                               class="btn btn-success btn-sm hvr-grow" title="Modifier"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        @endcan
                                        @if($page->id != 1)
                                            @can('content.pages.delete')
                                                <button type="button" class="btn btn-danger btn-sm hvr-grow"
                                                        title="Supprimer"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $page->id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                                @include('backend.layouts.modal-delete', ['id' => $page->id, 'title' => 'Etes-vous sur de vouloir supprimer la page '.$page->name.' ?', 'route' => 'backend.content.pages.destroy'])
                            @endforeach

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
