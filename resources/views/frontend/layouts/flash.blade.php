@if(session('success'))
    <div class="alert alert-success fade show top-message">
        <i class="fa-solid fa-check"></i> {{ session('success') }}
    </div>
@endif
@if(session('danger'))
    <div class="alert alert-danger fade show  top-message">
        <i class="fa-solid fa-circle-exclamation"></i> {{ session('danger') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger fade show  top-message">
        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger fade show  top-message">
        <ul class="my-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
