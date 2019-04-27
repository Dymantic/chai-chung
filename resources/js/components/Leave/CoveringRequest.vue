<template>
    <div class="max-w-md mx-auto bg-grey-lightest my-8 p-4 shadow">
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
        <div class="flex justify-end mt-6">
            <button :disabled="waiting" :class="{'opacity-50': waiting}" class="" @click="rejectRequest">Reject</button>
            <button :disabled="waiting" :class="{'opacity-50': waiting}" class="ml-4" @click="acceptRequest">Accept</button>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['request'],

        data() {
            return {
                waiting: false,
            };
        },

        methods: {

            rejectRequest() {
                this.waiting = true;
                axios.post("/admin/cover-rejected-leave-requests", {
                    leave_request_id: this.request.id
                })
                    .then(() => this.$emit('request-rejected'))
                    .catch(() => this.$emit('action-failed'))
                    .then(() => this.waiting = false);
            },

            acceptRequest() {
                this.waiting = true;
                axios.post("/admin/covered-leave-requests", {
                    leave_request_id: this.request.id
                })
                     .then(() => this.$emit('request-covered'))
                     .catch(() => this.$emit('action-failed'))
                     .then(() => this.waiting = false);
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>