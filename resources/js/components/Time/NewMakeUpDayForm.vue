<template>
    <div>
        <button @click="open = true" class="font-bold text-navy underline hover:text-orange">+ Make Up Day</button>
        <modal :show="open" @close="open = false">
            <form action="" class="w-80 mx-auto" @submit.prevent="submit">
                <p class="text-lg pt-2 text-navy font-bold text-center">Add a new Make up day</p>
                <div class="p-4">
                    <p class="my-4 text-red" v-show="error_msg">{{ error_msg }}</p>
                    <div>
                        <label for="">Date:</label>
                        <date-picker v-model="date"></date-picker>
                    </div>
                    <div class="my-4">
                        <label for="reason">Description:</label>
                        <input type="text" id="reason" name="reason" v-model="reason" class="block w-full border mt-2 h-8">
                    </div>
                    <div class="mt-8 flex justify-end">
                        <button type="button" @click="open = false" class="btn btn-white">Cancel</button>
                        <button type="submit" class="btn btn-orange ml-4">Submit</button>
                    </div>
                </div>
            </form>
        </modal>
    </div>
</template>

<script type="text/babel">
    import DatePicker from "vuejs-datepicker";

    export default {
        components: {
            DatePicker
        },

        data() {
            return {
                open: false,
                date: new Date(),
                reason: '',
                error_msg: ''
            };
        },

        methods: {
            submit() {
                this.error_msg = '';

                axios.post("/admin/make-up-days", {date: this.date.toISOString().slice(0,10), reason: this.reason})
                    .then(() => this.dayAdded())
                    .catch(({response}) => this.failedToSave(response));
            },

            dayAdded() {
                this.open = false;
                this.date = new Date();
                this.reason = '';
                this.$emit('mud-added');
            },

            failedToSave({status}) {
                if(status === 422) {
                    return this.error_msg = 'Your input is not valid. Please check and retry.';
                }

                this.open = false;
                this.$emit('mud-creation-failed');
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>