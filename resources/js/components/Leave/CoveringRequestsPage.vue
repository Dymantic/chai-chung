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
                        text="目前沒有任何代班請求"
            ></big-notice>
        </div>
        <div class="max-w-lg mx-auto py-20">
            <p class="text-2xl font-black">已接受的代班請求:</p>
            <agreed-cover v-for="leave in covering" :key="leave.id" :request="leave"></agreed-cover>
            <big-notice v-if="fetched_covering && (covering.length === 0)"
                        text="您近期無需代班"
            ></big-notice>
        </div>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../notify";
    import CoveringRequest from "./CoveringRequest";
    import BigNotice from "../BigNotice";
    import AgreedCover from "./AgreedCover";

    export default {

        components: {
            AgreedCover,
            BigNotice,
            CoveringRequest
        },

        data() {
            return {
                requests: [],
                covering: [],
                fetched_covering: false,
                fetched_requests: false,
            };
        },

        mounted() {
            this.refreshList();
            this.refreshCoveringList();
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

            fetchCovering() {
                return new Promise((resolve, reject) => {
                    axios.get("/admin/user-agreed-to-cover")
                         .then(({data}) => {
                             this.covering = data;
                             this.fetched_covering = true;
                             resolve();
                         })
                         .catch(() => reject({message: '系統無法讀取資料'}));
                });
            },

            refreshList() {
                this.fetchRequests()
                    .catch(notify.error);
            },

            refreshCoveringList() {
                this.fetchCovering()
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
                this.refreshCoveringList();
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>