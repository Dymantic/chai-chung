<template>
    <div class="my-4">
        <div @click="open = !open" class="flex items-center">
            <span class="text-2xl font-black text-navy">{{ year.year }}</span>
            <svg :class="{'rotate': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" class="ml-2 fill-current"><path d="M9.3 8.7a1 1 0 0 1 1.4-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.4-1.4l3.29-3.3-3.3-3.3z"/></svg>
        </div>
        <div v-show="open">
            <div class="flex justify-end">
                <button :disabled="selected_days.length === 0" @click="deleteDays" class="font-bold text-sm" :class="{'opacity-50': selected_days.length === 0}">Delete Selected Days</button>
            </div>
            <overtime-day v-for="day in year.days" :key="day.id" :day="day" :selected="selected_days.includes(day.id)" @day-selected="toggleSelectedDay"></overtime-day>
        </div>
    </div>
</template>

<script type="text/babel">
    import OvertimeDay from "./OvertimeDay";

    export default {
        components: {
            OvertimeDay
        },

        props: ['year', 'delete-url'],

        data() {
            return {
                open: this.year.year === new Date().getFullYear(),
                selected_days: []
            };
        },

        methods: {
            toggleSelectedDay(id) {
                if(this.selected_days.includes(id)) {
                    return this.selected_days.splice(this.selected_days.indexOf(id), 1);
                }

                this.selected_days.push(id);
            },

            deleteDays() {
                const awaiting = this.selected_days.map(day => axios.delete(`${this.deleteUrl}/${day}`));

                Promise.all(awaiting)
                       .then(() => {
                           this.$emit('days-deleted');
                           this.selected_days = [];
                       })
                       .catch(() => this.$emit('days-deleting-fail'));
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">
    svg {
        transform-origin: center;
        transition: .5s;
    }
    .rotate {
        transform: rotate(90deg);
    }
</style>