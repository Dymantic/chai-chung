@extends('front.base', ['bodyClasses' => 'home'])

@section('content')
    @include('front.home.banner')
    @include('front.home.about')
    @include('front.home.services')
    @include('front.home.logos')
    @include('front.home.contact')
    @include('front.home.city-sketch')

@endsection