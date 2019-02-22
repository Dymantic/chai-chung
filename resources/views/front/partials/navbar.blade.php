<div class="main-nav flex justify-between items-center bg-navy-opq text-white h3 fixed pin-t w-full px-8">
        <a href="{{ localUrl("/") }}" class="no-font-space no-underline py-2">
            @if(app()->getLocale() === 'zh')
                @include('svgs.icons.logo_ch')
            @else
                @include('svgs.icons.logo_eng')
            @endif
        </a>
    <div class="flex justify-end items-center">
        <a class="text-white no-underline hover:text-orange-light mr-8" href="{{ localUrl("/about") }}">{{ trans('navbar.about') }}</a>
        <a class="text-white no-underline hover:text-orange-light mr-8" href="{{ localUrl("/services") }}">{{ trans('navbar.services') }}</a>
        <a class="text-white no-underline hover:text-orange-light mr-8" href="{{ localUrl("/contact") }}">{{ trans('navbar.contact') }}</a>
        <a class="text-white no-underline hover:text-orange-light mr-8" href="{{ transUrl(request()->path()) }}">{{ trans('navbar.language') }}</a>
    </div>
</div>