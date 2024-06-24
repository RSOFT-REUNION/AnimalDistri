<nav class="navbar navbar-expand-lg fixed-top shadow-lg" aria-label="Augur Navbar"  style="border-top: #07139c 10px solid; background-color: #ffffff;">
    <div class="container pt-3">
        <a class="navbar-brand" href="{{ route('index') }}"><img class="logo hvr-wobble-to-bottom-right" src="{{ asset('/frontend/images/logo/logo.png') }}" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbar2Label"><img class="img-fluid" src="{{ asset('/frontend/images/logo/logo.png') }}" alt="logo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link {{ Nav::isRoute('index') }}" aria-current="page" href="{{ route('index') }}">Accueil</a>
                    </li>

                    <!--- Menu des produits -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ route('product.first_category_list') }}">Nos Produits</a>
                        <ul class="dropdown-menu">
                            @foreach($menu_produits as $category)
                                <li><a class="dropdown-item" href="/nos-produits/{{ $category->slug }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Nav::isRoute('contact') }}" aria-current="page" href="{{ route('contact') }}">Contact</a>
                    </li>

                    <li class="nav-item me-2">
                        <form role="search" method="get" action="{{ route('search') }}">
                            <div class="input-group mb-3">
                                <input type="text" style="width: 100px;" class="form-control" placeholder="Rechercher" aria-label="Rechercher" aria-describedby="Rechercher">
                                <button class="btn btn-secondary" type="submit" id="Rechercher"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </li>

                    @if(Auth::guest())
                        <li class="nav-item me-2 mb-3">
                            <a class="btn btn-primary hvr-grow-shadow" aria-current="page" href="{{ route('dashboard') }}"> <i class="fa-duotone fa-user fa-fw"></i> Mon compte</a>
                        </li>
                    @endif
                    @if(Auth::user())
                        <li class="nav-item me-2 mb-3">
                            <form method="POST" action="{{ route('logout') }}"> @csrf
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a type="button" href="{{ route('dashboard') }}" class="btn btn-primary"><i class="fa-duotone fa-user fa-fw"></i> Mon compte</a>
                                    <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="bottom" data-bs-title="{{ __('Log Out') }}"><i class="fa-solid fa-right-from-bracket"></i></button>
                                </div>
                            </form>

                        </li>
                    @endif
                    <li class="nav-item mb-3">
                        @if(Route::currentRouteName() == 'cart.chose_address' || Route::currentRouteName() == 'cart.chose_delivery' || Route::currentRouteName() == 'cart.summary')
                            <button class="btn btn-warning hvr-shrink" type="button">
                                <span>Mon panier</span> <i class="fa-duotone fa-cart-shopping"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><span id="nb_produit">{{ \App\Http\Controllers\Frontend\ShoppingCart\CartController::count_product() }}</span> <span class="visually-hidden">Nombres de produits dans le panier</span></span>
                            </button>
                        @else
                            <button class="btn btn-warning hvr-grow-shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#cart_modal" aria-controls="cart_modal">
                                <span>Mon panier</span> <i class="fa-duotone fa-cart-shopping"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><span id="nb_produit">{{ \App\Http\Controllers\Frontend\ShoppingCart\CartController::count_product() }}</span> <span class="visually-hidden">Nombres de produits dans le panier</span></span>
                            </button>
                        @endif
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>
@include('frontend.layouts.partials.cart_modal')
