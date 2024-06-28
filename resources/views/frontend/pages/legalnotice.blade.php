@extends('frontend.layouts.layout')
@section('title', __('Mentions légales') )

@section('main-content')

    <div style="margin-top: -15px;" class="mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-nav mt-5 p-3 custom-breadcrumb">
                <li class="breadcrumb-item">
                    <a class="link-dark" href="{{ route('index') }}">
                        <i class="fa-solid fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item active link-dark" aria-current="page">Mentions légales</li>
            </ol>
        </nav>
    </div>

    {!! $legalnotice->legalnotice !!}
@endsection
