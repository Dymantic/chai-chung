<div class="h-12 bg-navy flex justify-between items-center px-4">
    <a href="/admin/dashboard" class="font-black text-orange no-underline">ChiaChung CPA</a>
    <div class="flex items-center justify-end text-orange">
        @if(auth()->user()->is_manager)
            <dropdown-menu v-cloak
                           name="Time"
                           class="text-white h-12 flex items-center mr-4">
                <div slot="dropdown_content"
                     class="pt-3">
                    <a href="/admin/manage-sessions"
                       class="text-grey-darker no-underline hover:text-orange-light pb-3 block">Records</a>
                    <a href="/admin/manage-holidays"
                       class="text-grey-darker no-underline hover:text-orange-light">Holidays</a>
                </div>
            </dropdown-menu>
            <dropdown-menu v-cloak
                           name="Reports"
                           class="text-white h-12 flex items-center mr-4">
                <div slot="dropdown_content"
                     class="pt-3">
                    <a href="/admin/manage-reports/staff-time"
                       class="text-grey-darker no-underline hover:text-orange-light pb-3 block">Staff</a>
                    <a href="/admin/manage-reports/client-time"
                       class="text-grey-darker no-underline hover:text-orange-light pb-3 block">Client</a>
                    <a href="/admin/manage-reports/engagement-time"
                       class="text-grey-darker no-underline hover:text-orange-light pb-3 block">Engagement</a>
                </div>
            </dropdown-menu>
            <dropdown-menu v-cloak
                           name="Clients"
                           class="text-white h-12 flex items-center">
                <div slot="dropdown_content"
                     class="pt-3">
                    <a href="/admin/manage-clients"
                       class="text-grey-darker no-underline hover:text-orange-light pb-3 block">Clients</a>
                    <a href="/admin/manage-engagement-codes"
                       class="text-grey-darker no-underline hover:text-orange-light">Engagement Codes</a>
                </div>
            </dropdown-menu>

            <a href="/admin/manage-users" class="text-white no-underline hover:text-orange mx-4">Users</a>
        @endif
        <dropdown-menu v-cloak
                       name="{{ Auth()->user()->name }}"
                       class="text-orange h-12 flex items-center">
            <div slot="dropdown_content"
                 class="pt-3">
                <p class="text-grey-darker pb-3 block">{{ auth()->user()->email }}</p>
                <a href="/admin/me"
                   class="text-grey-darker no-underline hover:text-orange-light pb-3 block">My Profile</a>
                <a href="/admin/reset-password"
                   class="text-grey-darker no-underline hover:text-orange-light">Reset Password</a>
                @include('admin.partials.logout-form')
            </div>
        </dropdown-menu>
    </div>
</div>