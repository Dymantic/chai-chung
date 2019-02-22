@extends('front.base', ['bodyClasses' => 'pt-12'])

@section('content')
    <section class="reg-section-space">
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
            <div class="mt-20 team-grid">
                @foreach(data('team.members') as $member)
                    <div class="flex flex-col items-center">
                        <img src="{{ $member['avatar'] }}" class="w-32 mb-2"
                             alt="Avatar of {{ $member['name'] }}">
                        <p class="btn-type-1">{{ $member['name'] }}</p>
                        <p class="body-text-sm">{{ $member['title'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="reg-section-space">
        <div class="max-w-lg mx-auto">
            <h2 class="h1 max-w-md mx-auto text-orange">{{ trans('about.careers.heading') }}</h2>
                @foreach(data('jobs') as $job)
                    <div class="my-20 bg-pale-baby-blue p-8">
                        <div class="max-w-md mx-auto">
                            <p class="h2 text-orange">{{ $job['title'][app()->getLocale()] }}</p>
                            <p class="body-text mt-4">{{ $job['description'][app()->getLocale()] }}</p>
                            <a href="" class="text-link text-navy mt-8 block text-center">{!! trans('about.careers.apply_link') !!}</a>
                        </div>
                    </div>
                @endforeach
        </div>
    </section>

@endsection