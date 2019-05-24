<div class="main-nav flex justify-between items-center text-white h-16 h3 fixed pin-t w-full px-8">
        <a href="{{ localUrl("/") }}" class="no-font-space no-underline py-2">
            @if(app()->getLocale() === 'zh')
                @include('svgs.icons.logo_ch')
            @else
                @include('svgs.icons.logo_eng')
            @endif
        </a>
    <div class="flex justify-end items-center">
        <div class="subnav hidden md:flex items-center">
            <div class="relative services-link">
                <a class="text-white no-underline hover:text-orange-light md:mx-8" href="{{ localUrl("/services") }}">
                    {{ trans('navbar.services') }}</a>
                <div class="service-nav-outer pt-3 absolute w-80 pt-8">
                    <div class="bg-navy flex flex-col relative bg-navy shadow px-4">
                        <a class="no-underline flex items-center px-4 py-8 text-white hover:text-orange-light border-b border-pale-baby-blue" href="/en/services/audits">
                            @include('svgs.icons.audits_icon', ['classes' => 'w-6 mr-6'])
                            <span>Audits</span>
                        </a>
                        <a class="no-underline flex items-center px-4 py-8 text-white hover:text-orange-light border-b border-pale-baby-blue" href="/en/services/bookkeeping">
                            @include('svgs.icons.bookkeeping_icon', ['classes' => 'w-6 mr-6'])
                            <span>Bookkeeping</span>
                        </a>
                        <a class="no-underline flex items-center px-4 py-8 text-white hover:text-orange-light border-b border-pale-baby-blue" href="/en/services/business-assistance">
                            @include('svgs.icons.biz_reg_icon', ['classes' => 'w-6 mr-6'])
                            <span>Business Assistance</span>
                        </a>
                        <a class="no-underline flex items-center px-4 py-8 text-white hover:text-orange-light" href="/en/services/tax">
                            @include('svgs.icons.tax_icon', ['classes' => 'w-6 mr-6'])
                            <span>Tax</span>
                        </a>
                    </div>
                </div>
            </div>
            <a class="text-white no-underline hover:text-orange-light mr-8" href="{{ localUrl("/about") }}">{{ trans('navbar.about') }}</a>
            <a class="text-white no-underline hover:text-orange-light mr-8" href="{{ localUrl("/contact") }}">{{ trans('navbar.contact') }}</a>
            <a class="text-white no-underline hover:text-orange-light mr-8" href="{{ transUrl(request()->path()) }}">{{ trans('navbar.language') }}</a>
        </div>

        <div class="block md:hidden text-white hover:text-orange nav-trigger">
            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/></svg>
        </div>
    </div>
</div>