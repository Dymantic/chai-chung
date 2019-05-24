<section class="services reg-section-space">
    <div class="flex flex-col sm:flex-row justify-center">
        @include('front.home.service-link-card', [
            'url' => '/services/audits',
            'icon' => 'svgs.icons.audit_circle',
            'title' => trans('home.services.audits.title')
        ])
        @include('front.home.service-link-card', [
            'url' => '/services/bookkeeping',
            'icon' => 'svgs.icons.bookkeeping_circle',
            'title' => trans('home.services.bookkeeping.title')
        ])
    </div>
    <div class="flex flex-col sm:flex-row justify-center">
        @include('front.home.service-link-card', [
            'url' => '/services/tax',
            'icon' => 'svgs.icons.tax_circle',
            'title' => trans('home.services.tax.title')
        ])
        @include('front.home.service-link-card', [
            'url' => '/services/business-assistance',
            'icon' => 'svgs.icons.biz_reg_circle',
            'title' => trans('home.services.business_registration.title')
        ])
    </div>
</section>