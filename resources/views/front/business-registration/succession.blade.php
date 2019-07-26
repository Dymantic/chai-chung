@extends('front.base', ['bodyClasses' => "pt-12"])

@section("title")
    {{ trans('br_succession.seo.title') }}
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogTitle' => trans('br_succession.seo.title'),
        'ogDescription' => trans('br_succession.seo.description'),
    ])
@endsection

@section('content')
    <section class="reg-section-space">
        <div class="max-w-lg mx-auto">
            <h1 class="biz-ass-title number-3 h1 text-orange mb-12">{{ trans('br_succession.page_title') }}</h1>
            <h2 class="h2 text-navy mb-12">{{ trans('br_succession.subheading') }}</h2>
            <p class="mb-12">{{ trans('br_succession.services.intro') }}</p>
            <ul class="no-chinese">
                @foreach(trans('br_succession.services.list') as $service)
                    <li>{{ $service }}</li>
                @endforeach
            </ul>
        </div>
    </section>
    <section>
        @include('front.services.business-assistance.nav-footer', ['without' => 'succession'])
    </section>
@endsection