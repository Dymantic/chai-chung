<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1 shrink-to-fit=no">
    @section('title')
        <title>Loherb | Admin </title>
    @show
    {{--<link rel="stylesheet"--}}
          {{--href="{{ mix('css/app.css') }}"/>--}}
    <meta id="csrf-token-meta"
          name="csrf-token"
          content="{{ csrf_token() }}">
    <META NAME="ROBOTS"
          CONTENT="NOINDEX, NOFOLLOW">
    @yield('head')
</head>
<body class="{{ $pageClasses ?? '' }} text-black font-sans">
<div id="app">
    @if(Auth::check())
        @include('partials.navbar')
    @else
        {{--@include('partials.fakenavbar')--}}
    @endif
    <div class="container">
        @yield('content')
    </div>
</div>

{{--<div class="main-footer"></div>--}}
{{--<script src="{{ mix('js/app.js') }}"></script>--}}
{{--@include('admin.partials.flash')--}}
@yield('bodyscripts')
</body>
</html>