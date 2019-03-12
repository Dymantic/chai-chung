@extends('front.base', ['bodyClasses' => 'pt-12'])

@section('content')
    <section class="reg-section-space company-story">
        <div class="max-w-md mx-auto">
            <h2 class="h1 text-orange">{{ trans('about.story.heading') }}</h2>
            <p class="mt-12">{{ trans('about.story.part_one') }}</p>
            <p class="mt-8">{{ trans('about.story.part_two') }}</p>
        </div>
    </section>

    <section class="reg-section-space">
        <div class="max-w-md mx-auto">
            <h2 class="h1 text-orange">{{ trans('about.accountants.heading') }}</h2>
            <p class="mt-12">{{ trans('about.accountants.part_one') }}</p>
            <p class="mt-8">{{ trans('about.accountants.part_two') }}</p>
        </div>
    </section>

    <section class="reg-section-space">
        <div class="max-w-md mx-auto">
            <h2 class="h1 text-orange">{{ trans('about.team.heading') }}</h2>

        </div>
        <div class="max-w-xl mx-auto">
            <div class="mt-20 team-grid">
                @foreach(data('team.members') as $member)
                    <div class="flex flex-col items-center">
                        <img src="{{ $member['avatar'] }}" data-usher data-usher-name="fadeUpSmall" data-usher-delay="0" class="w-32 mb-2"
                             alt="Avatar of {{ $member['name'] }}">
                        <p data-usher data-usher-name="fadeUpSmall" data-usher-delay=".25" class="btn-type-1">{{ $member['name'] }}</p>
                        <p data-usher data-usher-name="fadeUpSmall" data-usher-delay=".5" class="body-text-sm">{{ $member['title'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="reg-section-space">
        <div class="max-w-lg mx-auto">
            <h2 class="h1 max-w-md mx-auto text-orange mb-20">{{ trans('about.careers.heading') }}</h2>
                @foreach(data('jobs') as $job)
                    @component('front.components.soft-card', ['usher' => true])
                        <p class="h2 text-orange">{{ $job['title'][app()->getLocale()] }}</p>
                        <p class="body-text mt-4">{{ $job['description'][app()->getLocale()] }}</p>
                        <a href="" class="text-link text-navy mt-8 block text-center">{!! trans('about.careers.apply_link') !!}</a>
                    @endcomponent
                @endforeach
        </div>
    </section>

@endsection