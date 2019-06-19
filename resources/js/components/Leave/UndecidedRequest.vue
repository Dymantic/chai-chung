<template>
    <div class="mx-auto max-w-md bg-grey-lightest shadow my-8 p-4">
        <p class="mb-4"><strong>姓名: </strong>{{ request.requestee }}</p>

        <div class="flex mb-8">
            <div class="mr-8">
                <p class="text-sm">開始</p>
                <p class="text-lg font-bold text-navy">{{ request.starts_date }}</p>
                <p class="text-sm text-grey-dark">{{ request.starts_day }} ({{ request.starts_time }})</p>
            </div>
            <div>
                <p class="text-sm">結束</p>
                <p class="text-lg font-bold text-navy">{{ request.ends_date }}</p>
                <p class="text-sm text-grey-dark">{{ request.ends_day }} ({{ request.ends_time }})</p>
            </div>
        </div>
        <p class="mb-4"><strong>代班: </strong>{{ request.covered_by }}</p>
        <p class="mb-4"><strong>請假類型: </strong>{{ request.leave_type }}</p>
        <p class="mb-4" v-if="request.reason !== ''"><strong>理由: </strong>{{ request.reason }}</p>

        <div class="flex justify-end mt-6">
            <button :disabled="waiting" :class="{'opacity-50': waiting}" class="hover:text-orange" @click="denyRequest">拒絕</button>
            <button :disabled="waiting" :class="{'opacity-50': waiting}" class="ml-4 hover:text-orange" @click="approveRequest">批准</button>
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