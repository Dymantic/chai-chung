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
        <div class="max-w-xl mx-auto px-8">
            <p class="text-2xl font-bold text-navy">Filter:</p>
            <div class="flex justify-between pt-8">
                <div>
                    <p class="mb-3 font-bold text-navy">Dates</p>
                    <div class="flex items-center mb-2">
                        <p class="text-center w-16">From: </p>
                        <date-picker class="p-2 border text-center"
                                     v-model="filters.from"></date-picker>
                    </div>
                    <div class="flex items-center">
                        <p class="w-16 text-center">To: </p>
                        <date-picker class="p-2 border text-center"
                                     v-model="filters.to"></date-picker>
                    </div>
                </div>
                <div>
                    <p class="mb-3 font-bold text-navy">Client</p>
                    <select name="client"
                            v-model="filters.client"
                            class="py-2 w-40 block bg-white border h-8">
                        <option value="">All clients</option>
                        <option v-for="client in clients"
                                :key="client.id"
                                :value="client.id">{{ client.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="text-right mt-4">
                <button type="button"
                        class="btn btn-white mr-4"
                        @click="resetSessions">Reset
                </button>
                <button @click="refreshSessions"
                        class="btn btn-orange"
                        :class="{'opacity-50': fetching}">Filter
                </button>
            </div>
        </div>
        <session-list :sessions="sessions"
                      title="Time Records"
                      @session-selected="onSessionSelected"></session-list>
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
    import {subDays} from "date-fns";
    import DatePicker from "vuejs-datepicker";

    export default {
        components: {
            NewSessionForm,
            SessionList,
            StaffSession,
            DatePicker
        },

        props: ['clients', 'engagements', 'service_periods'],

        data() {
            return {
                showNewSessionForm: false,
                sessions: [],
                selectedSession: null,
                showSelected: false,
                fetching: false,
                filters: {
                    from: subDays(new Date(), 14),
                    to: new Date(),
                    client: ''
                }
            };
        },

        computed: {
            query() {
                return `from=${this.filters.from.toISOString().slice(0, 10)}&to=${this.filters.to.toISOString().slice(0, 10)}&client_id=${this.filters.client ? this.filters.client : ''}`;
            }
        },

        mounted() {
            window.addEventListener('keyup', ({target, key}) => {
                if (key === "s" && !['INPUT', 'TEXTAREA'].includes(target.tagName)) {
                    this.showNewSessionForm = true;
                }
            });

            this.fetchSessions().catch(notify.error);
        },

        methods: {

            fetchSessions() {
                return new Promise((resolve, reject) => {
                    axios.get(`/admin/sessions?${this.query}`)
                         .then(({data}) => {
                             this.sessions = data;
                             resolve();
                         })
                         .catch(() => reject({message: 'Unable to fetch sessions'}));
                });
            },

            refreshSessions() {
                this.fetchSessions()
                    .catch(notify.error);
            },

            resetSessions() {
                this.filters = {
                    from: subDays(new Date(), 14),
                    to: new Date(),
                    client: ''
                };
                this.refreshSessions();
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

<style scoped
       lang="less"
       type="text/css">
    .recent-sessions {
        font-variant-numeric: tabular-nums;
    }
</style>