<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">代班請求</p>
            <div class="flex justify-end">

            </div>
        </div>
        <div>
            <covering-request v-for="request in requests"
                              :key="request.id"
                              :request="request"
                              @request-rejected="requestRejected"
                              @request-covered="requestCovered"
                              @action-failed="requestActionError"
            ></covering-request>
            <big-notice v-if="fetched_requests && (requests.length === 0)"
                        text="Nobody is asking you to cover for them at the moment."
            ></big-notice>
        </div>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../notify";
    import CoveringRequest from "./CoveringRequest";
    import BigNotice from "../BigNotice";

    export default {

        components: {
            BigNotice,
            CoveringRequest
        },

        data() {
            return {
                requests: [],
                fetched_requests: false,
            };
        },

        mounted() {
            this.refreshList();
        },

        methods: {

            fetchRequests() {
                return new Promise((resolve, reject) => {
                    axios.get("/admin/user-covering-requests")
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

            requestActionError() {
                notify.error({message: '系統無法存取資料'});
                this.refreshList();
            },

            requestRejected() {
                notify.success({message: '已拒絕代班'});
                this.refreshList();
            },

            requestCovered() {
                notify.success({message: '已接受代班'});
                this.refreshList();
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>