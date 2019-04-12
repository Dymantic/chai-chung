<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">Time Tracking</p>
            <div class="flex justify-end">
                <button @click="showNewSessionForm = true"
                        class="btn btn-orange">New Session
                </button>
                <modal :show="showNewSessionForm"
                       @close="showNewSessionForm = false">
                    <new-session-form @cancel="showNewSessionForm = false"
                                     @session-created="sessionAdded"
                                      :client_list="clients"
                                      :engagements="engagements"
                                      :service_periods="service_periods"
                                      @close="showNewSessionForm = false"
                                      :open="showNewSessionForm"
                    ></new-session-form>
                </modal>
            </div>
        </div>
        <session-list :sessions="sessions" title="Recent Sessions" @session-selected="onSessionSelected"></session-list>
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
    import NewSessionForm from "./NewSessionForm";
    import SessionList from "./SessionList";
    import {notify} from "../notify";
    import StaffSession from "./StaffSession";

    export default {
        components: {
            NewSessionForm,
            SessionList,
            StaffSession
        },

        props: ['clients', 'engagements', 'service_periods'],

        data() {
            return {
                showNewSessionForm: false,
                sessions: [],
                selectedSession: null,
                showSelected: false,
            };
        },

        mounted() {
          window.addEventListener('keyup', ({target, key}) => {
              if(key === "s" && !['INPUT', 'TEXTAREA'].includes(target.tagName)) {
                  this.showNewSessionForm = true;
              }
          });

          this.fetchSessions().catch(() => notify.error({message: 'Unable to fetch recent sessions'}));
        },

        methods: {

            fetchSessions() {
              return new Promise((resolve, reject) => {
                  axios.get("/admin/sessions")
                      .then(({data}) => {
                          this.sessions = data;
                          resolve();
                      })
                      .catch(reject)
              });
            },

            sessionAdded() {
                this.fetchSessions()
                    .catch(() => notify.error({message: 'Unable to fetch recent sessions'}));
            },

            onSessionSelected(session) {
                this.showSelected = true;
                this.selectedSession = session;
            },

            removeSession() {
                notify.success({message: 'Session has been deleted'});
                this.fetchSessions()
                    .catch(() => notify.error({message: 'Unable to fetch recent sessions'}));
            },

            failedToDeleteSession() {
                notify.error({message: 'Failed to delete session'});
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">
    .recent-sessions {
        font-variant-numeric: tabular-nums;
    }
</style>