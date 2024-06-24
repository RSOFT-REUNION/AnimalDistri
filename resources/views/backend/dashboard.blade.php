@extends('backend.layouts.layout')
@section('title', __('Dashboard') )

@section('main-content')
	<div class="text-center mb-5">
        <img class="w-25" src="{{ asset('backend/img/logo-ent.png') }}">
    </div>

    <div class="row">
        <!-- Pages -->
        <div class="col-xl-4 col-md-6 mb-4">
            <a class="text-decoration-none" href="{{ route('backend.content.pages.index') }}">
                <div class="card border-left-primary shadow w-100 py-2 hvr-bob">
                    <div class="card-body ps-5 pe-5">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Nombre de pages
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pages }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-memo fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Catégories -->
        <div class="col-xl-4 col-md-6 mb-4">
            <a class="text-decoration-none" href="{{ route('backend.content.categories.index') }}">
                <div class="card border-left-warning shadow w-100 py-2 hvr-bob">
                    <div class="card-body ps-5 pe-5">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Nombre de
                                    Catégories
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $category  }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Carrousel -->
        <div class="col-xl-4 col-md-6 mb-4">
            <a class="text-decoration-none" href="{{ route('backend.content.carrousel.index') }}">
                <div class="card border-left-success shadow w-100 py-2 hvr-bob">
                    <div class="card-body ps-5 pe-5">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Nombre d'images
                                    du carrousel
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $carousel }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-presentation-screen fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>

@endsection
