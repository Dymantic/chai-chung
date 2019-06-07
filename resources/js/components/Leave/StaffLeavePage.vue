<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">請假申請</p>
            <div class="flex justify-end">
                <button @click="showLeaveRequestForm = true"
                        class="btn btn-orange">請假細節填寫</button>
                <modal :show="showLeaveRequestForm"
                       @close="showLeaveRequestForm = false">
                    <leave-request-form @cancel="showLeaveRequestForm = false"
                                        @request-created="requestAdded"
                                        :users="userList"></leave-request-form>
                </modal>
            </div>
        </div>
        <div>
            <leave-request v-for="request in requests"
                           :request="request"
                           :key="request.id"
                           @request-cancelled="requestSuccessfullyCancelled"
                           @request-cancel-failed="requestFailedToCancel"
                           :users="userList"
                           @cover-rerequested="coveringUserUpdated"
                           @cover-rerequest-failed="coveringUserFailedToUpdate"
            ></leave-request>
            <big-notice v-if="fetched_requests && (requests.length === 0)"
                        text="You have no current or upcoming requests for leave">
            </big-notice>
        </div>
    </div>
</template>

<script type="text/babel">
    import LeaveRequestForm from "./LeaveRequestForm";
    import LeaveRequest from "./LeaveRequest";
    import {notify} from "../notify";
    import BigNotice from "../BigNotice";

    export default {
        components: {
            BigNotice,
            LeaveRequestForm,
            LeaveRequest
        },

        props: ['user-list'],

        data() {
            return {
                showLeaveRequestForm: false,
                requests: [],
                fetched_requests: false
            };
        },

        mounted() {
            this.fetchRequests()
                .catch(notify.error);
        },

        methods: {

            fetchRequests() {
                return new Promise((resolve, reject) => {
                    axios.get("/admin/leave-requests")
                         .then(({data}) => {
                             this.requests = data;
                             this.fetched_requests = true;
                             resolve();
                         })
                         .catch(() => reject({message: '系統無法讀取資料'}));
                });
            },

            refreshList() {
                this.fetchRequests()
                    .catch(notify.error);
            },

            requestSuccessfullyCancelled() {
                notify.success({message: '您的請假已成功取消'});
                this.refreshList();
            },

            requestFailedToCancel() {
                notify.error({message: '系統無法取消您的請假'});
                this.refreshList();
            },

            coveringUserUpdated() {
                notify.success({message: '您的請假已成功更新'});
                this.refreshList();
            },

            coveringUserFailedToUpdate() {
                notify.error({message: '系統無法更新資料'});
                this.refreshList();
            },

            requestAdded() {
                this.showLeaveRequestForm = false;
                notify.success({message: '您的請假申請已成功提交'});
                this.refreshList();
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>