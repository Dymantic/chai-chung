@extends('front.base', ['bodyClasses' => "pt-12"])

@section('content')
    <section class="reg-section-space">
        <div class="max-w-lg mx-auto">
            <h1 class="biz-ass-title number-4 h1 text-orange mb-12">{{ trans('br_foreign.page_title') }}</h1>
            <h2 class="h2 text-navy mb-12">{{ trans('br_foreign.procedure.intro') }}</h2>
            <ul class="list-reset max-w-md">
                @foreach(trans('br_foreign.procedure.list') as $index => $step)
                    <li class="mb-8">
                        <p class="h3 mb-2 text-navy">{{ $index + 1 }}. {{ $step['point'] }}</p>
                        <p>{{ $step['detail'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
    <section>
        @include('front.services.business-assistance.nav-footer', ['without' => 'foreign'])
    </section>
@endsection