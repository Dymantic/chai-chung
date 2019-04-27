<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">Cover requests</p>
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
        </div>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../notify";
    import CoveringRequest from "./CoveringRequest";

    export default {

        components: {
            CoveringRequest
        },

        data() {
            return {
                requests: []
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
                             resolve();
                         })
                         .catch(() => reject({message: 'Unable to fetch covering requests'}));
                });
            },

            refreshList() {
                this.fetchRequests()
                    .catch(notify.error);
            },

            requestActionError() {
                notify.error({message: 'Unable to perform request'});
                this.refreshList();
            },

            requestRejected() {
                notify.success({message: 'Request has been rejected'});
                this.refreshList();
            },

            requestCovered() {
                notify.success({message: 'You have agreed to cover the request'});
                this.refreshList();
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>