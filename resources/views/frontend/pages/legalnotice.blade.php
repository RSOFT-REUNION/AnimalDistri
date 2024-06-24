@extends('frontend.layouts.layout')
@section('title', __('Mentions légales') )

@section('main-content')

    <div style="margin-top: 60px;" class="mb-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 rounded-3 shadow">
                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa-solid fa-home"></i></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Mentions légales</li>
            </ol>
        </nav>
    </div>

    {!! $legalnotice->legalnotice !!}
@endsection
