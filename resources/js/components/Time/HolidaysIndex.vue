<template>
    <div class="bg-pale-baby-blue-light p-2">
        <div class="flex items-center justify-between pb-4 px-4">
            <p class="text-navy text-2xl font-black">國定假日</p>
            <new-holiday-form @holiday-added="holidayAdded"
                              @holiday-creation-failure="failedToAddHoliday"></new-holiday-form>
        </div>

        <overtime-days-calendar-year v-for="year in years"
                                     :key="year.year"
                                     :year="year"
                                     delete-url="/admin/holidays"
                                     @days-deleted="daysDeleted"
                                     @days-deleting-fail="failedToDelete"
                                     class="px-4"
        ></overtime-days-calendar-year>

    </div>
</template>

<script type="text/babel">
    import NewHolidayForm from "./NewHolidayForm";
    import OvertimeDaysCalendarYear from "./OvertimeDaysCalendarYear";
    import {notify} from "../notify";
    import {groupDaysByYear} from "../../lib/time_helpers";

    export default {
        components: {
            NewHolidayForm,
            OvertimeDaysCalendarYear
        },

        data() {
            return {
                holidays: [],
                showNewHolidayForm: false,
            };
        },

        computed: {
            years() {
                return groupDaysByYear(this.holidays);
            }
        },

        mounted() {
            this.fetchHolidays()
                .catch(() => notify.error({message: '系統無法顯示節日'}));
        },

        methods: {
            holidayAdded() {
                notify.success({message: '節日已成功新增儲存'});
                this.fetchHolidays()
                    .catch(() => notify.error({message: '系統無法顯示節日'}));
            },

            failedToAddHoliday() {
                notify.error({message: '節日無法新增儲存'});
            },

            fetchHolidays() {
                return new Promise((resolve, reject) => {
                    axios.get("/admin/holidays")
                         .then(({data}) => {
                             this.holidays = data;
                             resolve();
                         })
                         .catch(reject);
                });
            },

            daysDeleted() {
                notify.success({message: "節日已刪除"});
                this.fetchHolidays().catch(() => notify.error({message: '系統無法顯示節日'}));
            },

            failedToDelete() {
                notify.error({message: '無法刪除節日'});
                this.fetchHolidays().catch(() => notify.error({message: '系統無法顯示節日'}));
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>