@extends('front.base', ['bodyClasses' => "pt-12 service-page business-assistance"])

@section("title")
    {{ trans('service_business_assistance.seo.title') }}
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogTitle' => trans('service_business_assistance.seo.title'),
        'ogDescription' => trans('service_business_assistance.seo.description'),
    ])
@endsection

@section('content')
    <section class="top-banner"></section>

    <section class="reg-section-space tight-bottom">
        <div class="max-w-lg mx-auto">
            <h1 class="h1 text-orange mb-12">{{ trans('service_business_assistance.page_title') }}</h1>
            <div class="max-w-lg mx-auto">
                <h2 class="h2 text-navy mb-12">{{ trans('service_business_assistance.intro.heading') }}</h2>
                <p class="mb-12 max-w-md">{{ trans('service_business_assistance.intro.content') }}</p>
                <ul class="no-chinese">
                    @foreach(trans('service_business_assistance.service_list') as $service)
                        <li>{{ $service }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </section>
    @include('front.services.business-assistance.subnav')
    <section class="reg-section-space">
        <div class="max-w-lg mx-auto">
            <h2 class="h2 mb-12 text-navy">{{ trans('service_business_assistance.advantages_of_taiwan.intro') }}</h2>
            <ul class="mb-12">
                @foreach(trans('service_business_assistance.advantages_of_taiwan.list') as $advantage)
                    <li>{{ $advantage }}</li>
                @endforeach
            </ul>
            <p>{{ trans('service_business_assistance.closing') }}</p>
        </div>

    </section>
    @include('front.services.service-end-nav')
@endsection