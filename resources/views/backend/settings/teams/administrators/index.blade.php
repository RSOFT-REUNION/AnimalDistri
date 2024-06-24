<div class="row">
    <div class="col">

        <div class="card border-left-primary shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liste des administrators</h6>
                @can('settings.teams.administrators.create')
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('backend.settings.teams.administrators.create') }}"
                           class="btn btn-success my-2  hvr-grow"><i class="fa-solid fa-plus"></i> Ajouter un
                            utilisateur</a>
                    </div>
                @endcan
            </div>

            <div class="card-body">
                <div class="table-responsive mb-3 ">
                    <table id="datatable" class="datatable table table-hover table-bordered w-100">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%;">#</th>
                            <th scope="col" class="text-center">Nom</th>
                            <th scope="col" class="text-center">Email</th>
                            <th scope="col" class="text-center">Roles</th>
                            <th scope="col" class="text-center" style="width: 15%;"><i
                                    class="fa-duotone fa-arrows-minimize"></i></th>
                        </tr>
                        </thead>

                        @foreach ($admins as $admin)
                            <tr>
                                <td class="text-center">{{ $admin->id }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>@foreach ($admin->roles as $role)
                                        <span class="badge badge-info mr-1">
                                                {{ $role->name }}
                                            </span>
                                    @endforeach</td>
                                <td class="text-center">
                                    @if ($admin->name!='SuperAdmin')
                                        @can('settings.teams.administrators.changepassword')
                                            <button type="button" class="btn btn-warning btn-sm"
                                                    title="Modifier le mot de passe"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#changepassword{{ $admin->id }}">
                                                <i class="fa-solid fa-key fa-sm"></i>
                                            </button>
                                        @endcan
                                        @can('settings.teams.administrators.update')
                                            <a href="{{ route('backend.settings.teams.administrators.edit', $admin->id) }}"
                                               class="btn btn-success btn-sm" title="Modifier"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        @endcan
                                        @can('settings.teams.administrators.delete')
                                            <button type="button" class="btn btn-danger btn-sm" title="Supprimer"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $admin->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @endcan
                                    @endif

                                </td>
                            </tr>
                            @include('backend.layouts.modal-delete', ['id' => $admin->id, 'title' => 'Etes-vous sur de vouloir delete '.$admin->name.' ?', 'route' => 'backend.settings.teams.administrators.destroy'])
                            @include('backend.settings.teams.administrators.modal-changepassword')

                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
