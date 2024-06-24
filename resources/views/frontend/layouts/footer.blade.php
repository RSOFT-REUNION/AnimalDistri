<footer class="mt-5" id="footer" data-aos="fade-right" data-aos-duration="400">

    <div class="footer-top p-5">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-4 col-12">
                    <img class="img-fluid" src="{{ asset('/frontend/images/logo/logo_blanc.png') }}" alt="logo">
                </div>

                <div class="col-lg-4 col-md-4 col-12  text-center">
                    <h2 class="whitecolor">Saint-Pierre</h2>
                    <div class="whitecolor">{!! $infos->address !!}</div>
                    <div class="whitecolor m-2"><a href="tel:{{ $infos->phone }}"  class="text-decoration-none" ><i class="fa-solid fa-phone"></i> {{ $infos->phone }}</a></div>
                    <div class="whitecolor m-2"><a href="mailto:"  class="text-decoration-none" ><i class="fa-solid fa-envelope"></i> {{ $infos->email }}</a></div>
                </div>

                <div class="col-lg-4 col-md-4 col-12 text-center">
                    <h2 class="whitecolor">Informations</h2>
                    <ul style="list-style: none;" class="p-0 m-0">
                        <li class="m-3"><a class="text-decoration-none" href="/nos-magasins">Nos magasins</a></li>
                        <li class="m-3"><a class="text-decoration-none" href="{{ route('legalnotice') }}">Mentions légales</a></li>
                        <li class="m-3"><a class="text-decoration-none" href="{{ route('termsofservice') }}">Conditions générales d'utilisation</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom clearfix p-3">
        <div class="container">
            <div class="d-flex mb-3">
                <div class="me-auto p-2">&copy; 2023 - {{ now()->year }} | RCMS | Développé par <strong><a href="http://www.rsoft.re/" target="_blank" class="text-decoration-none blackcolor">RSOFT RÉUNION</a></strong></div>
                <div>
                    <a href="" target="_blank" class="me-2 hvr-float-shadow blackcolor"><i class="fa-brands fa-linkedin fa-2x"></i></a>
                    <a href="" target="_blank" class="me-2 hvr-float-shadow blackcolor"><i class="fa-brands fa-instagram fa-2x"></i></a>
                    <a href="" target="_blank" class="hvr-float-shadow blackcolor"><i class="fa-brands fa-square-facebook fa-2x"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
