@php
    $id ??= '';
    $title ??= '';
    $message ??= '';
    $route ??= '';
@endphp

<div class="modal fade" id="deleteModal{{ $id }}" tabindex="-1" aria-labelledby="deleteModal{{ $id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ $title }}
                </h5>
            </div>
            @empty(!$message)
                <div class="modal-body">
                    {{ $message }}
                </div>
            @endempty
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="fa-solid fa-rotate-left"></i>&nbsp;Annuler
                </button>
                <form action="{{ route($route, $id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i>&nbsp;Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
