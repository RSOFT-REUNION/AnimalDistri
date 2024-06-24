<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('backend.dashboard') }}">
        <div style="width: 80%">
            <img class="w-100 hvr-grow-rotate shadow rounded-bottom-4 backgroundwhite" src="{{ asset('backend/img/logo.png') }}">
        </div>
    </a>
    <!-- Dashboard -->
    <li class="mt-4 nav-item {{ Nav::isRoute('backend.dashboard') }}">
        <a class="nav-link" href="{{ route('backend.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>
    <hr class="sidebar-divider">

    <!-- Contenu -->
    @canany(filtrerPermission('content'))
        <li class="nav-item {{ Nav::isResource('contenu') }}">
            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#contenu" aria-expanded="false" aria-controls="collapseTwo">
                <i class="fa-solid fa-folder-grid"></i>
                <span>Contenu</span>
            </a>
            <div id="contenu" class="collapse {{ Nav::isResource('contenu', 'admin', $activeClass = "show") }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @canany(filtrerPermission('content.pages'))
                        <a class="collapse-item {{ Nav::urlDoesContain('contenu/pages') }}" href="{{ route('backend.content.pages.index') }}"><i class="fa-solid fa-memo"></i> Pages</a>
                    @endcanany
                    @canany(filtrerPermission('content.categories'))
                        <a class="collapse-item {{ Nav::urlDoesContain('contenu/categories') }}" href="{{ route('backend.content.categories.index') }}"><i class="fa-solid fa-list"></i> Catégories</a>
                    @endcanany
                    @canany(filtrerPermission('content.carousel'))
                        <a class="collapse-item {{ Nav::urlDoesContain('contenu/carrousel') }}" href="{{ route('backend.content.carrousel.index') }}"><i class="fa-solid fa-presentation-screen"></i> Carrousel</a>
                    @endcanany

                </div>
            </div>
        </li>
    @endcanany

    <!-- Commandes -->
    @canany(filtrerPermission('orders'))
        <li class="nav-item {{ Nav::isResource('commandes') }}">
            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#commandes"
               aria-expanded="false" aria-controls="collapseTwo">
                <i class="fa-solid fa-shopping-basket"></i>
                <span>Commandes</span>
            </a>
            <div id="commandes" class="collapse  {{ Nav::isResource('commandes', 'admin', $activeClass = "show") }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @canany(filtrerPermission('orders.orders'))
                        <a class="collapse-item {{ Nav::urlDoesContain('commandes/orders') }}" href="{{ route('backend.orders.orders.index') }}"><i
                                class="fa-solid fa-memo"></i> Suivi des commandes</a>
                    @endcanany
                    @canany(filtrerPermission('orders.invoices'))
                            <a class="collapse-item" href="{{ route('backend.orders.invoices.index') }}"><i
                                    class="fa-solid fa-paper"></i> Factures</a>
                    @endcanany
                        @canany(filtrerPermission('orders.delivery'))
                            <a class="collapse-item  {{ Nav::urlDoesContain('commandes/delivery') }}" href="{{ route('backend.orders.delivery.index') }}"><i class="fa-solid fa-truck"></i> Livraison</a>
                        @endcanany
                </div>
            </div>
        </li>
    @endcanany

    <!-- Catalogue -->
    @canany(filtrerPermission('catalog'))
        <li class="nav-item {{ Nav::isResource('catalogue') }}">
            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#catalogue" aria-expanded="false" aria-controls="collapseTwo">
                <i class="fa-solid fa-shop"></i>
                <span>Catalogue</span>
            </a>
            <div id="catalogue" class="collapse {{ Nav::isResource('catalogue', 'admin', $activeClass = "show") }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @canany(filtrerPermission('catalog.products'))
                        <a class="collapse-item {{ Nav::urlDoesContain('catalogue/products') }}" href="{{ route('backend.catalog.products.index') }}"><i class="fa-solid fa-cubes-stacked"></i> Produits</a>
                    @endcanany
                    @canany(filtrerPermission('catalog.categories'))
                        <a class="collapse-item {{ Nav::urlDoesContain('catalogue/categories') }}" href="{{ route('backend.catalog.categories.index') }}"><i class="fa-solid fa-layer-group"></i> Catégories</a>
                    @endcanany
                    @canany(filtrerPermission('catalog.shops'))
                        <a class="collapse-item {{ Nav::urlDoesContain('catalogue/shops') }}" href="{{ route('backend.catalog.shops.index') }}"><i class="fa-solid fa-store"></i> Magasins</a>
                    @endcanany
                    @canany(filtrerPermission('catalog.brands'))
                        <a class="collapse-item {{ Nav::urlDoesContain('catalogue/brands') }}" href="{{ route('backend.catalog.brands.index') }}"><i class="fa-solid fa-crown"></i> Marques & Fournisseurs</a>
                    @endcanany
                        @canany(filtrerPermission('catalog.discounts'))
                            <a class="collapse-item {{ Nav::urlDoesContain('catalogue/discounts') }}" href="{{ route('backend.catalog.discounts.index') }}"><i class="fa-solid fa-badge-percent"></i> Promotions</a>
                        @endcanany
                </div>
            </div>
        </li>
    @endcanany

    <!-- Clients -->
    @canany(filtrerPermission('clients'))
        <li class="nav-item {{ Nav::isResource('clients') }}">
            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#clients" aria-expanded="false" aria-controls="collapseTwo">
                <i class="fa-solid fa-users"></i>
                <span>Clients</span>
            </a>
            <div id="clients" class="collapse {{ Nav::isResource('clients', 'admin', $activeClass = "show") }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @canany(filtrerPermission('clients.client'))
                        <a class="collapse-item {{ Nav::urlDoesContain('clients/client') }}" href="{{ route('backend.clients.client.index') }}" aria-expanded="false"><i class="fa-solid fa-user"></i><span> Clients </span></a>
                    @endcanany
                    @canany(filtrerPermission('clients.carts'))
                        <a class="collapse-item {{ Nav::urlDoesContain('clients/paniers') }}" href="{{ route('backend.clients.carts.index') }}" aria-expanded="false"><i class="fa-solid fa-cart-shopping"></i><span> Paniers </span></a>
                    @endcanany
                </div>
            </div>
        </li>
    @endcanany

    <!-- Settings -->
    @canany(filtrerPermission('settings'))
        <li class="nav-item {{ Nav::isResource('parametres') }}">
            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#settings" aria-expanded="false" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Paramètres</span>
            </a>
            <div id="settings" class="collapse {{ Nav::isResource('parametres', 'admin', $activeClass = "show") }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @canany(filtrerPermission('settings.teams'))
                        <a class="collapse-item {{ Nav::urlDoesContain('parametres/equipes') }}" href="{{ route('backend.settings.teams.index') }}"><i class="fa-duotone fa-users"></i> Equipes</a>
                    @endcanany
                    @canany(filtrerPermission('settings.information'))
                        <a class="collapse-item {{ Nav::urlDoesContain('parametres/informations') }}" href="{{ route('backend.settings.informations.index') }}"><i class="fa-solid fa-circle-info"></i> Informations de contact</a>
                        <a class="collapse-item {{ Nav::urlDoesContain('parametres/mentions-legales') }}" href="{{ route('backend.settings.legalnotice.index') }}"><i class="fa-solid fa-memo-circle-info"></i> Mentions légales</a>
                        <a class="collapse-item {{ Nav::urlDoesContain('parametres/conditions-generales-dutilisation') }}" href="{{ route('backend.settings.termsofservice.index') }}"><i class="fa-solid fa-users-rectangle"></i> Conditions générales d'utilisation</a>
                    @endcanany
                </div>
            </div>
        </li>
    @endcanany
</ul>
