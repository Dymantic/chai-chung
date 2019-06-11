<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <div>
                <p class="font-black text-5xl">{{ name }}</p>
                <p>{{ client_code }}</p>
                <p>NT${{ annual_revenue }}/yr</p>
            </div>

            <div class="flex justify-end">
                <button @click="showEditForm = true"
                        class="btn btn-orange">編輯</button>
                <modal :show="showEditForm"
                       @close="showEditForm = false">
                    <edit-client-form @cancel="showEditForm = false"
                                     @client-updated="updateClient"
                                      :client-id="client.id"
                                      :client-name="name"
                                      :annual-revenue="annual_revenue"
                    ></edit-client-form>
                </modal>
                <button @click="showDeleteForm = true"
                        class="btn btn-red ml-4"
                >刪除
                </button>
                <modal :show="showDeleteForm"
                       @close="showDeleteForm = false">
                    <div class="w-screen max-w-sm">
                        <p class="text-center py-2 bg-red text-white font-bold text-lg">刪除 {{ name }}?</p>
                        <div class="p-4">
                            <p>一旦系統刪除此客戶資料將無法回復，請您再次確認是否要執行刪除？</p>
                        </div>
                        <div class="flex justify-end p-4">
                            <button type="button"
                                    class="bg-grey text-navy px-4 py-2 rounded font-bold hover:bg-grey-darker shadow"
                                    @click="showDeleteForm = false">取消
                            </button>
                            <button class="bg-red text-white px-4 py-2 rounded font-bold hover:bg-orange-light shadow ml-4"
                                    @click="deleteClient">是的，確認刪除！
                            </button>
                        </div>
                    </div>

                </modal>
            </div>
        </div>
        <session-list :sessions="sessions"
                      title="最近紀錄"
                      :expanded="true"
                      @session-selected="onSessionSelected"
        ></session-list>
        <staff-session :open="showSelected"
                       :session="selectedSession"
                       @close="showSelected = false"
                       @session-deleted="fetchSessions"
                       @session-deleted-error="failedToDeleteSession"
                       v-if="selectedSession"
        ></staff-session>
    </div>
</template>

<script type="text/babel">
    import EditClientForm from "./EditClientForm";
    import {notify} from "../notify";
    import SessionList from "../Time/SessionList";
    import StaffSession from "../Time/StaffSession";

    export default {
        components: {
            EditClientForm,
            SessionList,
            StaffSession,
        },

        props: ['client'],

        data() {
            return {
                showEditForm: false,
                showDeleteForm: false,
                name: this.client.name,
                client_code: this.client.client_code,
                annual_revenue: this.client.annual_revenue,
                sessions: [],
                selectedSession: null,
                showSelected: false,
            };
        },

        mounted() {
            this.fetchSessions()
                .catch(notify.error);
        },

        methods: {
            updateClient({name, annual_revenue}) {
                this.showEditForm = false;
                this.name = name;
                this.annual_revenue = annual_revenue;

                notify.success({message: '客戶資料已成功更新'});
            },

            deleteClient() {
                axios.delete(`/admin/clients/${this.client.id}`)
                    .then(() => window.location = '/admin/manage-clients')
                     .catch(() => notify.error({message: '無法刪除此客戶資料'}));
            },

            fetchSessions() {
                return new Promise((resolve, reject) => {
                   axios.get(`/admin/clients/${this.client.id}/sessions`)
                       .then(({data}) => {
                           this.sessions = data;
                           resolve();
                       })
                       .catch(() => reject({message: '系統無法讀取資料'}));
                });
            },

            onSessionSelected(session) {
                this.selectedSession = session;
                this.showSelected = true;
            },

            failedToDeleteSession() {
                notify.error({message: '無法刪除時間紀錄'});
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>