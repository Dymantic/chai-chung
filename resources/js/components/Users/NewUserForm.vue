<template>
    <div>
        <p class="text-center py-2 bg-navy text-white">Add a new user</p>
        <div class="p-4">
            <vue-form url="/admin/users" :form-model="form" @submission-okay="userPersisted">
                <div slot-scope="{formData, formErrors, waiting}">
                    <div class="form-group my-3" :class="{'has-error': formErrors.name}">
                        <label class="text-sm text-navy font-bold" for="name">Name</label>
                        <span class="text-xs text-red" v-show="formErrors.name">{{ formErrors.name }}</span>
                        <input type="text" name="name" v-model="formData.name" class="w-full h-8 pl-2 mt-1 border" id="name">
                    </div>
                    <div class="form-group my-3" :class="{'has-error': formErrors.email}">
                        <label class="text-sm text-navy font-bold" for="name">Email</label>
                        <span class="text-xs text-red" v-show="formErrors.email">{{ formErrors.email }}</span>
                        <input type="email" name="name" v-model="formData.email" class="w-full h-8 pl-2 mt-1 border" id="email">
                    </div>
                    <div class="form-group my-6" :class="{'has-error': formErrors.is_manager}">
                        <label class="text-sm text-navy font-bold" for="is_manager">Manager
                            <input type="checkbox" name="name" v-model="formData.is_manager" id="is_manager" class="hidden">
                            <span class="fake-checkbox"></span>
                        </label>
                        <span class="text-xs text-red" v-show="formErrors.is_manager">{{ formErrors.is_manager }}</span>


                    </div>
                    <div class="form-group my-3" :class="{'has-error': formErrors.password}">
                        <label class="text-sm text-navy font-bold" for="name">Password</label>
                        <span class="text-xs text-red" v-show="formErrors.password">{{ formErrors.password }}</span>
                        <input type="text" name="name" v-model="formData.password" class="w-full h-8 pl-2 mt-1 border" id="password">

                    </div>
                    <div class="form-group my-3" :class="{'has-error': formErrors.password_confirmation}">
                        <label class="text-sm text-navy font-bold" for="name">Confirm Password</label>
                        <span class="text-xs text-red" v-show="formErrors.password_confirmation">{{ formErrors.password_confirmation }}</span>
                        <input type="text" name="name" v-model="formData.password_confirmation" class="w-full h-8 pl-2 mt-1 border" id="password_confirmation">
                    </div>
                    <div class="my-4 flex justify-end">
                        <button type="button" class="bg-grey text-navy px-4 py-2 rounded uppercase hover:bg-grey-darker shadow" @click="cancel">Cancel</button>
                        <button class="bg-orange text-navy px-4 py-2 rounded uppercase hover:bg-orange-light shadow ml-4" type="submit">Create</button>
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