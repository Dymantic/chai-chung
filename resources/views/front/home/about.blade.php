<section class="reg-section-space" data-usher>
    <div class="max-w-md mx-auto">
        <p class="h2 text-orange">{{ trans('home.about.heading') }}</p>
        <p class="mt-8 leading-loose">{{ trans('home.about.content') }}</p>
        <a class="btn-type-1 text-center text-navy hover:text-bright-blue no-underline mt-12 block"
           href="{{ localUrl("/about") }}">
            @include('front.partials.rarr-span', ['text' => trans('home.about.link')])
        </a>
    </div>
    <div class="max-w-md mx-auto mt-20">
        <p class="h2 text-orange">{{ trans('home.services.heading') }}</p>
        <p class="mt-8 leading-loose">{{ trans('home.services.content') }}</p>
        <a class="btn-type-1 text-center text-navy hover:text-bright-blue no-underline mt-12 block"
           href="{{ localUrl("/services") }}">
            @include('front.partials.rarr-span', ['text' => trans('home.services.link')])</a>
    </div>
</section>