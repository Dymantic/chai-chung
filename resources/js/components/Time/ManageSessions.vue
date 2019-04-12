<template>
    <div>
        <session-list :sessions="sessions" title="Staff Sessions" @session-selected="onSessionSelected"></session-list>
        <staff-session :open="showSelected"
                       :session="selectedSession"
                       @close="showSelected = false"
                       @session-deleted="removeSession"
                       @session-deleted-error="failedToDeleteSession"
                       v-if="selectedSession"
        ></staff-session>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../notify";
    import SessionList from "./SessionList";
    import StaffSession from "./StaffSession";

    export default {
        components: {
            SessionList,
            StaffSession,
        },

        data() {
            return {
                sessions: [],
                showSelected: false,
                selectedSession: null
            };
        },

        mounted() {
            this.fetchSessions()
                .catch(notify.error);
        },

        methods: {
            fetchSessions() {
                return new Promise((resolve, reject) => {
                    axios.get("/admin/staff-sessions")
                        .then(({data}) => {
                            this.sessions = data;
                            resolve();
                        })
                        .catch(() => reject({message: 'Unable to fetch sessions'}));
                });
            },

            onSessionSelected(session) {
                this.selectedSession = session;
                this.showSelected = true;
            },

            removeSesion() {
                notify.success({message: "Session has been deleted"});
                this.fetchSessions()
                    .catch(notify.error);
            },

            failedToDeleteSession() {
                notify.error({message: "Unable to delete session"});
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>