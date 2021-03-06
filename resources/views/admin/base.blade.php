<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    @section('title')
        <title>CPA | Admin </title>
    @show
    <link rel="stylesheet"
          href="{{ mix('css/app.css') }}"/>
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
        @include('admin.partials.navbar')
    @else
        @include('admin.partials.fakenavbar')
    @endif
    <div class="container">
        @yield('content')
    </div>
    <notification-hub></notification-hub>
</div>

{{--<div class="main-footer"></div>--}}
<script src="{{ mix('js/app.js') }}"></script>
{{--@include('admin.partials.flash')--}}
@yield('bodyscripts')
@if(session()->has('flash-message'))
    <script>
        window.flashMessage = @json(session('flash-message'));
    </script>
@endif
</body>
</html>