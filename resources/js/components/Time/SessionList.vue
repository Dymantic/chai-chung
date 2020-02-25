<template>
    <div class="my-20 max-w-lg mx-auto">
        <div class="flex justify-between">
            <p class="text-xl font-bold text-navy">{{ title }}</p>
            <a v-if="downloadUrl" :href="downloadUrl" class="font-bold text-orange hover:underline">下載 XLSX</a>
        </div>
        <div class="recent-sessions mx-auto" :class="expanded ? 'max-w-lg' : 'max-w-md'">
            <div v-for="day, index in session_days"
                 :key="index">
                <p class="font-bold text-navy my-4">{{ day.date }}</p>
                <session-list-row v-for="session in day.sessions"
                                  :session="session"
                                  :key="session.id"
                                  :expanded="expanded"
                                  :editable="editable"
                                  @session-selected="sessionSelected">
                </session-list-row>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import {sortSessionsByTimeOfDay} from "../../lib/time_helpers";
    import SessionListRow from "./SessionListRow";

    export default {
        components: {
            SessionListRow
        },

        props: ['sessions', 'title', 'expanded', 'editable', 'download-url'],

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
        },

        methods: {
            sessionSelected(session) {
                this.$emit('session-selected', session);
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>
