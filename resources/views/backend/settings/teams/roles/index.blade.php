<div class="row">
    <div class="col">

        <div class="card border-left-primary shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liste des roles</h6>
                @can('settings.teams.roles.create')
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('backend.settings.teams.roles.create') }}"
                           class="btn btn-success my-2  hvr-grow"><i class="fa-solid fa-plus"></i> Ajouter un
                            role</a>
                    </div>
                @endcan
            </div>

            <div class="card-body">
                <div class="table-responsive mb-3">
                    <table id="datatable" class="table datatable table-hover table-bordered w-100">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%;">#</th>
                            <th scope="col" class="text-center">Nom</th>
                            <th scope="col" class="text-center" style="width: 15%;"><i
                                    class="fa-duotone fa-arrows-minimize"></i></th>
                        </tr>
                        </thead>

                        @foreach ($roles as $role)
                            <tr>
                                <td class="text-center">{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td class="text-center">
                                    @if ($role->name!='SuperAdmin')
                                        @can('settings.teams.roles.update')
                                            <a href="{{ route('backend.settings.teams.roles.edit', $role->id) }}"
                                               class="btn btn-success btn-sm" title="Modifier"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        @endcan
                                        @can('settings.teams.roles.delete')
                                            @if ($role->name!=Auth::user()->hasRole($role->name))
                                                <button type="button" class="btn btn-danger btn-sm"
                                                        title="Supprimer"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $role->id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endif
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                            @include('backend.layouts.modal-delete', ['id' => $role->id, 'title' => 'Etes-vous sur de vouloir supprimer '.$role->name.' ?', 'route' => 'backend.settings.teams.roles.destroy'])

                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
