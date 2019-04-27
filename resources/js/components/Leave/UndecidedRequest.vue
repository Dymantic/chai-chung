<template>
    <div class="mx-auto max-w-md bg-grey-lightest shadow my-8 p-4">
        <p class="mb-4"><strong>Requested By: </strong>{{ request.requestee }}</p>

        <div class="flex mb-8">
            <div class="mr-8">
                <p class="text-sm">From</p>
                <p class="text-lg font-bold text-navy">{{ request.starts_date }}</p>
                <p class="text-sm text-grey-dark">{{ request.starts_day }} ({{ request.starts_time }})</p>
            </div>
            <div>
                <p class="text-sm">To</p>
                <p class="text-lg font-bold text-navy">{{ request.ends_date }}</p>
                <p class="text-sm text-grey-dark">{{ request.ends_day }} ({{ request.ends_time }})</p>
            </div>
        </div>
        <p class="mb-4"><strong>Covered By: </strong>{{ request.covered_by }}</p>
        <p class="mb-4" v-if="request.reason !== ''"><strong>Reason: </strong>{{ request.reason }}</p>

        <div class="flex justify-end mt-6">
            <button :disabled="waiting" :class="{'opacity-50': waiting}" class="" @click="denyRequest">Deny</button>
            <button :disabled="waiting" :class="{'opacity-50': waiting}" class="ml-4" @click="approveRequest">Approve</button>
    </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['request'],

        data() {
            return {
                waiting: false
            };
        },

        methods: {

            denyRequest() {
                this.waiting = true;
                axios.post("/admin/denied-leave-requests", {
                    leave_request_id: this.request.id
                })
                     .then(() => this.$emit('request-denied'))
                     .catch(() => this.$emit('action-failed'))
                     .then(() => this.waiting = false);
            },

            approveRequest() {
                this.waiting = true;
                axios.post("/admin/accepted-leave-requests", {
                    leave_request_id: this.request.id
                })
                     .then(() => this.$emit('request-accepted'))
                     .catch(() => this.$emit('action-failed'))
                     .then(() => this.waiting = false);
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>