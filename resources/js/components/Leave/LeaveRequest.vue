<template>
    <div class="bg-grey-lightest my-6 max-w-md mx-auto flex justify-between shadow">
        <div class="p-4">
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

            <p><strong>Reason:</strong> {{ request.reason }}</p>
            <p><strong>Covered by:</strong> {{ request.covered_by }}</p>
        </div>
        <div class="flex flex-col justify-between w-64 p-4 bg-white">
            <div>
                <p class="text-sm font-bold text-navy">Status:</p>
                <p>{{ status_text }}</p>
            </div>
            <div class="text-right mt-6">
                <button v-if="request.status === 'cover_rejected'"
                        @click="showCoverUserForm = true"
                        class="text-sm underline text-grey-darkest mr-4">Change sub
                </button>
                <modal :show="showCoverUserForm"
                       @close="showCoverUserForm = false">
                    <div class="p-4 w-full max-w-sm">
                        <p class="text-xs">Request for:</p>
                        <p class="text-lg font-bold text-navy mb-8">{{ leave_description }}</p>
                        <p>Select someone to cover for your leave:</p>
                        <select v-model="covering_user_id"
                                class="block h-8 border my-4 w-full">
                            <option v-for="user in users"
                                    :key="user.id"
                                    :value="user.id">{{ user.name }}
                            </option>
                        </select>
                        <div class="flex justify-end mt-8">
                            <button @click="showCoverUserForm = false"
                                    class="btn btn-white">Cancel
                            </button>
                            <button @click="updateRequest"
                                    class="btn btn-orange ml-4">Update sub.
                            </button>
                        </div>
                    </div>
                </modal>

                <button v-if="can_be_cancelled"
                        @click="showCancelForm = true"
                        class="text-sm underline text-grey-darkest">Cancel
                </button>
                <modal :show="showCancelForm"
                       @close="showCancelForm = false">
                    <div class="p-4 w-full max-w-sm">
                        <p class="text-xs">Request for:</p>
                        <p class="text-lg font-bold text-navy mb-8">{{ leave_description }}</p>
                        <p>Are you sure you want to cancel this leave request?</p>
                        <div class="flex justify-end mt-8">
                            <button @click="showCancelForm = false"
                                    class="btn btn-white">No, don't cancel
                            </button>
                            <button @click="cancelRequest"
                                    class="btn btn-orange ml-4">Yes, do it.
                            </button>
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
                    submitted: `Your request has been submitted and is waiting for ${this.request.covered_by} to agree to cover for you.`,
                    covered: `${this.request.covered_by} has agreed to cover for you. You are now waiting for your request to be accepted.`,
                    cover_rejected: `${this.request.covered_by} in not able to cover for you. You need to reselect someone to cover before your request can proceed.`,
                    accepted: `You request for leave was approved by ${this.request.decider}`,
                    denied: `You request for leave was denied by ${this.request.decider}`,
                    cancelled: `You cancelled this request.`,
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