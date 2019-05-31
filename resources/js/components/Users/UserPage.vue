<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">{{ user.name}}</p>
            <div class="flex justify-end">
                <user-status-button :user_id="user.id"
                                    :is_manager="is_manager"
                                    @promoted="is_manager = true"
                                    @demoted="is_manager = false"
                ></user-status-button>
                <button @click="showDeleteForm = true"
                        class="btn btn-red ml-4"
                >刪除
                </button>
                <modal :show="showDeleteForm"
                       @close="showDeleteForm = false">
                    <div class="w-screen max-w-sm">
                        <p class="text-center py-2 bg-red text-white font-bold text-lg">刪除 {{ user.name }}?</p>
                        <div class="p-4">
                            <p>一旦系統刪除將無法回覆，請再次確認是否刪除此員工所有資料？</p>
                        </div>
                        <div class="flex justify-end p-4">
                            <button type="button"
                                    class="bg-grey text-navy px-4 py-2 rounded font-bold hover:bg-grey-darker shadow"
                                    @click="showDeleteForm = false">取消
                            </button>
                            <button class="bg-red text-white px-4 py-2 rounded font-bold hover:bg-orange-light shadow ml-4"
                                    @click="deleteUser">確認刪除
                            </button>
                        </div>
                    </div>

                </modal>
            </div>
        </div>
        <section class="max-w-lg mx-auto">
            <p class="mr-8 mb-4"><strong>代號: </strong>{{ user.user_code}}</p>
            <p class="mr-8 flex items-center">
                <strong>時薪: </strong>
                {{ `NT$${current_rate}/hr` }}
                <update-hourly-rate-form :user-name="user.name" :user-id="user.id" :current-rate="user.hourly_rate" @rate-updated="updateRate"></update-hourly-rate-form>
            </p>
        </section>
    </div>
</template>

<script type="text/babel">
    import UserStatusButton from "./UserStatusButton";
    import UpdateHourlyRateForm from "./UpdateHourlyRateForm";
    import {notify} from "../notify";

    export default {
        components: {
            UserStatusButton,
            UpdateHourlyRateForm
        },

        props: ['user'],

        data() {
            return {
                showDeleteForm: false,
                is_manager: this.user.is_manager,
                name: this.user.name,
                current_rate: null,
            };
        },

        mounted() {
          this.current_rate = this.user.hourly_rate;
        },

        methods: {
            deleteUser() {
                axios.delete(`/admin/users/${this.user.id}`)
                     .then(() => window.location = "/admin/manage-users")
                     .catch(() => notify.error({message: 'Unable to delete user'}));
            },

            updateRate({hourly_rate}) {
                this.current_rate = hourly_rate;
            },


        }

    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>