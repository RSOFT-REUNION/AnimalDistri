<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Annimal Distri Réunion">
    <meta name="author" content="RsoftCMS">

    <title>@yield('title') | Annimal Distri Réunion</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico"/>

    @include('frontend.layouts.style')
</head>

<body>
@include('frontend.layouts.header')

@if(Route::is('index'))
    <div style="margin-top: -16px;">
        @include('frontend.layouts.slider')
    </div>
@endif

<main id="main">
    <div class="container">
        @include('frontend.layouts.flash')
        @yield('main-content')
    </div>
</main>

@include('frontend.layouts.footer')
<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center text-decoration-none"><i
        class="fa-duotone fa-arrow-up fa-fw"></i></a>
<div id="flashMessage">&nbsp;</div>

@include('frontend.layouts.script')
</body>
