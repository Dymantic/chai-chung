@extends('front.base', ['bodyClasses' => 'home'])

@section("title")
    {{ trans('home.seo.title') }}
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogTitle' => trans('home.seo.title'),
        'ogDescription' => trans('home.seo.description'),
    ])
@endsection

@section('content')
    @include('front.home.banner')
    @include('front.home.about')
    @include('front.home.services')
    @include('front.home.logos')
    @include('front.home.contact')
    @include('front.home.city-sketch')
    @include('front.partials.json-ld')
@endsection