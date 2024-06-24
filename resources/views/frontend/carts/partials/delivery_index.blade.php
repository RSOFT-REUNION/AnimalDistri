<div class="row row-flex position-relative htmx-style" id="divdelivery" hx-trigger="loadLoyality from:body">

    <div class="htmx-indicator position-absolute top-50 start-100 translate-middle" role="status" aria-hidden="true">
        <span class="spinner-border text-warning" style="width: 5rem; height: 5rem;"></span>
    </div>

    <div class="col-12 col-md-9">
        <form action="" method="post"> @csrf
            <input type="hidden" name="address" value="{{ @$user_address->id }}">
            <input type="hidden" name="cart" value="{{ @$cart->id }}">

            <div class="row row-flex mb-5 justify-content-center">
                @foreach($delivery as $deliver)
                    <div class="col-12 col-md-4 mb-4">
                        <div
                            class="card hvr-float-shadow w-100 position-relative @if($deliver->id == @$delivery_chose->id) bg-primary text-white @endif"
                            style="cursor: pointer;"
                            hx-post="{{ route('cart.chosed_delivery', $deliver) }}"
                            hx-swap="outerHTML"
                            hx-target="#divdelivery"
                            hx-indicator=".htmx-indicator, .htmx-style">

                            @if($deliver->id == @$delivery_chose->id)
                                <h4><span class="badge bg-success position-absolute top-0 start-0 text-favorite"><i
                                            class="fa-regular fa-star"></i></span></h4>
                            @endif

                            <div class="card-body text-center">
                                <img class="img-fluid"
                                     src="{{ getImageUrl(('/upload/order/delivery/'.$deliver->image), 200, 200) }}"
                                     alt="{{ $deliver->name }}">
                                <h3 @if($deliver->id == @$delivery_chose->id) class="text-white" @endif>{{ $deliver->name }}</h3>
                                <p>{{ $deliver->description }}</p>
                                <p>Frais de livraison : @if($deliver->price_ttc == 0)
                                        <b>Gratuit</b>
                                    @else
                                        {{ $deliver->price_ttc }} €
                                    @endif</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </form>

        @if(@$delivery_chose)
            @if(@$delivery_chose->price_ttc == 10)
                @if(getRegion($user_address->cities) == 'nord')
                    <div class="text-center">
                        <img style="width: 100px;" src="{{ asset('frontend/images/24-hours.png') }}">
                        <h3 class="mb-5">Choix souhaitez du créneau de livraison (Région Nord / Est)</h3>
                    </div>
                    @include('frontend.carts.partials.delivery_index_slot', array('region'=>'nord'))
                @elseif(getRegion($user_address->cities) == 'sud')
                    <div class="text-center">
                        <img style="width: 100px;" src="{{ asset('frontend/images/24-hours.png') }}">
                        <h3 class="mb-5">Choix souhaitez du créneau de livraison (Région Sud / Ouest)</h3>
                    </div>
                    @include('frontend.carts.partials.delivery_index_slot', array('region'=>'sud'))
                @else
                    <div class="w-75 mx-auto bg-danger rounded-4 shadow text-white p-3">
                        <div class="text-center"><i class="fa-solid fa-triangle-exclamation fa-5x"></i></div>
                        <p>Nous sommes désolés, mais la livraison n'est pas encore disponible dans votre
                            commune.<br>
                            Vous pouvez modifier votre adresse de livraison directement dans votre espace clients.
                        </p>
                        <div class="text-center">
                            <a href="{{ route('address.index') }}" class="btn btn-primary btn-lg hvr-grow-shadow"><i
                                    class="fa-solid fa-address-card"></i> Voir mes adresses</a>
                        </div>
                    </div>
                @endif
                @if(@$delivery_date)
                    @include('frontend.carts.chose_loyality')
                @endif

            @else
                @include('frontend.carts.chose_loyality')
            @endif
        @endif


    </div>
    <div class="col-12 col-md-3">
        @include('frontend.carts.partials.cart_summary')
    </div>

</div>
