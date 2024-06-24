@extends('frontend.profile.dashboard')
@section('title', __('Mon programme fidélité') )


@section('dashboard-breadcrumb')
    <div style="margin-top: 60px;" class="mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Mon compte</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Mon programme fidélité</li>
            </ol>
        </nav>
    </div>
@endsection

@section('dashboard-content')
    <div class="text-end mb-4">
        <a class="hvr-grow-shadow btn btn-warning" href="{{ route('dashboard') }}"><i class="fa-solid fa-circle-left"></i> Retour</a>
    </div>

    <h2>Mon programme fidélité <i class="fa-solid fa-star"></i></h2>
    <p><b>Cumulez des points à chaque achat :</b> Chaque euro dépensé vous rapporte un point. Plus vous achetez, plus vous gagnez de points !</p>

    <div class="d-flex justify-content-center">
        <div class="card bg-gray w-50 text-center">
            <div class="card-body">
                @if($user->erp_loyalty_card)
                    <p><b>Carte n° :</b> {{ $user->erp_loyalty_card }}</p>
                    <h1> @if($user->erp_loyalty_points)
                            {{ $user->erp_loyalty_points }}
                        @else
                             0
                        @endif Points</h1>
                @else
                    <h2>Vous n'avez pas encore de carte</h2>
                    <i class="fa-solid fa-credit-card fa-4x m-3"></i>
                    <p>Rendez-vous en magasin afin d'en créer une</p>
                @endif
            </div>
        </div>
    </div>

    <h4><i class="fa-solid fa-gift"></i> Avantages :</h4>
    <p>
        <i class="fa-solid fa-caret-right"></i> À 300 points : 5% de réduction sur votre prochain achat.<br>
        <i class="fa-solid fa-caret-right"></i> À 500 points : 10% de réduction pour vous récompenser.<br>
        <i class="fa-solid fa-caret-right"></i> Et lorsque vous atteignez 1000 points, vous bénéficiez d’une réduction de 15% sur l’ensemble de nos produits et services !
    </p>

    <h4><i class="fa-solid fa-pen-to-square"></i> Comment ça marche ?</h4>
    <p>
        <i class="fa-solid fa-caret-right"></i>Créez votre compte client gratuitement et récuperez votre carte directement en magasin, connectez-vous pour rejoindre le programme de fidélité.<br>
        <i class="fa-solid fa-caret-right"></i>Cumulez des points à chaque achat et retrouvez-les dans votre compte client.<br>
        <i class="fa-solid fa-caret-right"></i>Vous recevrez un coupon de remise valable sur l’ensemble de nos produits.<br>
    </p>

    <h4>N’attendez plus, rejoignez notre programme de fidélité et profitez de ces avantages exclusifs ! <i class="fa-solid fa-heart"></i></h4>

@endsection
