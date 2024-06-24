@extends('frontend.layouts.layout')

@section('title', $page->title)

@section('main-content')
        <section class="inner-page">
            <div class="container">
                {!! $page->content !!}
            </div>
        </section>
@endsection
