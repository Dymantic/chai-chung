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
