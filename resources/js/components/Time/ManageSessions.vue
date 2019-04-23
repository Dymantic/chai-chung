<template>
    <div>
        <div class="px-8 max-w-xl mb-8 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">Time Records</p>

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
                <div>
                    <p class="mb-3 font-bold text-navy">Staff member</p>
                    <select name="staff"
                            v-model="filters.staff"
                            class="py-2 w-40 block bg-white border h-8">
                        <option value="">All staff</option>
                        <option v-for="member in staff"
                                :key="member.id"
                                :value="member.id">{{ member.name }}
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
                      title="Staff Sessions"
                      @session-selected="onSessionSelected"
                      expanded="true"></session-list>
        <staff-session :open="showSelected"
                       :session="selectedSession"
                       @close="showSelected = false"
                       @session-deleted="removeSession"
                       @session-updated="onSessionUpdated"
                       @session-deleted-error="failedToDeleteSession"
                       v-if="selectedSession"

        ></staff-session>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../notify";
    import SessionList from "./SessionList";
    import StaffSession from "./StaffSession";
    import DatePicker from "vuejs-datepicker";
    import {subDays} from "date-fns";

    export default {
        components: {
            SessionList,
            StaffSession,
            DatePicker
        },

        props: ['staff', 'clients'],


        data() {
            return {
                sessions: [],
                showSelected: false,
                selectedSession: null,
                fetching: false,
                filters: {
                    from: subDays(new Date(), 14),
                    to: new Date(),
                    client: "",
                    staff: ""
                }
            };
        },

        computed: {
            query() {
                return `from=${this.filters.from.toISOString().slice(0, 10)}&to=${this.filters.to.toISOString().slice(0, 10)}&client_id=${this.filters.client ? this.filters.client : ''}&user_id=${this.filters.staff ? this.filters.staff : ''}`;
            }
        },

        mounted() {
            this.fetchSessions()
                .catch(notify.error);
        },

        methods: {
            fetchSessions() {
                this.fetching = true;
                return new Promise((resolve, reject) => {
                    axios.get(`/admin/staff-sessions?${this.query}`)
                         .then(({data}) => {
                             this.sessions = data;
                             resolve();
                         })
                         .catch(() => reject({message: 'Unable to fetch sessions'}))
                         .then(() => this.fetching = false);
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
                    client: "",
                    staff: ""
                };

                this.refreshSessions();
            },

            onSessionSelected(session) {
                this.selectedSession = session;
                this.showSelected = true;
            },

            onSessionUpdated() {
                notify.success({message: "Session data updated"});
                this.fetchSessions()
                    .catch(notify.error);
            },

            removeSession() {
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

<style scoped
       lang="less"
       type="text/css">

</style>