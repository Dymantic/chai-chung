<section class="reg-section-space">
    <div class="max-w-md mx-auto">
        <p class="h2 text-orange mb-20">{{ trans('home.logos.heading') }}</p>

    </div>
    <div class="max-w-lg mx-auto logo-grid">
        @foreach(data('client-logos') as $client)
{{--            <div class="h-24" data-usher>--}}
{{--                <img src="/images/clients/{{ $client['logo'] }}"--}}
{{--                     alt="{{ $client['name'] }} logo" class="w-full h-full object-contain">--}}
{{--            </div>--}}
           @if($client['name']) <p>{{ $client['name'] }}</p> @endif
        @endforeach
    </div>
</section>