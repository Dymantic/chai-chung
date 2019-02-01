<div class="h-12 bg-navy flex justify-between items-center px-4">
    <div class="font-black text-orange">Tino's</div>
    <div class="flex items-center justify-end text-orange">
        <dropdown-menu v-cloak
                       name="{{ Auth()->user()->email }}"
                       class="text-orange h-12 flex items-center">
            <div slot="dropdown_content"
                 class="pt-3">
                <a href="reset-password"
                   class="text-grey-darker no-underline hover:text-orange-light">Reset Password</a>
                @include('admin.partials.logout-form')
            </div>
        </dropdown-menu>
    </div>
</div>