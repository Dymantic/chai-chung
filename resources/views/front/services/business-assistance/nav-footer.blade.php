@include('front.services.business-assistance.subnav', ['without' => $without])
<div class="flex flex-col items-center my-12">

    <a href="{{ localUrl('/services/business-assistance') }}"
       class="text-link text-navy mb-12"
    >
        {!! trans('service_business_assistance.links.back_assistance') !!}
    </a>

    <a href="{{ localUrl('/contact') }}"
       class="btn btn-orange"
    >
        {!! trans('service_business_assistance.links.contact') !!}
    </a>
</div>