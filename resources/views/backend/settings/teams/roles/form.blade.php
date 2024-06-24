@extends('backend.layouts.layout')
@section('title', $role->exists ? __('Modifier un role') : __('Créer un role'))


@section('main-content')
    <div class="row m-4">
        <div class="col">

            <div class="card border-left-primary shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        @if($role->exists)
                            Modification
                        @else
                            Création
                        @endif
                        d'un role
                    </h6>
                </div>
                <div class="card-body">
                    <form
                            action="{{ route($role->exists ? 'backend.settings.teams.roles.update' : 'backend.settings.teams.roles.store', $role) }}"
                            method="post" class="mt-6 space-y-6">
                        @csrf
                        @method($role->exists ? 'put' : 'post')

                        <div class="form-group focused">
                            <label class="form-control-label" for="name">Nom :<span
                                        class="small text-danger">*</span></label>
                            <input id="name" type="text" name="name"
                                   class="@error('name') is-invalid @enderror form-control" required
                                   value="{{ old('name', $role->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="m-0w">
                            <label for="permissions" class="form-label">Permissions :</label>

                            @php
                                $i = 1;
                                $lastCategory = null;
                                $lastParentName = null;
                            @endphp
                            @foreach ($permission_groups as $group)
                                @php
                                    $permissions = \App\Models\Settings\Teams\Administrator::getpermissionsByGroupName($group->name);
                                    $j = 1;
                                @endphp

                                <div class="row">
                                    <div class="col-3">
                                        @if($lastCategory != $group->category || $lastParentName != $group->parent_name)
                                            {{ $group->category }} @if($group->parent_name)
                                                /
                                            @endif {{$group->parent_name}}
                                            @php
                                                $lastCategory = $group->category;
                                                $lastParentName = $group->parent_name;
                                            @endphp :
                                        @endif
                                    </div>
                                    <div class="col-9">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                           class="form-check-input" id="{{ $i }}Management"
                                                           value="{{ $group->name }}"
                                                           onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" {{ \App\Models\Settings\Teams\Administrator::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                           for="{{ $i }}Management">{{ $group->name }}</label>
                                                </div>
                                            </div>

                                            <div class="col-9 role-{{ $i }}-management-checkbox">
                                                @foreach ($permissions as $permission)
                                                    <div class="form-check  form-switch">
                                                        <input type="checkbox" class="form-check-input"
                                                               onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})"
                                                               name="permissions[]"
                                                               {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="checkPermission{{ $permission->id }}"
                                                               value="{{ $permission->name }}">
                                                        <label class="form-check-label"
                                                               for="checkPermission{{ $permission->id }}">{{ renamePermission($permission->name) }}</label>
                                                    </div>
                                                    @php  $j++; @endphp
                                                @endforeach
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php  $i++; @endphp
                            @endforeach
                        </div>


                        <div class="d-flex gap-2 justify-content-center mt-3">
                            <button type='button' class="btn btn-danger"
                                    onclick="location.href='{{ route('backend.settings.teams.index') }}'">
                                <i class="fa-solid fa-rotate-left"></i>&nbsp;Annuler
                            </button>
                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i>
                                @if($role->exists)
                                    Modifier
                                @else
                                    Créer
                                @endif
                            </button>&nbsp;&nbsp;
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
