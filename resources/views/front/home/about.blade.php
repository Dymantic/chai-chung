<section class="reg-section-space" data-usher>
    <div class="max-w-md mx-auto">
        <p class="h2 text-orange">{{ trans('home.about.heading') }}</p>
        <p class="mt-8 leading-loose">{{ trans('home.about.content') }}</p>
        <a class="btn-type-1 text-center text-navy hover:text-navy-light no-underline mt-12 block"
           href="{{ localUrl("/about") }}">{!!  trans('home.about.link')  !!}</a>
    </div>
    <div class="max-w-md mx-auto mt-20">
        <p class="h2 text-orange">{{ trans('home.services.heading') }}</p>
        <p class="mt-8 leading-loose">{{ trans('home.services.content') }}</p>
        <a class="btn-type-1 text-center text-navy hover:text-navy-light no-underline mt-12 block"
           href="{{ localUrl("/services") }}">{!! trans('home.services.link')  !!}</a>
    </div>
</section>