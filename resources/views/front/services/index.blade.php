@extends('front.base', ['bodyClasses' => 'pt-12'])

@section('content')
    <section class="reg-section-space">
        <div class="max-w-md mx-auto">
            <h1 class="h1 text-orange">{{ trans('services.intro.heading') }}</h1>
            <p class="mt-12">{{ trans('services.intro.content') }}</p>
        </div>
    </section>

    <section class="max-w-lg mx-auto">
        <div class="mb-20 p-8 bg-pale-baby-blue">
            <div class="max-w-md mx-auto">
                <h2 class="h2 text-orange">{{ trans('services.audits.heading') }}</h2>
                <p class="mt-8">{{ trans('services.audits.description') }}</p>
                <a href="" class="mt-12 text-link text-navy block text-center">{!! trans('services.audits.link') !!}</a>
            </div>
        </div>

        <div class="mb-20 p-8 bg-pale-baby-blue">
            <div class="max-w-md mx-auto">
                <h2 class="h2 text-orange">{{ trans('services.bookkeeping.heading') }}</h2>
                <p class="mt-8">{{ trans('services.bookkeeping.description') }}</p>
                <a href="" class="mt-12 text-link text-navy block text-center">{!! trans('services.bookkeeping.link') !!}</a>
            </div>
        </div>

        <div class="mb-20 p-8 bg-pale-baby-blue">
            <div class="max-w-md mx-auto">
                <h2 class="h2 text-orange">{{ trans('services.tax.heading') }}</h2>
                <p class="mt-8">{{ trans('services.tax.description') }}</p>
                <a href="" class="mt-12 text-link text-navy block text-center">{!! trans('services.tax.link') !!}</a>
            </div>
        </div>

        <div class="mb-20 p-8 bg-pale-baby-blue">
            <div class="max-w-md mx-auto">
                <h2 class="h2 text-orange">{{ trans('services.business_registration.heading') }}</h2>
                <p class="mt-8">{{ trans('services.business_registration.description') }}</p>
                <a href="" class="mt-12 text-link text-navy block text-center">{!! trans('services.business_registration.link') !!}</a>
            </div>
        </div>
    </section>

@endsection