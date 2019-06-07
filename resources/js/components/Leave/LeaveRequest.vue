<template>
    <div class="bg-grey-lightest my-6 max-w-md mx-auto flex justify-between shadow">
        <div class="p-4">
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

            <p><strong>理由:</strong> {{ request.reason }}</p>
            <p><strong>代班:</strong> {{ request.covered_by }}</p>
        </div>
        <div class="flex flex-col justify-between w-64 p-4 bg-white">
            <div>
                <p class="text-sm font-bold text-navy">狀態:</p>
                <p>{{ status_text }}</p>
            </div>
            <div class="text-right mt-6">
                <button v-if="request.status === 'cover_rejected'"
                        @click="showCoverUserForm = true"
                        class="text-sm underline text-grey-darkest mr-4 hover:text-orange">更改代班人選</button>
                <modal :show="showCoverUserForm"
                       @close="showCoverUserForm = false">
                    <div class="p-4 w-full max-w-sm">
                        <p class="text-xs">請假時間</p>
                        <p class="text-lg font-bold text-navy mb-8">{{ leave_description }}</p>
                        <p>新的代班人選</p>
                        <select v-model="covering_user_id"
                                class="block h-8 border my-4 w-full">
                            <option v-for="user in users"
                                    :key="user.id"
                                    :value="user.id">{{ user.name }}
                            </option>
                        </select>
                        <div class="flex justify-end mt-8">
                            <button @click="showCoverUserForm = false"
                                    class="btn btn-white">取消
                            </button>
                            <button @click="updateRequest"
                                    class="btn btn-orange ml-4">確認更新</button>
                        </div>
                    </div>
                </modal>

                <button v-if="can_be_cancelled"
                        @click="showCancelForm = true"
                        class="text-sm underline text-grey-darkest hover:text-orange">取消請假
                </button>
                <modal :show="showCancelForm"
                       @close="showCancelForm = false">
                    <div class="p-4 w-full max-w-sm">
                        <p class="text-xs">請假時間</p>
                        <p class="text-lg font-bold text-navy mb-8">{{ leave_description }}</p>
                        <p>您確定要取消請假申請嗎？</p>
                        <div class="flex justify-end mt-8">
                            <button @click="showCancelForm = false"
                                    class="btn btn-white">改變心意不取消了！</button>
                            <button @click="cancelRequest"
                                    class="btn btn-orange ml-4">是的，我確定取消請假！</button>
                        </div>
                    </div>
                </modal>

            </div>

        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['request', 'users'],

        data() {
            return {
                showCancelForm: false,
                showCoverUserForm: false,
                covering_user_id: ''
            };
        },

        computed: {

            can_be_cancelled() {
                return this.request.status !== 'cancelled' && !this.request.has_past;
            },

            leave_description() {
                if (this.request.starts_date === this.request.ends_date) {
                    return this.request.starts_date;
                }

                return `${this.request.starts_date} - ${this.request.ends_date}`
            },

            status_class() {
                const classes = {
                    submitted: 'bg-white text-navy',
                    covered: 'bg-blue text-white',
                    cover_rejected: 'bg-orange text-white',
                    accepted: 'bg-green text-white',
                    denied: 'bg-red text-white',
                    cancelled: 'bg-grey text-white',
                };

                return classes[this.request.status];
            },

            status_text() {
                const statusMap = {
                    submitted: `您的請假已成功提交，正在等候${this.request.covered_by}回覆是否確認代班事宜。 `,
                    covered: `${this.request.covered_by}已確認幫您代班，目前正在等候請假申請批准。`,
                    cover_rejected: `${this.request.covered_by}無法幫您代班，請假申請通過之前請重新選擇代班人選。`,
                    accepted: `${this.request.decider}已批准您的請假申請。`,
                    denied: `${this.request.decider}無法批准您的請假申請。`,
                    cancelled: `您已經取消本次請假。`,
                };

                return statusMap[this.request.status];
            }
        },

        methods: {
            cancelRequest() {
                axios.post("/admin/cancelled-leave-requests", {leave_request_id: this.request.id})
                     .then(() => this.$emit('request-cancelled'))
                     .catch(() => this.$emit('request-cancel-failed'))
                     .then(() => this.showCancelForm = false)
            },

            updateRequest() {
                axios.post(`/admin/leave-requests/${this.request.id}`, {covering_user_id: this.covering_user_id})
                    .then(() => this.$emit('cover-rerequested'))
                    .catch(() => this.$emit('cover-rerequest-failed'))
                    .then(() => this.showCoverUserForm = false);
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>