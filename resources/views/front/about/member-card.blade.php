<div class="max-w-md mx-auto md:bg-grey-lightest px-4 md:px-8 py-8 md:shadow mt-20 body-text-sm">
    <div class="flex flex-col md:flex-row items-center md:items-start mb-12" data-usher>
        <div class="w-32 h-32 mb-8 md:mb-0 rounded-full overflow-hidden">
            <img src="{{ $member['avatar'] }}" class="w-full h-full object-cover"
                 alt="{{ $member['name'] }}">
        </div>

        <div class="md:pl-12 flex flex-col justify-center">
            <p>
                <span class="text-lg font-bold text-navy">{{ $member['name'] }}</span>
                <span class="text-lg font-bold text-orange">({{ $member['title'] }})</span>
            </p>
            <p>T: {{ $member['phone'] }}</p>
            <p>F: {{ $member['fax'] }}</p>
            <p>E: <a href="mailto:{{ $member['email'] }}" class="no-underline text-navy">{{ $member['email'] }}</a></p>
        </div>
    </div>
    <div class="mb-4">
        <p class="capitalize text-orange">{{ $member['education']['heading'] }}</p>
        <ul>
            @foreach($member['education']['list'] as $education)
                <li class="mb-1">{{ $education }}</li>
            @endforeach
        </ul>
    </div>
    <div class="mb-4">
        <p class="capitalize text-orange">{{ $member['experience']['heading'] }}</p>
        <ul>
            @foreach($member['experience']['list'] as $experience)
                <li class="mb-1">{{ $experience }}</li>
            @endforeach
        </ul>
    </div>
    @if(count($member['certificates']['list']) > 0)
        <div class="mb-4">
            <p class="capitalize text-orange">{{ $member['certificates']['heading'] }}</p>
            <ul>
                @foreach($member['certificates']['list'] as $certificate)
                    <li class="mb-1">{{ $certificate }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
