<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">Requests for Time Off</p>
            <div class="flex justify-end">

            </div>
        </div>
        <div>
            <undecided-request v-for="request in requests"
                               :key="request.id"
                               :request="request"
                               @request-accepted="requestAccepted"
                               @request-denied="requestDenied"
                               @action-failed="requestActionError"
            ></undecided-request>
        </div>

    </div>
</template>

<script type="text/babel">
    import {notify} from "../notify";
    import UndecidedRequest from "./UndecidedRequest";

    export default {
        components: {UndecidedRequest},
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
                    axios.get("/admin/staff-leave-requests")
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
                notify.error({message: 'Error performing that action.'});
                this.refreshList();
            },

            requestAccepted() {
                notify.success({message: 'Request for leave accepted.'});
                this.refreshList();
            },

            requestDenied() {
                notify.success({message: 'Request for leave denied.'});
                this.refreshList();
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>