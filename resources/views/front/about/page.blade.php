@extends('front.base', ['bodyClasses' => 'pt-12'])

@section("title")
    {{ trans('about.seo.title') }}
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogTitle' => trans('about.seo.title'),
        'ogDescription' => trans('about.seo.description'),
    ])
@endsection

@section('content')
    <section class="reg-section-space company-story">
        <div class="max-w-md mx-auto">
            <h2 class="h1 text-orange">{{ trans('about.story.heading') }}</h2>
            <p class="mt-12">{{ trans('about.story.part_one') }}</p>
        </div>
    </section>

    <section class="reg-section-space">
        <div class="max-w-md mx-auto">
            <h2 class="h1 text-orange">{{ trans('about.accountants.heading') }}</h2>
            <p class="mt-12">{{ trans('about.accountants.part_one') }}</p>
            <p class="mt-8">{{ trans('about.accountants.part_two') }}</p>
        </div>
    </section>

    <section class="reg-section-space tight-bottom">
        <div class="max-w-md mx-auto">
            <h2 class="h1 text-orange">{{ trans('about.team.heading') }}</h2>

        </div>
        <div class="max-w-xl mx-auto">
            @foreach(trans('about.team.members') as $member)
                @include('front.about.member-card', ['member' => $member])
            @endforeach
        </div>
    </section>

    <section id="carreers" class="reg-section-space">
        <div class="max-w-lg mx-auto">
            <h2 class="h1 max-w-md mx-auto text-orange mb-20">{{ trans('about.careers.heading') }}</h2>
                @foreach(data('jobs') as $job)
                    @include('front.about.job-card', [
                        'job' => $job[app()->getLocale()],
                    ])
                @endforeach
        </div>
    </section>

@endsection