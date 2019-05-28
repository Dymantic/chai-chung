@extends('front.base', ['bodyClasses' => 'pt-12'])

@section('content')
    <section class="reg-section-space">
        <div class="max-w-md mx-auto">
            <h1 class="h1 text-orange">{{ trans('services.intro.heading') }}</h1>
            <p class="mt-12">{{ trans('services.intro.content') }}</p>
        </div>
    </section>

    <section class="max-w-lg mx-auto">

        @component('front.components.soft-card', ['usher' => false, 'classes' => 'fadeUpOnLoad'])
            <h2 class="h2 text-orange">
                {{ trans('services.audits.heading') }}
            </h2>
            <p class="mt-8">{{ trans('services.audits.description') }}</p>
            <a href="{{ localUrl("/services/audits") }}" class="mt-12 text-link text-navy hover:text-orange-light block text-center">{!! trans('services.audits.link') !!}</a>
        @endcomponent

        @component('front.components.soft-card', ['usher' => false, 'classes' => 'fadeUpAfterLoad'])
                <h2 class="h2 text-orange">
                    {{ trans('services.bookkeeping.heading') }}
                </h2>
                <p class="mt-8">{{ trans('services.bookkeeping.description') }}</p>
                <a href="{{ localUrl("/services/bookkeeping") }}" class="mt-12 text-link text-navy hover:text-orange-light block text-center">{!! trans('services.bookkeeping.link') !!}</a>
        @endcomponent

        @component('front.components.soft-card', ['usher' => true])
                <h2 class="h2 text-orange">
                    {{ trans('services.tax.heading') }}
                </h2>
                <p class="mt-8">{{ trans('services.tax.description') }}</p>
                <a href="{{ localUrl("/services/tax") }}" class="mt-12 text-link text-navy hover:text-orange-light block text-center">{!! trans('services.tax.link') !!}</a>
        @endcomponent

        @component('front.components.soft-card', ['usher' => true])
                <h2 class="h2 text-orange">
                    {{ trans('services.business_registration.heading') }}
                </h2>
                <p class="mt-8">{{ trans('services.business_registration.description') }}</p>
                <a href="{{ localUrl("/services/business-assistance") }}" class="mt-12 text-link text-navy hover:text-orange-light block text-center">{!! trans('services.business_registration.link') !!}</a>
        @endcomponent

    </section>

@endsection