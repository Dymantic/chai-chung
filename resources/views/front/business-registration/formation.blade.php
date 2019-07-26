@extends('front.base', ['bodyClasses' => "pt-12"])

@section("title")
    {{ trans('br_formation.seo.title') }}
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogTitle' => trans('br_formation.seo.title'),
        'ogDescription' => trans('br_formation.seo.description'),
    ])
@endsection

@section('content')
    <section class="reg-section-space">
        <div class="max-w-lg mx-auto">
            <h1 class="biz-ass-title number-2 h1 text-orange mb-12">{{ trans('br_formation.page_title') }}</h1>
            <h2 class="h2 text-navy mb-12">{{ trans('br_formation.services.heading') }}</h2>
            <ul>
                @foreach(trans('br_formation.services.list') as $service)
                <li>{{ $service }}</li>
                @endforeach
            </ul>
        </div>
    </section>
    <section>
        @include('front.services.business-assistance.nav-footer', ['without' => 'formation'])
    </section>
@endsection