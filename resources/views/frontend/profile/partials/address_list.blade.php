<div id="address_list">
    @forelse($address as $addres)
        <div class="mb-4 row align-items-center position-relative @if($addres->id == $addres->favorite) bg-favorite rounded-4 shadow @endif">
            @if($addres->id == $addres->favorite)
                <h4><span class="badge bg-primary position-absolute top-0 start-0 text-favorite">Adresse de facturation</span></h4>
            @endif

            <div class="col-md-3">
                <h4>{{ $addres->alias }}</h4>
                <p>{{ $addres->name }}</p>
            </div>
            <div class="col-md-6">
                <p>
                    {{ $addres->address }} <br>
                    {{ $addres->address2 }} <br>
                    @foreach($cities as $city)
                        @if($city->postal_code == $addres->cities)
                            {{ $city->postal_code }} - {{ $city->city }} <br>
                        @endif
                    @endforeach
                    {{ $addres->country }} <br>
                    Téléphone : {{ $addres->phone }}
                    @if($addres->other_phone)
                        / {{ $addres->other_phone }}
                    @endif
                </p>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <a href="{{ route('address.edit', $addres->id) }}"
                       class="btn btn-success btn-sm mb-3" title="Modifier"><i
                            class="fa-solid fa-pen-to-square"></i>&nbsp;Modifier</a>
                    <form action="{{ route('address.destroy', $addres->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mb-3" title="Supprimer" onclick="return confirm('Êtes-vous sûr de bien vouloir supprimer cet élément?');">
                            <i class="fa-solid fa-trash"></i>&nbsp;Supprimer
                        </button>
                    </form>
                    @if($addres->id != $addres->favorite)
                        <form> @csrf @method('PUT')
                            <button type="button" class="btn btn-primary btn-sm" id="fav_image"
                                    hx-post="{{ route('address.fav_address', $addres) }}"
                                    hx-target="#address_list"
                                    hx-swap="outerHTML"
                            ><i class="fa-regular fa-star"></i> Adresse de facturation</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>


    @empty
        <h4 class="text-center">Vous n'avez pas encore d'adresse</h4>
    @endif
</div>
