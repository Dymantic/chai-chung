<template>
    <div>
        <form action="" @submit.prevent="submitRequest" class="p-8 w-full max-w-md">
            <p class="text-lg font-bold text-navy mb-8">請假需求</p>
            <p v-if="error_msg" class="mb-4 text-center py-2 border border-red text-red">{{ error_msg }}</p>
            <div>
                <p class="font-bold text-navy">開始:</p>
                <div class="flex justify-between">
                    <div class="mr-4">
                        <p class="text-xs mb-1 font-bold">日期</p>
                        <date-picker v-model="form.start_date" class="p-2 border"></date-picker>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs mb-1 font-bold">時間</p>
                        <input type="text" name="start_time" v-model="form.start_time" class="border p-2">
                    </div>
                </div>
            </div>
            <div class="my-8">
                <p class="font-bold text-navy">結束:</p>
                <div class="flex justify-between">
                    <div class="mr-4">
                        <p class="text-xs mb-1 font-bold">日期</p>
                        <date-picker v-model="form.end_date" class="p-2 border"></date-picker>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs mb-1 font-bold">時間</p>
                        <input type="text" name="end_time" v-model="form.end_time" class="border p-2">
                    </div>
                </div>
            </div>
            <div class="my-12">
                <p class="font-bold text-navy mb-2">請誰代班?</p>
                <select name="covering_user_id" class="h-8 border block w-full" v-model="form.covering_user_id">
                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                </select>
            </div>
            <div class="my-12">
                <p class="font-bold text-navy mb-2">備註說明?</p>
                <input type="text" name="reason" v-model="form.reason" class="block w-full p-2 border">
            </div>
            <div class="flex pt-4 justify-end">
                <button class="btn btn-white" type="button" @click="$emit('cancel')">取消</button>
                <button :disabled="waiting" :class="{'opacity-50': waiting}" class="btn btn-orange ml-4" type="submit">確認提交</button>
            </div>
        </form>
    </div>
</template>

<script type="text/babel">
    import DatePicker from "vuejs-datepicker";

    export default {

        components: {
            DatePicker
        },

        props: ['users'],

        data() {
            return {
                error_msg: '',
                form: {
                    start_date: new Date(),
                    start_time: "08:00",
                    end_date: new Date(),
                    end_time: "17:00",
                    covering_user_id: '',
                    reason: ''
                },
                waiting: false
            };
        },

        methods: {
            submitRequest() {
                this.error_msg = '';
                this.waiting = true;
                axios.post("/admin/leave-requests", {
                    start_date: this.form.start_date.toISOString().slice(0,10),
                    end_date: this.form.end_date.toISOString().slice(0,10),
                    start_time: this.form.start_time,
                    end_time: this.form.end_time,
                    covering_user_id: this.form.covering_user_id,
                    reason: this.form.reason
                }).then(() => this.onSubmitted())
                    .catch(({response}) => this.onFailedToSubmit(response.status, response.data))
                    .then(() => this.waiting = false);
            },

            onSubmitted() {
                this.resetForm();
                this.$emit('request-created');
            },

            resetForm() {
                this.form = {
                    start_date: new Date(),
                    start_time: "08:30",
                    end_date: new Date(),
                    end_time: "17:30",
                    covering_user_id: '',
                    reason: ''
                };
            },

            onFailedToSubmit(status, {errors}) {
                if(status === 422) {
                    this.error_msg = '有錯誤喔！請再次確認所有細節並且重新填寫，謝謝。';
                }
            }
        }

    }
</script>

<style scoped lang="less" type="text/css">

</style>