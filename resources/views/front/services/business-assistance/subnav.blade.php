<div class="flex justify-around mt-20 max-w-md mx-auto">
    @php
    $without = $without ?? '';
    @endphp

    @if($without !== 'planning')
    <a href="{{ localUrl("/business-planning") }}"
       class="block flex justify-center items-center text-center p-4 w-32 h-32 bg-grey-lighter shadow-lg mx-4 rounded hover:bg-orange-light no-underline text-navy font-bold">
        {{ trans('service_business_assistance.subnav.planning') }}
    </a>
    @endif

    @if($without !== 'formation')
    <a href="{{ localUrl("/business-formation") }}"
       class="block flex justify-center items-center text-center p-4 w-32 h-32 bg-grey-lighter shadow-lg mx-4 rounded hover:bg-orange-light no-underline text-navy font-bold">
        {{ trans('service_business_assistance.subnav.formation') }}
    </a>
    @endif

    @if($without !== 'succession')
    <a href="{{ localUrl("/succession-planning") }}"
       class="block flex justify-center items-center text-center p-4 w-32 h-32 bg-grey-lighter shadow-lg mx-4 rounded hover:bg-orange-light no-underline text-navy font-bold">
        {{ trans('service_business_assistance.subnav.succession') }}
    </a>
    @endif

    @if($without !== 'foreign')
    <a href="{{ localUrl("/foreign-investment-in-taiwan") }}"
       class="block flex justify-center items-center text-center p-4 w-32 h-32 bg-grey-lighter shadow-lg mx-4 rounded hover:bg-orange-light no-underline text-navy font-bold">
        {{ trans('service_business_assistance.subnav.foreign') }}
    </a>
    @endif
</div>