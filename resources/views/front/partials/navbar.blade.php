<div class="main-nav flex justify-between items-center text-white h3 fixed pin-t w-full px-8">
        <a href="{{ localUrl("/") }}" class="no-font-space no-underline py-2">
            @if(app()->getLocale() === 'zh')
                @include('svgs.icons.logo_ch')
            @else
                @include('svgs.icons.logo_eng')
            @endif
        </a>
    <div class="flex justify-end items-center">
        <div class="relative services-link">
            <a class="text-white no-underline hover:text-orange-light mx-8" href="{{ localUrl("/services") }}">
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
                    <a class="no-underline flex items-center px-4 py-8 text-white hover:text-orange-light border-b border-pale-baby-blue" href="/en/services/business-registration">
                        @include('svgs.icons.biz_reg_icon', ['classes' => 'w-6 mr-6'])
                        <span>Business Registration</span>
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
</div>