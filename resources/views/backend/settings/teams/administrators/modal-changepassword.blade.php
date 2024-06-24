<div class="modal fade" id="changepassword{{  $admin->id }}" tabindex="-1"
     aria-labelledby="changepassword{{  $admin->id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Changement du mot de passe pour {{ $admin->name }}
                </h5>
            </div>

            <form action="{{ route('backend.settings.teams.administrators.changepassword', $admin->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="m-0">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control @error('name') is-invalid @enderror"
                               id="password" name="password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="fa-solid fa-rotate-left"></i>&nbsp;Annuler
                    </button>
                    <button class="btn btn-success">
                        <i class="fa-solid fa-check"></i>&nbsp;Modiffier
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
