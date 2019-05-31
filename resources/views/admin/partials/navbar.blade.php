<div class="h-12 bg-navy flex justify-between items-center px-4">
    <div class="flex items-center">
        <a href="/admin/dashboard" class="font-black text-orange no-underline">ChiaChung CPA</a>
        <a href="/admin/dashboard" class="text-white no-underline hover:text-orange mx-4">時間紀錄</a>
        <dropdown-menu v-cloak
                       name="請假"
                       class="text-white h-12 flex items-center mx-4">
            <div slot="dropdown_content"
                 class="pt-3">
                <a href="/admin/leave"
                   class="text-grey-darker no-underline hover:text-orange-light pb-3 block">請假</a>
                <a href="/admin/covering-requests"
                   class="text-grey-darker no-underline hover:text-orange-light">代班</a>
            </div>
        </dropdown-menu>
    </div>

    <div class="flex items-center justify-end text-orange">
        @if(auth()->user()->is_manager)
            <dropdown-menu v-cloak
                           name="員工時數紀錄"
                           class="text-white h-12 flex items-center mr-4">
                <div slot="dropdown_content"
                     class="pt-3">
                    <a href="/admin/manage-sessions"
                       class="text-grey-darker no-underline hover:text-orange-light pb-3 block">紀錄</a>
                    <a href="/admin/manage-holidays"
                       class="text-grey-darker no-underline hover:text-orange-light">國定假日</a>
                </div>
            </dropdown-menu>
            <a href="/admin/manage-staff-leave" class="text-white no-underline hover:text-orange mr-4">員工請假紀錄</a>
            <dropdown-menu v-cloak
                           name="時數總和"
                           class="text-white h-12 flex items-center mr-4">
                <div slot="dropdown_content"
                     class="pt-3">
                    <a href="/admin/manage-reports/staff-time"
                       class="text-grey-darker no-underline hover:text-orange-light pb-3 block">員工</a>
                    <a href="/admin/manage-reports/client-time"
                       class="text-grey-darker no-underline hover:text-orange-light pb-3 block">客戶</a>
                    <a href="/admin/manage-reports/engagement-time"
                       class="text-grey-darker no-underline hover:text-orange-light pb-3 block">工作事項</a>
                </div>
            </dropdown-menu>
            <dropdown-menu v-cloak
                           name="客戶"
                           class="text-white h-12 flex items-center">
                <div slot="dropdown_content"
                     class="pt-3">
                    <a href="/admin/manage-clients"
                       class="text-grey-darker no-underline hover:text-orange-light pb-3 block">客戶</a>
                    <a href="/admin/manage-engagement-codes"
                       class="text-grey-darker no-underline hover:text-orange-light">工作事項</a>
                </div>
            </dropdown-menu>

            <a href="/admin/manage-users" class="text-white no-underline hover:text-orange mx-4">員工</a>
        @endif
        <dropdown-menu v-cloak
                       name="{{ Auth()->user()->name }}"
                       class="text-orange h-12 flex items-center">
            <div slot="dropdown_content"
                 class="pt-3">
                <p class="text-grey-darker pb-3 block">{{ auth()->user()->email }}</p>
                <a href="/admin/me"
                   class="text-grey-darker no-underline hover:text-orange-light pb-3 block">我的檔案</a>
                <a href="/admin/reset-password"
                   class="text-grey-darker no-underline hover:text-orange-light">更改密碼</a>
                @include('admin.partials.logout-form')
            </div>
        </dropdown-menu>
    </div>
</div>