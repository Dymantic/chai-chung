<section class="services reg-section-space">
    <div class="flex flex-col sm:flex-row justify-center">
        <div data-usher class="bg-baby-blue-opq w-80 h-80 mx-auto sm:mx-4 my-4 max-w-full p-8 flex flex-col justify-between">
            @include('svgs.icons.audit_circle', ['classes' => 'h-16'])
            <p class="h3 text-center">{{ trans('home.services.audits.title') }}</p>
            <p class="body-text-sm">{{ trans('home.services.audits.description') }}</p>
        </div>
        <div data-usher class="bg-baby-blue-opq w-80 h-80 mx-auto sm:mx-4 my-4 max-w-full p-8 flex flex-col justify-between">
            @include('svgs.icons.bookkeeping_circle', ['classes' => 'h-16'])
            <p class="h3 text-center">{{ trans('home.services.bookkeeping.title') }}</p>
            <p class="body-text-sm">{{ trans('home.services.bookkeeping.description') }}</p>
        </div>
    </div>
    <div class="flex flex-col sm:flex-row justify-center">
        <div data-usher class="bg-baby-blue-opq w-80 h-80 mx-auto sm:mx-4 my-4 max-w-full p-8 flex flex-col justify-between">
            @include('svgs.icons.tax_circle', ['classes' => 'h-16'])
            <p class="h3 text-center">{{ trans('home.services.tax.title') }}</p>
            <p class="body-text-sm">{{ trans('home.services.tax.description') }}</p>
        </div>
        <div data-usher class="bg-baby-blue-opq w-80 h-80 mx-auto sm:mx-4 my-4 max-w-full p-8 flex flex-col justify-between">
            @include('svgs.icons.biz_reg_circle', ['classes' => 'h-16'])
            <p class="h3 text-center">{{ trans('home.services.business_registration.title') }}</p>
            <p class="body-text-sm">{{ trans('home.services.business_registration.description') }}</p>
        </div>
    </div>
</section>