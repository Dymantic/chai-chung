<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">Leave</p>
            <div class="flex justify-end">
                <button @click="showLeaveRequestForm = true"
                        class="btn btn-orange">Request Leave
                </button>
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
        </div>
    </div>
</template>

<script type="text/babel">
    import LeaveRequestForm from "./LeaveRequestForm";
    import LeaveRequest from "./LeaveRequest";
    import {notify} from "../notify";

    export default {
        components: {
            LeaveRequestForm,
            LeaveRequest
        },

        props: ['user-list'],

        data() {
            return {
                showLeaveRequestForm: false,
                requests: []
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
                             resolve();
                         })
                         .catch(() => reject({message: 'Failed to fetch your leave requests'}));
                });
            },

            refreshList() {
                this.fetchRequests()
                    .catch(notify.error);
            },

            requestSuccessfullyCancelled() {
                notify.success({message: 'Your request has been cancelled'});
                this.refreshList();
            },

            requestFailedToCancel() {
                notify.error({message: 'Your request was not cancelled'});
                this.refreshList();
            },

            coveringUserUpdated() {
                notify.success({message: 'Your request has been updated'});
                this.refreshList();
            },

            coveringUserFailedToUpdate() {
                notify.error({message: 'The covering user was not updated'});
                this.refreshList();
            },

            requestAdded() {
                this.showLeaveRequestForm = false;
                notify.success({message: 'Your application has been submitted'});
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>