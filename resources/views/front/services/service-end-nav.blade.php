<section class="reg-section-space flex flex-col items-center">
    <a href="{{ localUrl('/contact') }}"
       class="btn btn-orange">
        @include('front.partials.rarr-span', ['text' => trans('services.end-nav.links.contact')])
    </a>
    <a href="{{ localUrl('/services') }}"
       class="text-link text-navy hover:text-bright-blue mt-12">
        @include('front.partials.larr-span', ['text' => trans('services.end-nav.links.back')])
    </a>
</section>