<template>
    <div class="">
        <button class="font-bold text-navy underline hover:text-orange" @click="open = true">新增節日</button>
        <modal :show="open" @close="open = false">
            <div class="w-screen max-w-sm mx-auto">
                <p class="text-lg font-bold text-navy text-center pt-4">新增節日</p>
                <form @submit.prevent="submit" action="" method="POST" class="p-8">
                    <p class="my-4 text-red" v-show="error_msg">{{ error_msg }}</p>
                    <div class="flex justify-between">
                        <div>
                            <label for="start_date">開始: </label>
                            <date-picker v-model="from"></date-picker>
                        </div>
                        <div>
                            <label for="start_date">結束: </label>
                            <date-picker v-model="to"></date-picker>
                        </div>
                    </div>
                    <div class="my-4">
                        <label for="holiday_name">節日名稱</label>
                        <input type="text" id="holiday_name" name="holiday_name" v-model="holiday_name" class="block w-full border mt-2 h-8">
                    </div>
                    <div class="mt-8 flex justify-end">
                        <button type="button" @click="open = false" class="btn btn-white">取消</button>
                        <button type="submit" class="btn btn-orange ml-4">確認提交</button>
                    </div>
                </form>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    import DatePicker from "vuejs-datepicker";

    export default {
        components: {
            DatePicker,
        },

        data() {
            return {
                open: false,
                from: new Date(),
                to: new Date(),
                holiday_name: '',
                error_msg: ''
            };
        },

        methods: {
            submit() {
                this.error_msg = '';
                const holiday = {
                    start_date: this.from.toISOString().slice(0,10),
                    end_date: this.to.toISOString().slice(0,10),
                    name: this.holiday_name
                };

                axios.post("/admin/holidays", holiday)
                    .then(({data}) => this.onSuccess(data))
                    .catch(({response}) => this.onFailure(response));
            },

            onSuccess(response) {
                this.from = new Date();
                this.to = new Date();
                this.error_msg = '';
                this.holiday_name = '';
                this.open = false;
                this.$emit('holiday-added');
            },

            onFailure(response) {
                if(response.status === 422) {
                    return this.error_msg = 'Your input was not valid. Please try again.'
                }
                this.open = false;
                this.$emit('holiday-creation-failure');
            },

        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>