@extends('frontend.layouts.layout')
@section('title', __('Livraison') )

@section('main-content')

    <div style="margin-top: -15px;" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 custom-breadcrumb">
                <li class="breadcrumb-item"><a class="link-dark" href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item"><a class="link-dark" href="{{ route('cart.index') }}">Mon panier</a></li>
                <li class="breadcrumb-item active link-dark" aria-current="page">Livraison</li>
            </ol>
        </nav>
    </div>

<div class="row">
    <div class="col-12 col-md-9">

        <form action="{{ route('cart.summary') }}" method="post" class="text-center"> @csrf
            <input type="hidden" name="address" value="{{ @$user_address->id }}">
            <input type="hidden" name="cart" value="{{ @$cart->id }}">

            <div class="row row-flex mb-5 justify-content-center">

                @foreach($delivery as $deliver)
                        <input type="hidden" name="delivery" value="{{ @$deliver->id }}">
                        <div class="col-12 col-md-4 mb-4">
                            <div
                                class="card hvr-float-shadow w-100 position-relative @if($deliver->id == @$delivery_chose->id) bg-primary text-white @endif"
                                style="cursor: pointer;">
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

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg text-center hvr-grow-shadow"><i class="fa-solid fa-circle-arrow-right"></i>  Sélectionner</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        </form>

    </div>
    <div class="col-12 col-md-3">
        @include('frontend.carts.partials.cart_summary')
    </div>
</div>

@endsection
