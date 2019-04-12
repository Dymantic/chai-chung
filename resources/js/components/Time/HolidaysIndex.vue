<template>
    <div class="bg-pale-baby-blue-light p-2">
        <div class="flex items-center justify-between pb-4 px-4">
            <p class="text-navy text-2xl font-black">Holidays</p>
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
                .catch(() => notify.error({message: 'Problem fetching holidays.'}));
        },

        methods: {
            holidayAdded() {
                notify.success({message: 'A new holiday has been added'});
                this.fetchHolidays()
                    .catch(() => notify.error({message: 'Problem fetching holidays.'}));
            },

            failedToAddHoliday() {
                notify.error({message: 'Unable to add holiday. Please try again later.'});
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
                notify.success({message: "Holidays have been deleted"});
                this.fetchHolidays().catch(() => notify.error({message: 'Unable to fetch holidays'}));
            },

            failedToDelete() {
                notify.error({message: 'Failed to delete some holidays'});
                this.fetchHolidays().catch(() => notify.error({message: 'Unable to fetch holidays'}));
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>