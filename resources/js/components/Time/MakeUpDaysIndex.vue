<template>
    <div>
        <div class="bg-pale-baby-blue-light p-2">
            <div class="flex items-center justify-between pb-4 px-4">
                <p class="text-navy text-2xl font-black">補班日</p>
                <new-make-up-day-form @mud-added="makeUpDayAdded"
                                      @mud-creation-failure="failedToAddMakeUpDay"></new-make-up-day-form>
            </div>

            <overtime-days-calendar-year v-for="year in years"
                                         :key="year.year"
                                         :year="year"
                                         @days-deleted="daysDeleted"
                                         @days-deleting-fail="failedToDelete"
                                         delete-url="/admin/make-up-days"
                                         class="px-4"
            ></overtime-days-calendar-year>

        </div>
    </div>
</template>

<script type="text/babel">
    import NewMakeUpDayForm from "./NewMakeUpDayForm";
    import {notify} from "../notify";
    import {groupDaysByYear} from "../../lib/time_helpers";
    import OvertimeDaysCalendarYear from "./OvertimeDaysCalendarYear";

    export default {
        components: {
            OvertimeDaysCalendarYear,
            NewMakeUpDayForm,
        },

        data() {
            return {
                make_up_days: []
            };
        },

        computed: {
            years() {
                return groupDaysByYear(this.make_up_days);
            }
        },

        mounted() {
            this.fetchDays()
                .catch(() => notify.error({message: '系統無法顯示補班日期'}));
        },

        methods: {

            fetchDays() {
                return new Promise((resolve, reject) => {
                    axios.get("/admin/make-up-days")
                         .then(({data}) => {
                             this.make_up_days = data;
                             resolve();
                         })
                         .catch(reject);
                });
            },

            makeUpDayAdded() {
                notify.success({message: '補班日期已成功新增儲存'});
                this.fetchDays()
                    .catch(() => notify.error({message: '系統無法顯示補班日期'}));
            },

            failedToAddMakeUpDay() {
                notify.error({message: '補班日期無法新增儲存'});
            },

            daysDeleted() {
                notify.success({message: '補班日期已刪除'});
                this.fetchDays()
                    .catch(() => notify.error({message: '系統無法顯示補班日期'}));
            },

            failedToDelete() {
                notify.error({message: '補班日期無法刪除'});
                this.fetchDays()
                    .catch(() => notify.error({message: '系統無法顯示補班日期'}));
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>