@extends('front.base', ['bodyClasses' => "pt-12 service-page tax"])

@section('content')
    <section class="top-banner"></section>

    <section class="reg-section-space">
        <div class="max-w-lg mx-auto">
            <h1 class="h1 text-orange mb-12">{{ trans('service_tax.page_title') }}</h1>
            <p class="max-w-md mb-8">{{ trans('service_tax.intro') }}</p>
            <p class="max-w-md mb-2">{{ trans('service_tax.services_list_intro') }}</p>
            <ul>
                @foreach(trans('service_tax.services_list') as $service)
                    <li>{{ $service }}</li>
                @endforeach
            </ul>
        </div>

    </section>

    <section class="reg-section-space flex flex-col items-center">
        <a href="{{ localUrl('/contact') }}"
           class="btn btn-orange">{!! trans('service_tax.links.contact') !!}</a>
        <a href="{{ localUrl('/services') }}"
           class="text-link text-navy mt-12">{!! trans('service_tax.links.back') !!}</a>
    </section>
@endsection