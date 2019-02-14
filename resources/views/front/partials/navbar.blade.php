<div class="h-12 flex justify-between items-center">
    <div>
        <a href="{{ localUrl("/") }}">Tino's</a>
    </div>
    <div class="flex justify-end items-center">
        <a href="{{ localUrl("/about") }}">{{ trans('navbar.about') }}</a>
        <a href="{{ localUrl("/services") }}">{{ trans('navbar.services') }}</a>
        <a href="{{ localUrl("/contact") }}">{{ trans('navbar.contact') }}</a>
        <a href="{{ transUrl(request()->path()) }}">{{ trans('navbar.language') }}</a>
    </div>
</div>