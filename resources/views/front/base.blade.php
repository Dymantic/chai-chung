<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">

<head>
    <META NAME="ROBOTS"
          CONTENT="NOINDEX, NOFOLLOW">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'CPA')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="alternate" hreflang="{{ app()->getLocale() === 'en' ? 'zh' : 'en' }}" href="{{ url(transUrl(Request::path())) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(app()->getLocale() === 'en')
    <link rel="stylesheet" href="https://use.typekit.net/zbv2jka.css">
    @else
        <script>
            (function(d) {
                var config = {
                        kitId: 'rpz0mug',
                        scriptTimeout: 3000,
                        async: true
                    },
                    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
            })(document);
        </script>
    @endif

    <link rel="stylesheet" href="{{ mix('css/front.css') }}">

    @yield('head')
</head>

<body class="body-text leading-relaxed {{ $bodyClasses ?? '' }}">
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
<div id="app">
    @yield('content')
    @include('front.partials.footer')
    @include('front.partials.navbar')
</div>
@yield('bodyscripts')
<script src="{{ mix("js/front.js") }}"></script>
<script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto'); ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>
</body>

</html>