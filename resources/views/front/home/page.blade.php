@extends('front.base', ['bodyClasses' => 'home'])

@section('content')
    <section class="banner home-banner flex flex-col justify-center items-start relative bg-navy">
        <img src="/images/home/homepage_banner_4_white.jpg"
             alt=""
             class="absolute pin white-lights">
        <img src=""
             alt=""
             class="absolute pin orange-lights opacity-0"
             data-src="/images/home/homepage_banner_3_orange.jpg">
        <div class="max-w-md pl-8 pr-24 py-12 bg-baby-blue-opq ml-40 relative">
            <p class="h1 text-navy max-w-narrow pl-8">{{ trans('home.banner.content') }}</p>
        </div>
    </section>
    <section class="reg-section-space">
        <div class="max-w-md mx-auto">
            <p class="h2 text-orange">{{ trans('home.about.heading') }}</p>
            <p class="mt-8 leading-loose">{{ trans('home.about.content') }}</p>
            <a class="btn-type-1 text-center text-navy no-underline mt-12 block"
               href="{{ localUrl("/about") }}">{!!  trans('home.about.link')  !!}</a>
        </div>
        <div class="max-w-md mx-auto mt-20">
            <p class="h2 text-orange">{{ trans('home.services.heading') }}</p>
            <p class="mt-8 leading-loose">{{ trans('home.services.content') }}</p>
            <a class="btn-type-1 text-center text-navy no-underline mt-12 block"
               href="{{ localUrl("/services") }}">{{ trans('home.services.link') }}</a>
        </div>
    </section>
    <section class="services reg-section-space">
        <div class="flex flex-col sm:flex-row justify-center">
            <div class="bg-baby-blue-opq w-80 h-80 mx-auto sm:mx-4 my-4 max-w-full p-8 flex flex-col justify-between">
                @include('svgs.icons.audit_circle', ['classes' => 'h-16'])
                <p class="h3 text-center">{{ trans('home.services.audits.title') }}</p>
                <p class="body-text-sm leading-loose">{{ trans('home.services.audits.description') }}</p>
            </div>
            <div class="bg-baby-blue-opq w-80 h-80 mx-auto sm:mx-4 my-4 max-w-full p-8 flex flex-col justify-between">
                @include('svgs.icons.bookkeeping_circle', ['classes' => 'h-16'])
                <p class="h3 text-center">{{ trans('home.services.bookkeeping.title') }}</p>
                <p class="body-text-sm leading-loose">{{ trans('home.services.bookkeeping.description') }}</p>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row justify-center">
            <div class="bg-baby-blue-opq w-80 h-80 mx-auto sm:mx-4 my-4 max-w-full p-8 flex flex-col justify-between">
                @include('svgs.icons.tax_circle', ['classes' => 'h-16'])
                <p class="h3 text-center">{{ trans('home.services.tax.title') }}</p>
                <p class="body-text-sm leading-loose">{{ trans('home.services.tax.description') }}</p>
            </div>
            <div class="bg-baby-blue-opq w-80 h-80 mx-auto sm:mx-4 my-4 max-w-full p-8 flex flex-col justify-between">
                @include('svgs.icons.biz_reg_circle', ['classes' => 'h-16'])
                <p class="h3 text-center">{{ trans('home.services.business_registration.title') }}</p>
                <p class="body-text-sm leading-loose">{{ trans('home.services.business_registration.description') }}</p>
            </div>
        </div>
    </section>
    <section class="reg-section-space">
        <div class="bg-pale-baby-blue py-8 px-12 max-w-xl mx-auto">
            <div class="max-w-md mx-auto">
                <p class="h2 text-orange">{{ trans('home.contact.heading') }}</p>
                <p class="mt-8 leading-loose">{{ trans('home.contact.content') }}</p>
                <a class="btn-type-1 text-center text-navy no-underline mt-12 block"
                   href="{{ localUrl("/contact") }}">{{ trans('home.contact.link') }}</a>
            </div>
        </div>

    </section>
    <img src="/images/home/city_sketch.png"
         alt="sketch of city skyline"
         class="w-full block">

@endsection