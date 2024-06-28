<div class="card bg-gray mb-4">
    <div class="card-body  text-center">
        <img class="w-25 mb-3" src="{{ asset('frontend/images/shopping-bags.png') }}">
        <h3 class="text-center">Total TTC </h3>
        <h4 class="text-center">{{ $cart->countProduct() }} article(s)</h4>
        <h2 class="text-center mb-3">
            {{ formatPriceToFloat($cart->countProductsPrice(@$delivery_chose->price_ttc, 0)) }} €
        </h2>
        @if(@$delivery_chose->price_ttc)
            <p class="text-center mb-3">Dont <b>{{ $delivery_chose->price_ttc }} €</b> de frais de livraison </p>
        @endif
        <p class="text-center mb-3">Le total de la commande inclut la TVA.</p>
    </div>
</div>

@empty(!@$user_address)
    <div class="card bg-gray mb-4">
        <div class="card-body">
            <div class="text-center">
                <img class="w-25 mb-3" src="{{ asset('frontend/images/location.png') }}">
            </div>

            @if($user_address->id != $user_address->favorite)
                <h5>Adresse de facturation :</h5>
                <h5>{{ $user_address_fac->alias }}</h5>
                <p>{{ $user_address_fac->name }}<br>
                    {{ $user_address_fac->address }}
                    {{ $user_address_fac->address2 }}
                    <br>
                    @foreach($cities as $city)
                        @if($city->postal_code == $user_address_fac->cities)
                            {{ $city->postal_code }} - {{ $city->city }}
                        @endif
                    @endforeach
                    - {{ $user_address_fac->country }}
                    <br>
                    Téléphone : {{ $user_address_fac->phone }}
                    @if($user_address_fac->other_phone)
                        / {{ $user_address_fac->other_phone }}
                    @endif
                </p>

                <h5>Adresse de livraison :</h5>
            @endif

            <h5>{{ $user_address->alias }}</h5>
            <p>{{ $user_address->name }}<br>
                {{ $user_address->address }}
                {{ $user_address->address2 }}
                <br>
                @foreach($cities as $city)
                    @if($city->postal_code == $user_address->cities)
                        {{ $city->postal_code }} - {{ $city->city }}
                    @endif
                @endforeach
                - {{ $user_address->country }}
                <br>
                Téléphone : {{ $user_address->phone }}
                @if($user_address->other_phone)
                    / {{ $user_address->other_phone }}
                @endif
            </p>
        </div>
    </div>
@endempty
