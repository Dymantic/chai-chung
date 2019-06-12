<footer class="bg-navy pt-12">
    <div class="flex justify-center mb-6">
        @if(app()->getLocale() === 'zh')
            @include('svgs.icons.logo_ch')
        @else
            @include('svgs.icons.logo_eng')
        @endif
    </div>
    <div class="max-w-xl mx-auto flex flex-col md:flex-row justify-between">
        <div class="flex flex-col items-center">
            <a class="text-mid-grey hover:text-orange-light no-underline" href="{{ localUrl('/services/audits') }}">{{ trans('footer.nav.audits') }}</a>
            <a class="text-mid-grey hover:text-orange-light no-underline" href="{{ localUrl('/services/bookkeeping') }}">{{ trans('footer.nav.bookkeeping') }}</a>
            <a class="text-mid-grey hover:text-orange-light no-underline" href="{{ localUrl('/services/tax') }}">{{ trans('footer.nav.tax') }}</a>
            <a class="text-mid-grey hover:text-orange-light no-underline" href="{{ localUrl('/services/business-assistance') }}">{{ trans('footer.nav.business_registration') }}</a>
            <a class="text-mid-grey hover:text-orange-light no-underline" href="{{ localUrl('/about#carreers') }}">{{ trans('footer.nav.careers') }}</a>
        </div>
        <div class="flex flex-col items-center md:items-start my-12 md:my-0">
            <p class="text-mid-grey">{{ trans('footer.contact_info.phone') }}</p>
            <p class="text-mid-grey">{{ trans('footer.contact_info.fax') }}</p>
            <p class="text-mid-grey">{{ trans('footer.contact_info.email') }}</p>
            <p class="text-mid-grey">{{ trans('footer.contact_info.address_line_one') }}</p>
            <p class="text-mid-grey">{{ trans('footer.contact_info.address_line_two') }}</p>
        </div>
    </div>
    <div>
        <div class="text-white text-center flex justify-center">
            <a href="#" data-jump class="flex items-center flex-col no-underline text-mid-grey hover:text-orange-light">
                @include('svgs.icons.top_arrow', ['classes' => 'h-3 mb-2'])
                <p class="h3">{{ trans('footer.top') }}</p>
            </a>
        </div>
    </div>
    <p class="text-sm text-mid-grey text-center mt-8 pb-2">&copy; {{ \Illuminate\Support\Carbon::now()->year }}. Beautifully built by <a href="" class="text-mid-grey hover:text-orange no-underline">Dymantic Design</a></p>
</footer>