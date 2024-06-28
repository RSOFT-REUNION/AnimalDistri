@extends('frontend.layouts.layout')
@section('title', __('Mon Compte') )

@section('main-content')

    @yield('dashboard-breadcrumb')

    <div class="row">
        <div class="col-md-3 col-12 mb-4">
            <div class="card bg-gray rounded-4">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fa-solid fa-user-tie fa-4x mb-3"></i>
                        <h2>Bonjour</h2>
                        <h3>{{ Auth::user()->name }}</h3>
                        <form method="POST" action="{{ route('logout') }}"> @csrf <button class="btn btn-danger btn-logout mt-2 mb-2 hvr-grow-shadow"><i class="fa-solid fa-right-from-bracket"></i> {{ __('Log Out') }}</button> </form>
                    </div>

                    <nav class="nav flex-column text-center">
                        <a class="hvr-grow-shadow btn @if(\Illuminate\Support\Facades\Route::is('info.edit')) btn-secondary @else btn-outline-secondary @endif  mb-2" href="{{ route('info.edit') }}"><i class="fa-solid fa-circle-info"></i> Mes informations</a>
                        <a class="hvr-grow-shadow btn @if(\Illuminate\Support\Facades\Route::is('orders.show')) btn-secondary @else btn-outline-secondary @endif mb-2" href="{{ route('orders.show') }}"><i class="fa-solid fa-basket-shopping"></i> Mes commandes</a>
                        <a class="hvr-grow-shadow btn @if(\Illuminate\Support\Facades\Route::is('address.index')) btn-secondary @else btn-outline-secondary @endif mb-2" href="{{ route('address.index') }}"><i class="fa-solid fa-address-card"></i> Mes adresses</a>
                    </nav>
                </div>
            </div>

        </div>
        <div class="col-md-9 col-12">
            @yield('dashboard-content')
        </div>
    </div>

@endsection
