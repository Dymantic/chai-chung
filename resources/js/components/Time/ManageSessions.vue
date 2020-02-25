<template>
    <div>
        <div class="px-8 max-w-xl mb-8 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">員工時數紀錄</p>

        </div>
        <div class="max-w-xl mx-auto px-8">
            <p class="text-2xl font-bold text-navy">篩選:</p>
            <div class="flex justify-between pt-8">
                <div>
                    <p class="mb-3 font-bold text-navy">日期</p>
                    <div class="flex items-center mb-2">
                        <p class="text-center w-16">從: </p>
                        <date-picker class="p-2 border text-center"
                                     v-model="filters.from"></date-picker>
                    </div>
                    <div class="flex items-center">
                        <p class="w-16 text-center">到: </p>
                        <date-picker class="p-2 border text-center"
                                     v-model="filters.to"></date-picker>
                    </div>
                </div>
                <div>
                    <p class="mb-3 font-bold text-navy">客戶</p>
                    <select name="client"
                            v-model="filters.client"
                            class="py-2 w-40 block bg-white border min-h-8">
                        <option value="">全部客戶</option>
                        <option v-for="client in clients"
                                :key="client.id"
                                :value="client.id">{{ client.name }}
                        </option>
                    </select>
                </div>
                <div>
                    <p class="mb-3 font-bold text-navy">員工</p>
                    <select name="staff"
                            v-model="filters.staff"
                            class="py-2 w-40 block bg-white border min-h-8">
                        <option value="">全部員工</option>
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
                        @click="resetSessions">清除
                </button>
                <button @click="refreshSessions"
                        class="btn btn-orange"
                        :class="{'opacity-50': fetching}">確認
                </button>
            </div>
        </div>

        <session-list :sessions="sessions"
                      title="員工時數紀錄"
                      @session-selected="onSessionSelected"
                      :download-url="`/admin/exports/reports/timesheet?${exportQuery}`"
                      expanded="true"/>
        <staff-session :open="showSelected"
                       :session="selectedSession"
                       @close="showSelected = false"
                       @session-deleted="removeSession"
                       @session-updated="onSessionUpdated"
                       @session-deleted-error="failedToDeleteSession"
                       v-if="selectedSession"

        />
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
            },

            exportQuery() {
                const start = this.filters.from.toISOString().slice(0, 10);
                const end = this.filters.to.toISOString().slice(0, 10);
                const user = this.filters.staff;
                const client = this.filters.client;

                if((!user) && (!client)) {
                    return `start=${start}&end=${end}`
                }

                if((user) && (!client)) {
                    return `start=${start}&end=${end}&user_id=${user}`;
                }

                if((!user) && (client)) {
                    return `start=${start}&end=${end}&client_id=${client}`;
                }

                return `start=${start}&end=${end}&client_id=${client}&user_id=${user}`;
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
                         .catch(() => reject({message: '系統無法顯示時間紀錄'}))
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
                notify.success({message: "時間紀錄資料已更新"});
                this.fetchSessions()
                    .catch(notify.error);
            },

            removeSession() {
                notify.success({message: "時間紀錄資料已刪除"});
                this.fetchSessions()
                    .catch(notify.error);
            },

            failedToDeleteSession() {
                notify.error({message: "時間紀錄資料無法刪除"});
            },
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>
