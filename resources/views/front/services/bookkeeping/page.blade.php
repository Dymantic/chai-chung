@extends('front.base', ['bodyClasses' => "pt-12 service-page bookkeeping"])

@section("title")
    {{ trans('service_bookkeeping.seo.title') }}
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogTitle' => trans('service_bookkeeping.seo.title'),
        'ogDescription' => trans('service_bookkeeping.seo.description'),
    ])
@endsection

@section('content')
    <section class="top-banner"></section>

    <section class="reg-section-space">
        <div class="max-w-lg mx-auto">
            <h1 class="h1 text-orange mb-12">{{ trans('service_bookkeeping.page_title') }}</h1>
            <p class="mb-8 max-w-md">{{ trans('service_bookkeeping.service_intro') }}</p>
            <p class="max-w-md">{{ trans('service_bookkeeping.service_list_intro') }}</p>
            <ul class="max-w-md mb-8">
                @foreach(trans('service_bookkeeping.services_list') as $service)
                    <li>{{ $service }}</li>
                @endforeach
            </ul>
            <p>{{ trans('service_bookkeeping.service_range_intro') }}</p>
        </div>

    </section>

    @include('front.services.service-end-nav')
@endsection