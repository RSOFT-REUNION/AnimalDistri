@extends('frontend.layouts.layout')
@section('title', __('Mon Panier') )

@section('main-content')

    <div style="margin-top: 60px;" class="mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Mon panier</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Mon adresse</li>
            </ol>
        </nav>
    </div>

    @auth
        <div class="row row-flex" id="divaddress">
            <div class="col-12 col-md-9">
                <div class="row row-flex m-3" id="address_list">
                    <h3 class="mb-3">Adresse de livraison</h3>

                    @forelse($address as $addres)
                        <div class="col-12 text-center mb-3 p-3">
                            <div class="mb-4 row align-items-center position-relative rounded-4 @if($addres->id == $addres->favorite) bg-favorite rounded-4 shadow @endif" style="border: #000000 1px solid;">
                                @if($addres->id == $addres->favorite)
                                    <h4><span class="badge bg-primary position-absolute top-0 start-0 text-favorite">Adresse de facturation</span></h4>
                                @endif

                                <h4 class="text-center mb-4 mt-3">{{ $addres->alias }}</h4>
                                <div class="col-md-3 col-12">
                                    <h4>{{ $addres->first_name.' '.$addres->last_name }}</h4>
                                </div>
                                <div class="col-md-3 col-12">
                                    <p>
                                        {{ $addres->address }} <br>
                                        {{ $addres->address2 }} <br>
                                    </p>
                                </div>
                                <div class="col-md-3 col-12 mb-4">
                                    <p>
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
                                <div class="col-md-3 col-12">
                                    <form action="{{ route('cart.chose_delivery') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="address" value="{{ $addres->id }}">
                                        <input type="hidden" name="cart" value="{{ $cart->id }}">
                                        <button type="submit" class="btn btn-primary btn-lg text-center hvr-grow-shadow" style="margin-top: -40px;"><i class="fa-solid fa-circle-arrow-right"></i>  Sélectionner</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        @include('frontend.carts.partials.add_address')
                    @endif

                </div>
            </div>
            <div class="col-12 col-md-3">
                @include('frontend.carts.partials.cart_summary')
            </div>

        </div>
    @endauth
    @guest
        @include('frontend.auth.login')
    @endguest

@endsection
