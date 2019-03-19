<template>
    <span class="ml-4 pt-1">
        <svg @click="showEditForm = true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" class="text-grey hover:text-orange"><path class="fill-current" d="M6.3 12.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H7a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM8 16h2.59l9-9L17 4.41l-9 9V16zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h6a1 1 0 0 1 0 2H4v14h14v-6z"/></svg>
        <modal :show="showEditForm" @close="showEditForm = false">
            <div class="max-w-sm w-full mx-auto p-8">
                <form action="" @submit.prevent="updateRate">
                    <p class="mb-6 text-navy text-lg">Update the hourly rate for {{ userName }}</p>
                    <p class="my-4 text-red">{{ error }}</p>
                    <div>
                        <label class="text-sm navy-bold text-navy" for="hourly_rate">Hourly Rate NT$</label>
                        <input class="bg-grey-light py-2" type="text" id="hourly_rate" name="hourly_rate" v-model="rate">
                        <span>/hr</span>
                    </div>
                    <div class="flex justify-end mt-8">
                        <button class="btn btn-white mr-4" type="button" @click="showEditForm = false">Cancel</button>
                        <button :disabled="waiting" class="btn btn-orange" type="submit">
                            <span v-if="waiting">Updating...</span>
                            <span v-else>Update Rate</span>
                        </button>
                    </div>
                </form>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    export default {
        props: ['current-rate', 'user-name', 'user-id'],
        data() {
            return {
                rate: null,
                showEditForm: false,
                waiting: false,
                error: '',
            };
        },
        mounted() {
            this.rate = this.currentRate;
        },
        methods: {
            updateRate() {
                this.waiting = true;
                this.error = '';
                axios.post(`/admin/users/${this.userId}/rate`, {hourly_rate: this.rate})
                    .then(({data}) => this.onRateUpdated(data.hourly_rate))
                    .catch(err => this.handleError(err.response))
                    .then(() => this.waiting = false);
            },

            onRateUpdated(hourly_rate) {
                this.$emit('rate-updated', {hourly_rate});
                this.showEditForm = false;
            },

            handleError({status}) {
                console.log(status);
                if(status === 422) {
                     return this.error = 'The value you entered is not valid. Please enter a positive integer.';
                }

                this.error = 'There was a problem updating the rate. Please refresh and try again.';
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>