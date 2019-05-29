<div class="flex flex-col md:flex-row justify-around mt-20 max-w-md mx-auto">
    @php
    $without = $without ?? '';
    @endphp

    @include('front.services.business-assistance.subnav-item', [
        'isLink' => $without !== 'planning',
        'address' => localUrl("/business-planning"),
        'text' => trans('service_business_assistance.subnav.planning'),
        'number' => 1,
    ])

    @include('front.services.business-assistance.subnav-item', [
        'isLink' => $without !== 'formation',
        'address' => localUrl("/business-formation"),
        'text' => trans('service_business_assistance.subnav.formation'),
        'number' => 2,
    ])

    @include('front.services.business-assistance.subnav-item', [
        'isLink' => $without !== 'succession',
        'address' => localUrl("/succession-planning"),
        'text' => trans('service_business_assistance.subnav.succession'),
        'number' => 3,
    ])

    @include('front.services.business-assistance.subnav-item', [
        'isLink' => $without !== 'foreign',
        'address' => localUrl("/business-foreign"),
        'text' => trans('service_business_assistance.subnav.foreign'),
        'number' => 4,
    ])
</div>