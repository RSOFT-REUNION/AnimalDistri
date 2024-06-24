@extends('frontend.layouts.layout')
@section('title', __('Conditions générales d\'utilisation') )

@section('main-content')

    <div style="margin-top: 60px;" class="mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Conditions générales d'utilisation</li>
            </ol>
        </nav>
    </div>

    {!! $termsofservice->termsofservice !!}
@endsection
