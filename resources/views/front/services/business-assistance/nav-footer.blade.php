@include('front.services.business-assistance.subnav', ['without' => $without])
<div class="flex flex-col items-center my-12">

    <a href="{{ localUrl('/services/business-assistance') }}"
       class="text-link text-navy hover:text-bright-blue mb-12"
    >
        @include('front.partials.larr-span', ['text' => trans('service_business_assistance.links.back_assistance')])
    </a>

    <a href="{{ localUrl('/contact') }}"
       class="btn btn-orange"
    >
        @include('front.partials.rarr-span', ['text' => trans('service_business_assistance.links.contact')])
    </a>
</div>