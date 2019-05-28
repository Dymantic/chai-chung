@extends('front.base', ['bodyClasses' => "pt-12 service-page audits"])

@section('content')
    <section class="top-banner"></section>

    <section class="reg-section-space">
        <div class="max-w-lg mx-auto">
            <div class="my-20">
                <h1 class="h1 text-orange mb-12">{{ trans('service_audits.page_title') }}</h1>
                <h2 class="h3 text-navy mb-2">1. {{ trans('service_audits.audits_and_assurance.heading') }}</h2>
                <ul class="mb-8">
                    <li>{{ trans('service_audits.audits_and_assurance.financial_statements') }}</li>
                    <li>
                        <p>{{ trans('service_audits.audits_and_assurance.ipo_market_listing.heading') }}</p>

                    </li>
                </ul>
                <p class="max-w-md mb-2">{{ trans('service_audits.audits_and_assurance.ipo_market_listing.explanation') }}</p>
                <ul>
                    @foreach(trans('service_audits.audits_and_assurance.ipo_market_listing.conditions') as $condition)
                        <li>{{ $condition }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="my-20">
                <h2 class="h3 text-navy mb-4">2. {{ trans('service_audits.tax_compliance.heading') }}</h2>
                <ul class="mb-8">
                    <li>{{ trans('service_audits.tax_compliance.income_tax') }}</li>
                    <li>
                        <p>{{ trans('service_audits.tax_compliance.business_tax.heading') }}</p>
                    </li>
                </ul>
                <p class="mb-4">{{ trans('service_audits.tax_compliance.business_tax.explanation') }}</p>
                <ul>
                    @foreach(trans('service_audits.tax_compliance.business_tax.conditions') as $condition)
                        <li>{{ $condition }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="my-20">
                <p class="h2 text-orange mb-4">{{ trans('service_audits.tax_compliance.advantages.heading') }}</p>
                <ol class="body-text-sm pl-4 max-w-md">
                    <li class="mb-2">{{ trans('service_audits.tax_compliance.advantages.one') }}</li>
                    <li class="mb-2">{{ trans('service_audits.tax_compliance.advantages.two') }}</li>
                    <li class="mb-2">{{ trans('service_audits.tax_compliance.advantages.three') }}</li>
                </ol>
            </div>

        </div>

        <div class="max-w-lg mx-auto">
            <h2 class="h3 text-navy mb-8">{{ trans('service_audits.other_auditing_services.heading') }}</h2>
            <ul>
                <li>{{ trans('service_audits.other_auditing_services.mutual_agreements') }}</li>
                <li>{{ trans('service_audits.other_auditing_services.government_grants') }}</li>
                <li>{{ trans('service_audits.other_auditing_services.special_purpose') }}</li>
            </ul>
        </div>
    </section>

    @include('front.services.service-end-nav')
@endsection