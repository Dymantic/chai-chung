<template>
    <div class="w-screen max-w-sm">
        <p class="text-center py-2 bg-navy text-white">新增夥伴</p>
        <div class="p-4">
            <vue-form url="/admin/users" :form-model="form" @submission-okay="userPersisted">
                <div slot-scope="{formData, formErrors, waiting}">
                    <div class="form-group my-3" :class="{'has-error': formErrors.name}">
                        <label class="text-sm text-navy font-bold" for="name">姓名</label>
                        <span class="text-xs text-red" v-show="formErrors.name">{{ formErrors.name }}</span>
                        <input type="text" name="name" v-model="formData.name" class="w-full h-8 pl-2 mt-1 border" id="name">
                    </div>
                    <div class="form-group my-3" :class="{'has-error': formErrors.email}">
                        <label class="text-sm text-navy font-bold" for="name">Email</label>
                        <span class="text-xs text-red" v-show="formErrors.email">{{ formErrors.email }}</span>
                        <input type="email" name="name" v-model="formData.email" class="w-full h-8 pl-2 mt-1 border" id="email">
                    </div>
                    <div class="form-group my-3" :class="{'has-error': formErrors.user_code}">
                        <label class="text-sm text-navy font-bold" for="user_code">個人代號</label>
                        <span class="text-xs text-red" v-show="formErrors.user_code">{{ formErrors.user_code }}</span>
                        <input type="text" name="user_code" v-model="formData.user_code" class="w-full h-8 pl-2 mt-1 border" id="user_code">
                    </div>
                    <div class="form-group my-3" :class="{'has-error': formErrors.hourly_rate}">
                        <label class="text-sm text-navy font-bold" for="hourly_rate">工作時薪</label>
                        <span class="text-xs text-red" v-show="formErrors.hourly_rate">{{ formErrors.hourly_rate }}</span>
                        <input type="text" name="hourly_rate" v-model="formData.hourly_rate" class="w-full h-8 pl-2 mt-1 border" id="hourly_rate">
                    </div>
                    <div class="form-group my-6" :class="{'has-error': formErrors.is_manager}">
                        <label class="text-sm text-navy font-bold" for="is_manager">是否為管理職位？
                            <input type="checkbox" name="name" v-model="formData.is_manager" id="is_manager" class="hidden">
                            <span class="fake-checkbox"></span>
                        </label>
                        <span class="text-xs text-red" v-show="formErrors.is_manager">{{ formErrors.is_manager }}</span>


                    </div>
                    <div class="form-group my-3" :class="{'has-error': formErrors.password}">
                        <label class="text-sm text-navy font-bold" for="name">密碼</label>
                        <span class="text-xs text-red" v-show="formErrors.password">{{ formErrors.password }}</span>
                        <input type="text" name="name" v-model="formData.password" class="w-full h-8 pl-2 mt-1 border" id="password">

                    </div>
                    <div class="form-group my-3" :class="{'has-error': formErrors.password_confirmation}">
                        <label class="text-sm text-navy font-bold" for="name">密碼確認</label>
                        <span class="text-xs text-red" v-show="formErrors.password_confirmation">{{ formErrors.password_confirmation }}</span>
                        <input type="text" name="name" v-model="formData.password_confirmation" class="w-full h-8 pl-2 mt-1 border" id="password_confirmation">
                    </div>
                    <div class="my-4 mt-8 flex justify-end">
                        <button type="button" class="btn btn-white mx-4" @click="cancel">取消</button>
                        <button class="btn btn-orange" type="submit">新增</button>
                    </div>
                </div>
            </vue-form>

        </div>
    </div>
</template>

<script type="text/babel">
    import {Form} from "@dymantic/vue-forms";
    import {randomString} from "../../lib/RandomString";

    export default {
        data() {
            return {
                form: new Form({name: "", email: "", password: "", password_confirmation: "", is_manager: false})
            }
        },

        mounted() {
            this.suggestNewPassword();
        },

        methods: {
            cancel() {
                this.$emit('cancel');
            },

            userPersisted(data) {
                this.form.resetFields();
                this.suggestNewPassword();

                this.$emit('user-created');
            },

            suggestNewPassword() {
                const pwd = randomString(6);
                this.form.data.password =  this.form.data.password_confirmation = pwd;
            }

        }
    }
</script>

<style scoped lang="less" type="text/css">
    .fake-checkbox {
        content: '';
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 1px solid grey;
        vertical-align: middle;
        margin-left: 8px;
    }

    input[type=checkbox]:checked + .fake-checkbox {
        background: #333;
    }
</style>