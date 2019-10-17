<template>
    <div>
        <div class="px-8 max-w-xl mb-12 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">時間紀錄</p>
            <div class="flex justify-end">
<!--                <button @click="showNewSessionForm = true"-->
<!--                        class="btn btn-orange">新增紀錄</button>-->
<!--                <modal :show="showNewSessionForm"-->
<!--                       @close="showNewSessionForm = false">-->
<!--                    <new-session-form @cancel="showNewSessionForm = false"-->
<!--                                      @session-created="sessionAdded"-->
<!--                                      :client_list="clients"-->
<!--                                      :engagements="engagements"-->
<!--                                      :service_periods="service_periods"-->
<!--                                      @close="showNewSessionForm = false"-->
<!--                                      :open="showNewSessionForm"-->
<!--                    ></new-session-form>-->
<!--                </modal>-->
                <router-link class="no-underline btn btn-orange" to="/sessions/create">新增紀錄</router-link>
            </div>
        </div>
        <div class="max-w-xl mx-auto px-8">
            <div class="justify-between pt-8">
                <div class="shadow p-8">
                    <p class="mb-3 font-bold text-navy">日期</p>
                    <div class="flex items-center justify-between">
                        <div class="flex">
                            <div class="flex items-center mb-2">
                                <p class="text-center w-16">從: </p>
                                <date-picker class="p-2 border text-center"
                                             @selected="setStartDate"
                                             :value="initial_date_start"
                                ></date-picker>
                            </div>
                            <div class="flex items-center">
                                <p class="w-16 text-center">到: </p>
                                <date-picker class="p-2 border text-center"
                                             @selected="setEndDate"
                                             :value="initial_date_end"
                                ></date-picker>
                            </div>
                        </div>

                        <div>
                            <button type="button"
                                    class="btn btn-white mr-4"
                                    @click="resetSessions">清除
                            </button>
                            <button @click="fetchSessions"
                                    class="btn btn-orange"
                                    :class="{'opacity-50': fetching}">確認
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end items-center mt-20">
                <p class="mr-4 font-bold text-navy">客戶</p>
                <select name="client"
                        v-model="selected_client"
                        class="py-2 w-40 block bg-white border min-h-8">
                    <option value="">全部客戶</option>
                    <option v-for="client in clients"
                            :key="client.id"
                            :value="client.id">{{ client.name }}
                    </option>
                </select>
            </div>
        </div>
        <session-list :sessions="sessions"
                      title="時間紀錄"
                      :editable="true"
                      @session-selected="onSessionSelected"></session-list>
        <staff-session :open="showSelected"
                       :session="selectedSession"
                       @close="showSelected = false"
                       @session-deleted="removeSession"
                       @session-deleted-error="failedToDeleteSession"
                       v-if="selectedSession"
        ></staff-session>
        <big-notice v-if="sessions.length === 0"
                    text="沒有任何相關資料可顯示"
        ></big-notice>
    </div>
</template>

<script type="text/babel">
    import NewSessionForm from "./NewSessionForm";
    import SessionList from "./SessionList";
    import {notify} from "../notify";
    import StaffSession from "./StaffSession";
    import DatePicker from "vuejs-datepicker";
    import BigNotice from "../BigNotice";
    import {subDays} from "date-fns";

    export default {
        components: {
            BigNotice,
            NewSessionForm,
            SessionList,
            StaffSession,
            DatePicker
        },

        data() {
            return {
                showNewSessionForm: false,
                selectedSession: null,
                showSelected: false,
                fetching: false,
                initial_date_start: subDays(new Date(), 14),
                initial_date_end: new Date(),
                selected_client: '',
            };
        },

        computed: {

            sessions() {
                return this.$store.getters['userSessions/filteredByClient'](this.selected_client);
            },

            engagements() {
                return this.$store.state.userSessions.engagements;
            },

            service_periods() {
                return this.$store.state.userSessions.service_periods;
            },

            clients() {
                return this.$store.state.userSessions.clients;
            }
        },

        mounted() {
            window.addEventListener('keyup', this.reactToHotkey);

            this.fetchSessions();
        },

        destroyed() {
            window.removeEventListener('keyup', this.reactToHotkey);
        },

        methods: {

            reactToHotkey({target, key}) {
                if (key === "s" && !['INPUT', 'TEXTAREA'].includes(target.tagName)) {
                    this.$router.push('/sessions/create');
                }
            },

            setStartDate(date) {
              this.$store.commit('userSessions/start_date', date);
            },

            setEndDate(date) {
                this.$store.commit('userSessions/end_date', date);
            },

            fetchSessions() {
                this.$store.dispatch('userSessions/fetchSessions')
                    .catch(notify.error);
            },

            resetSessions() {
                this.$store.commit('userSessions/reset_dates');
                this.initial_date_start = subDays(new Date(), 14);
                this.initial_date_end = new Date();
                this.selected_client = '';

                this.fetchSessions();
            },

            sessionAdded() {
                this.fetchSessions()
                    .catch(() => notify.error({message: '系統無法顯示時間紀錄'}));
            },

            onSessionSelected(session) {
                this.showSelected = true;
                this.selectedSession = session;
            },

            removeSession() {
                notify.success({message: '時間紀錄已刪除'});
                this.fetchSessions()
                    .catch(() => notify.error({message: '系統無法顯示時間紀錄'}));
            },

            failedToDeleteSession() {
                notify.error({message: '時間紀錄無法刪除'});
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