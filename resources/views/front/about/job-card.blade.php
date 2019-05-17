<div class="max-w-md p-8 mx-auto shadow bg-grey-lighter my-20" data-usher>
    <p class="h2 text-orange mb-12">{{ $job['title'] }}</p>
    @foreach($job['fields'] as $info)
    <p class="mb-1">
        <span class="font-bold text-orange">{{ $info['heading'] }}:</span>
        <span class="text-navy">{{ $info['content'] }}</span>
    </p>
    @endforeach
    <div class="text-center mt-8">
        <a href="/contact" class="text-link text-navy">{!! trans('about.careers.apply_link') !!}</a>
    </div>
</div>