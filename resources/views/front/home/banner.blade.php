<section class="banner home-banner flex flex-col justify-center items-start relative bg-navy overflow-hidden">
    <picture>
        <source srcset="/images/home/city_white.jpg"
                media="(min-width: 1201px)">
        <source srcset="/images/home/city_white_narrow.jpg"
                media="(max-width: 1200px)">
        <img class="absolute pin white-lights hidden md:block" src="/images/home/city_white_narrow.jpg" />
    </picture>
    <picture>
        <source srcset="/images/home/city_orange.jpg"
                media="(min-width: 1201px)">
        <source srcset="/images/home/city_orange_narrow.jpg"
                media="(max-width: 1200px)">
        <img class="absolute pin orange-lights opacity-0 hidden md:block" src="/images/home/city_orange_narrow.jpg" />
    </picture>

    <div class="banner-text-block w-lg max-w-90 py-8 px-4 lg:pl-8 lg:pr-24 lg:py-12 bg-baby-blue-opq my-20 mt-32 mx-auto lg:ml-40 relative opacity-0">
        <p class="banner-text leading-tight text-navy max-w-narrow pl-8">{{ trans('home.banner.content') }}</p>
    </div>
</section>