<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('backend.layouts.head')

<body id="page-top">

<div id="wrapper">
    @include('backend.layouts.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('backend.layouts.topbar')

            <div class="container-fluid">
                <h1 class="h3 m-4 text-gray-800">@yield('title')</h1>
                @include('backend.layouts.flash')

                @yield('main-content')
            </div>
        </div>

        @include('backend.layouts.footer')

    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

@include('backend.layouts.modal-logout')

@include('backend.layouts.script')
</body>
