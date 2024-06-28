<!-- Double Header -->
<header class="bg-light bg-opacity-75 text-white py-2">
    <div class="container">
        <div class="d-flex align-items-center">
            <a href="{{ route('index') }}" class="text-start">
                <img class="logo hvr-wobble-to-top-right" src="{{ asset('/frontend/images/logo/logo.png') }}"
                     alt="logo">
            </a>

            <form role="search" method="get" action="{{ route('search') }}" class="w-25 d-none d-lg-block mx-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher un produit..."
                           aria-label="Rechercher" aria-describedby="Rechercher">
                    <button class="btn btn-secondary" type="submit" id="Rechercher"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>

            <a href="" class="ms-auto btn link-white bg-dark bg-opacity-75 rounded-3 p-2 mx-2 d-none d-lg-block">
                Magasine & Blog
            </a>

            <a href="" class="btn link-white bg-dark bg-opacity-75 rounded-3 p-2 mx-2 d-none d-lg-block">
                Nos marques
            </a>

            @auth()
                <div>
                    @if(Route::currentRouteName() == 'cart.index' || Route::currentRouteName() == 'cart.chose_address' || Route::currentRouteName() == 'cart.chose_delivery' || Route::currentRouteName() == 'cart.summary')
                        <button class="btn p-2 me-3 btn-cart bg-dark bg-opacity-75 rounded-3 position-relative hvr-grow-shadow" type="button">
                            <i class="fa-solid fa-basket-shopping fa-xl text-white"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><span
                                    id="nb_produit">{{ \App\Http\Controllers\Frontend\ShoppingCart\CartController::count_product() }}</span> <span
                                    class="visually-hidden">Nombres de produits dans le panier</span></span>
                        </button>
                    @else
                        <button class="btn p-2  me-3 btn-cart bg-dark bg-opacity-75 rounded-3 position-relative hvr-grow-shadow" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#cart_modal" aria-controls="cart_modal">
                            <i class="fa-solid fa-basket-shopping fa-xl text-white"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><span
                                    id="nb_produit">{{ \App\Http\Controllers\Frontend\ShoppingCart\CartController::count_product() }}</span> <span
                                    class="visually-hidden">Nombres de produits dans le panier</span></span>
                        </button>
                    @endif
                </div>
            @endauth

            <div>
                        @if(Auth::guest())
                            <a class="btn btn-primary link-effect p-2 " aria-current="page" href="{{ route('dashboard') }}"> <i
                                    class="fa-solid fa-user fa-fw"></i> Mon compte</a>
                        @endif
                        @if(Auth::user())
                            <form method="POST" action="{{ route('logout') }}"> @csrf
                                <a class="btn btn-primary link-effect p-2 " aria-current="page" href="{{ route('dashboard') }}">
                                    <i class="fa-solid fa-user fa-fw"></i> Mon compte</a>
                                <button type="submit" class="btn btn-logout p-2 bg-dark bg-opacity-75 rounded-3 text-white" data-bs-toggle="tooltip"
                                        data-bs-custom-class="custom-tooltip"
                                        data-bs-placement="bottom" data-bs-title="{{ __('Log Out') }}"><i
                                        class="fa-solid fa-right-from-bracket fa-xl"></i></button>

                            </form>
                        @endif
                    </div>
        </div>
    </div>
</header>

<nav class="navbar navbar-expand-lg shadow-lg bg-primary-trans p-0" aria-label="Navbar">
    <div class="container">
        <p class="navbar-brand"></p>
        <button class="navbar-toggler p-3 text-white" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="offcanvas offcanvas-end  overflow-auto" tabindex="-1" id="offcanvasNavbar2"
             aria-labelledby="offcanvasNavbar2Label">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbar2Label">
                    <img class="img-fluid" src="{{ asset('/frontend/images/logo/logo.png') }}" alt="logo">
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav me-auto">
                    @foreach($menu_produits as $category)
                        @if((count($category->childrenCategories) > 0))
                            <li class="nav-item dropdown dropdown-mega position-static w-lg-100">
                                <a class="nav-link dropdown-toggle p-3" href="#" data-bs-toggle="dropdown"
                                   data-bs-auto-close="outside">{{ $category->name }}</a>
                                <div class="dropdown-menu shadow bg-opacity-75">
                                    <div class="mega-content px-4">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <ul class="nav flex-column nav-pills nav-pills-custom" id="myTab"
                                                        role="tablist">
                                                        @foreach($category->childrenCategories as $index => $childrenCategories)
                                                            <li class="nav-item" role="presentation">
                                                                <button
                                                                    class="nav-link w-100 p-4 mb-2 {{ $loop->first ? 'active' : '' }}"
                                                                    id="tab{{ $childrenCategories->id }}"
                                                                    data-bs-toggle="tab"
                                                                    data-bs-target="#tab{{ $childrenCategories->id }}-pane"
                                                                    type="button" role="tab"
                                                                    aria-controls="tab{{ $childrenCategories->id }}-pane"
                                                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $childrenCategories->name }}</button>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="tab-content" id="myTabContent">
                                                        @foreach($category->childrenCategories as $index => $childrenCategories)
                                                            <div
                                                                class="tab-pane fade show {{ $loop->first ? 'active' : '' }}"
                                                                id="tab{{ $childrenCategories->id }}-pane"
                                                                role="tabpanel"
                                                                aria-labelledby="tab{{ $childrenCategories->id }}"
                                                                tabindex="0">
                                                                <div class="row">
                                                                    @foreach($childrenCategories->childrenCategories as $childrenCategories)
                                                                        <div class="col-12 col-md-12 col-lg-2 col-xl-2">
                                                                            <h4 class="mt-2 mb-3"><a class="link-dark"
                                                                                                     href="/nos-produits/{{ $childrenCategories->slug }}">{{ $childrenCategories->name }}</a>
                                                                            </h4>
                                                                            @foreach($childrenCategories->childrenCategories as $childrenCategories)
                                                                                <a class="link-dark ps-3"
                                                                                   href="/nos-produits/{{ $childrenCategories->slug }}">
                                                                                    <i class="fa-solid fa-arrow-right"></i> {{ $childrenCategories->name }}
                                                                                </a><br>
                                                                            @endforeach
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @else
                            <li class="nav-item w-lg-100"><a href="/nos-produits/{{ $category->slug }}"
                                                    class="nav-link p-3">{{ $category->name }}</a></li>
                        @endif
                    @endforeach

                </ul>
                <ul class="nav">
                    <li class="nav-item w-lg-100"><a href="#" class="nav-link p-3">Promos / Bon plans</a></li>
                </ul>

            </div>
        </div>
    </div>
</nav>
@auth()
    @if(Route::currentRouteName() != 'cart.index' || Route::currentRouteName() != 'cart.chose_address' || Route::currentRouteName() != 'cart.chose_delivery' || Route::currentRouteName() != 'cart.summary')
        @include('frontend.layouts.partials.cart_modal')
    @endif
@endauth
