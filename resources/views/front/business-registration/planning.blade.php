@extends('front.base', ['bodyClasses' => "pt-12"])

@section('content')
    <section class="reg-section-space">
        <div class="max-w-lg mx-auto">
            <h1 class="h1 text-orange mb-12">{{ trans('br_planning.page_title') }}</h1>
            <p>{{ trans('br_planning.intro') }}</p>
            <h2 class="h2 my-12 text-navy">{{ trans('br_planning.questions.intro') }}</h2>
            @foreach(trans('br_planning.questions.list') as $question)
            <article class="my-8 max-w-md">
                <h3 class="h3 text-navy mb-2">{{ $question['question'] }}</h3>
                <p>{{ $question['detail'] }}</p>
            </article>
            @endforeach
        </div>
    </section>
    <section>
        @include('front.services.business-assistance.nav-footer', ['without' => 'planning'])
    </section>
@endsection