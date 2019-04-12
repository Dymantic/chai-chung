<template>
    <div class="my-20 max-w-lg mx-auto">
        <p class="text-xl font-bold text-navy">{{ title }}</p>
        <div class="recent-sessions max-w-md mx-auto">
            <div v-for="day, index in session_days"
                 :key="index">
                <p class="font-bold text-navy my-4">{{ day.date }}</p>
                <div v-for="session in day.sessions"
                     :key="session.id"
                     class="px-4 py-2 bg-pale-baby-blue mx-auto flex items-center text-sm">
                        <p class="w-40 font-bold text-grey-dark">{{ session.start_time }} - {{ session.end_time }}</p>
                        <p @click="$emit('session-selected', session)" class="text-navy hover:text-orange cursor-pointer text-lg flex-1">{{ session.client_name }}</p>
                        <p class="w-40 font-bold text-grey-dark">{{ session.duration }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import {sortSessionsByTimeOfDay} from "../../lib/time_helpers";

    export default {
        props: ['sessions', 'title'],

        computed: {

            session_days() {
                let days = this.sessions.reduce((accum, session) => {
                    if (accum[session.date_comp]) {
                        accum[session.date_comp].sessions.push(session);
                    } else {
                        accum[session.date_comp] = {date: session.date, sessions: [session]};
                    }
                    return accum;
                }, {});

                return Object.keys(days)
                             .sort((a, b) => b - a)
                             .map(key => days[key])
                             .map(day => {
                                 day.sessions = day.sessions.sort(sortSessionsByTimeOfDay);
                                 return day;
                             });
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>