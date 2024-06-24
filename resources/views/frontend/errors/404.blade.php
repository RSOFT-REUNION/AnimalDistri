@extends('frontend.layouts.layout')
@section('title', __('Erreur 404') )

@section('main-content')
    <section class="inner-page">
        <div class="container">
            <h1>Page non trouvée</h1>
            <h5 class="mb-5">Erreur 404</h5>

            <h2 class="mb-5">La page que vous cherchez est introuvable. Excusez-nous pour la gêne occasionnée.</h2>
            <p class="mb-5">Si vous avez saisi l’adresse web dans le navigateur, vérifiez qu’elle est correcte.
                La page n’est peut-être plus disponible. <br>
                Dans ce cas, pour poursuivre votre visite, vous pouvez consulter notre page d’accueil.</p>

            <div class="text-center">
                <a href="{{ route('index') }}" type="button"
                   class="btn btn-lg btn-primary hvr-grow-shadow mb-5 text-center"><i class="fa-solid fa-house"></i>
                    Page d'accueil</a>

            </div>
        </div>
    </section>

@endsection
