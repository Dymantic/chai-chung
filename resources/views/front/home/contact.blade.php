<section class="reg-section-space">
    @component('front.components.soft-card', ['usher' => true])
            <p class="h2 text-orange">{{ trans('home.contact.heading') }}</p>
            <p class="mt-8 leading-loose">{{ trans('home.contact.content') }}</p>
            <a class="btn-type-1 text-center text-navy hover:text-navy-light no-underline mt-12 block"
               href="{{ localUrl("/contact") }}">{!! trans('home.contact.link') !!}</a>
    @endcomponent
</section>