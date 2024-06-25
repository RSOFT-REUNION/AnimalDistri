<footer class="mt-5 bg-light shadow-top" id="footer" data-aos="fade-right" data-aos-duration="400">
    <div class="footer-top">
        <div class="container pt-3">
            <div class="row  align-items-center">

                <div class="col-lg-4 col-md-4 col-12 text-center">
                    <img class="w-50" src="{{ asset('/frontend/images/logo/logo.png') }}" alt="logo">
                    <p class="mt-3">Animal Distri a pour activité principale: grossiste pour
                        produits animaliers domestiques. Elle propose à la vente
                        des accessoires et de l’alimentation pour animaux
                        domestiques.</p>
                </div>

                <div class="col-lg-4 col-md-4 col-12 contact">
                    <div class="d-flex justify-content-center">
                        <div class="info w-50">
                            <div class="address mb-4">
                                <i class="fa-solid fa-location-dot me-3"></i>
                                <p class="m-0"><b>Adresse</b></p>
                                <p>{!! $infos->address !!}</p>
                            </div>

                            <div class="phone mb-4">
                                <i class="fa-solid fa-phone me-3"></i>
                                <p class="m-0"><b>Contactez-nous</b></p>
                                <p>{{ $infos->phone }}</p>
                            </div>

                            <div class="email mb-4">
                                <i class="fa-regular fa-envelope me-3"></i>
                                <p class="m-0"><b>Adresse E-mail</b></p>
                                <p>{{ $infos->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12 text-center">
                    <div id="fb-root"></div>
                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v20.0" nonce="Eh5WeaT4"></script>
                    <div class="fb-page"
                         data-href="https://www.facebook.com/animal.distri.sas/"
                         data-width="380"
                         data-hide-cover="false"
                         data-show-facepile="false"></div>
                </div>

            </div>

            <div class="p-3 text-center">
                <hr>
                <a class="text-decoration-none blackcolor" href="{{ route('legalnotice') }}">Mentions légales</a> | <a class="text-decoration-none blackcolor" href="{{ route('termsofservice') }}">Conditions générales de ventes</a> | <a class="text-decoration-none blackcolor" href="{{ route('termsofservice') }}">A propos de nous</a>
            </div>

        </div>
    </div>

    <div class="footer-bottom clearfix bg-primary p-2">
        <div class="container">
            <div class="d-flex align-items-center">
                <div class="me-auto p-2 text-white">&copy; {{ now()->year }} | Animal Distri | Développé par <strong><a href="http://www.rsoft.re/" target="_blank" class="text-decoration-none link-dark">RSOFT RÉUNION</a></strong></div>
                <div>
                    <i class="fa-brands fa-cc-mastercard text-white me-2 fa-xl"></i> <i class="fa-brands fa-cc-visa text-white fa-xl"></i>
                </div>
            </div>
        </div>
    </div>
</footer>
