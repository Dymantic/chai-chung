@extends('front.base', ['bodyClasses' => "pt-12 service-page {$content['service']}"])

@section('content')
    <section class="top-banner"></section>
    <section class="reg-section-space">
        <div class="max-w-md mx-auto">
            <h1 class="h1 text-orange">{{ $content['title'] }}</h1>
            @foreach($content['paragraphs'] as $paragraph)
            <p class="mt-12">{{ $paragraph }}</p>
            @endforeach
        </div>
    </section>
    @if($content['include'] ?? false)
    <section>
        @include($content['include'])
    </section>
    @endif
    <section class="py-12 mb-20">
        @component('front.components.soft-card')
            <p class="h2 text-orange">{{ $content['logos']['header'] }}</p>
            <p class="mt-4 mb-8">{{ $content['logos']['intro'] }}</p>
            <div class="flex justify-start flex-wrap">
                @foreach(range(1, 7) as $index)
                    <div class="w-40 flex flex-col items-center p-4 mb-4 text-mid-grey">
                        <svg data-usher data-usher-name="fadeUpSmall" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40"><path class="fill-current" d="M13 20v-5h-2v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-7.59l-.3.3a1 1 0 1 1-1.4-1.42l9-9a1 1 0 0 1 1.4 0l9 9a1 1 0 0 1-1.4 1.42l-.3-.3V20a2 2 0 0 1-2 2h-3a2 2 0 0 1-2-2zm5 0v-9.59l-6-6-6 6V20h3v-5c0-1.1.9-2 2-2h2a2 2 0 0 1 2 2v5h3z"/></svg>
                        <p data-usher data-usher-name="fadeUpSmall" data-usher-delay=".25" class="text-center btn-type-1 text-mid-grey">Home sweet home</p>
                    </div>
                @endforeach
            </div>
        @endcomponent
    </section>
    <section class="reg-section-space flex flex-col items-center">
        <a href="{{ localUrl('/contact') }}"
           class="text-link text-orange">{!! $content['links']['contact'] !!}</a>
        <a href="{{ localUrl('/services') }}"
           class="text-link text-navy mt-12">{!! $content['links']['back'] !!}</a>
    </section>



@endsection