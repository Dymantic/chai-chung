<template>
    <div>
        <div class="bg-pale-baby-blue-light p-2">
            <div class="flex items-center justify-between pb-4 px-4">
                <p class="text-navy text-2xl font-black">Make Up Days</p>
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
                .catch(() => notify.error({message: 'Unable to fetch make up days'}));
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
                notify.success({message: 'A new make up day has been added'});
                this.fetchDays()
                    .catch(() => notify.error({message: 'Problem fetching make up days.'}));
            },

            failedToAddMakeUpDay() {
                notify.error({message: 'Unable to create new make up day'});
            },

            daysDeleted() {
                notify.success({message: 'Make up days have been deleted'});
                this.fetchDays()
                    .catch(() => notify.error({message: 'Problem fetching make up days.'}));
            },

            failedToDelete() {
                notify.error({message: 'Problem deleting days'});
                this.fetchDays()
                    .catch(() => notify.error({message: 'Problem fetching make up days.'}));
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>