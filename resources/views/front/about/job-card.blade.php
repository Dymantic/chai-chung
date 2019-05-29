<div class="max-w-md px-4 md:px-8 py-8 mx-auto md:shadow md:bg-grey-lighter my-20" data-usher>
    <p class="h2 text-navy mb-12">{{ $job['title'] }}</p>
    @foreach($job['fields'] as $info)
    <p class="mb-1">
        <span class="font-bold text-orange">{{ $info['heading'] }}:</span>
        <span class="text-navy">{{ $info['content'] }}</span>
    </p>
    @endforeach
    <div class="text-center mt-8">
        <a href="/contact" class="text-link text-navy hover:text-orange-light">{!! trans('about.careers.apply_link') !!}</a>
    </div>
</div>