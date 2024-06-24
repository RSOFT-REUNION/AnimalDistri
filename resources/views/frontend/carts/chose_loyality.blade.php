<h2>Mon programme fidélité <i class="fa-solid fa-star"></i></h2>

@if($loyality->erp_loyalty_card)

    <div class="d-flex">
        <div class="p-2 flex-fill"><b>Carte n° :</b> {{ $loyality->erp_loyalty_card }}</div>
        <div class="p-2 flex-fill">
            <h4 class="text-end"> @if($loyality->erp_loyalty_points)
                    <b>{{ $loyality->erp_loyalty_points }}</b>
                @else
                    <b>0</b>
                @endif Points disponible</h4>
        </div>
    </div>

    @if($loyality->erp_loyalty_points >= 300)
        <div class="row row-flex justify-content-center">
            <div class="hvr-float-shadow col-md-2 col-12 p-1 m-2" style="cursor: pointer;">
                <div class="card content bg-primary">
                    <form action="{{ route('cart.summary') }}" method="post" class="text-center"> @csrf
                        @include('frontend.carts.partials.loyality_hidden_input')
                        <input type="hidden" name="loyality" value="0">

                        <div class="text-center">
                            <button type="submit" class="btn">
                                <img class="img-fluid mb-3" src="{{ asset('frontend/images/discount.png') }}">
                                <h4 class="mx-auto text-white">Je ne souhaite pas utiliser mes points</h4>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="hvr-float-shadow col-md-2 col-12 p-1 m-2" style="cursor: pointer;">
                <div class="card content bg-warning">
                    <form action="{{ route('cart.summary') }}" method="post" class="text-center content"> @csrf
                        @include('frontend.carts.partials.loyality_hidden_input')
                        <input type="hidden" name="loyality" value="5">

                        <div class=" text-center">
                            <button type="submit" class="btn">
                                <img class="img-fluid mb-3" src="{{ asset('frontend/images/discount.png') }}">
                                <h1 class="mx-auto" style=" font-size: 42px;"> - 5 <i class="fa-solid fa-percent"></i></h1>
                                <p><b>300</b> point de fidélité seront utilisé.</p>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @if($loyality->erp_loyalty_points >= 500)
                <div class="hvr-float-shadow col-md-2 col-12 p-1 m-2" style="cursor: pointer;">
                    <div class="card content bg-primary">
                        <form action="{{ route('cart.summary') }}" method="post" class="text-center"> @csrf
                            @include('frontend.carts.partials.loyality_hidden_input')
                            <input type="hidden" name="loyality" value="10">

                            <div class="text-center">
                                <button type="submit" class="btn">
                                    <img class="img-fluid mb-3" src="{{ asset('frontend/images/discount.png') }}">
                                    <h1 class="mx-auto text-white" style=" font-size: 42px;"> - 10 <i
                                            class="fa-solid fa-percent"></i></h1>
                                    <p class="text-white"><b>500</b> point de fidélité seront utilisé.</p>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @if($loyality->erp_loyalty_points >= 1000)
                    <div class="hvr-float-shadow col-md-2 col-12 p-1 m-2" style="cursor: pointer;">
                        <div class="card content bg-warning">
                            <form action="{{ route('cart.summary') }}" method="post" class="text-center"> @csrf
                                @include('frontend.carts.partials.loyality_hidden_input')
                                <input type="hidden" name="loyality" value="15">

                                <div class=" text-center">
                                    <button type="submit" class="btn">
                                        <img class="img-fluid mb-3" src="{{ asset('frontend/images/discount.png') }}">
                                        <h1 class="mx-auto" style=" font-size: 42px;"> - 15 <i
                                                class="fa-solid fa-percent"></i></h1>
                                        <p><b>1 000</b> point de fidélité seront utilisé.</p>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    @else
        <h3 class="text-center m-4">Vous n'avez pas encore obtenu suffisamment de points</h3>
        <div class="text-center">
            <form action="{{ route('cart.summary') }}" method="post" class="text-center"> @csrf
                @include('frontend.carts.partials.loyality_hidden_input')
                <input type="hidden" name="loyality" value="0">

                <button type="submit" class="btn btn-lg btn-primary hvr-grow-shadow mb-4"><i class="fa-solid fa-list-check"></i> Récapitulatif
                    de ma commande</button>
            </form>
        </div>
    @endif

@else
    <div class="d-flex mb-5">
        <div class="p-2 flex-fill"><h3>Vous n'avez pas encore de carte</h3></div>
        <div class="p-2 flex-fill">
            <h4 class="text-end"><b>0</b> Points disponible</h4>
        </div>
    </div>
    <div class="text-center">
        <form action="{{ route('cart.summary') }}" method="post" class="text-center"> @csrf
            @include('frontend.carts.partials.loyality_hidden_input')
            <input type="hidden" name="loyality" value="0">

        <button type="submit" class="btn btn-lg btn-primary hvr-grow-shadow mb-4"><i class="fa-solid fa-list-check"></i> Récapitulatif
            de ma commande</button>
        </form>
    </div>
@endif
