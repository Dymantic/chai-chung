<template>
    <div class="w-screen max-w-sm">
        <p class="text-center py-2 bg-navy text-white">Add a new Client</p>
        <div class="p-4">
            <vue-form url="/admin/clients" :form-model="form" @submission-okay="clientPersisted">
                <div slot-scope="{formData, formErrors, waiting}">
                    <div class="form-group my-3" :class="{'has-error': formErrors.client_code}">
                        <label class="text-sm text-navy font-bold" for="client_code">Code</label>
                        <span class="text-xs text-red" v-show="formErrors.client_code">{{ formErrors.client_code }}</span>
                        <input type="text" name="client_code" v-model="formData.client_code" class="w-full h-8 pl-2 mt-1 border" id="client_code">
                    </div>
                    <div class="form-group my-3" :class="{'has-error': formErrors.name}">
                        <label class="text-sm text-navy font-bold" for="name">Name</label>
                        <span class="text-xs text-red" v-show="formErrors.name">{{ formErrors.name }}</span>
                        <input type="text" name="name" v-model="formData.name" class="w-full h-8 pl-2 mt-1 border" id="name">
                    </div>
                    <div class="form-group my-3" :class="{'has-error': formErrors.annual_revenue}">
                        <label class="text-sm text-navy font-bold" for="annual_revenue">Annual Revenue</label>
                        <span class="text-xs text-red" v-show="formErrors.annual_revenue">{{ formErrors.annual_revenue }}</span>
                        <input type="text" name="annual_revenue" v-model="formData.annual_revenue" class="w-full h-8 pl-2 mt-1 border" id="annual_revenue">
                    </div>
                    <div class="my-4 mt-8 flex justify-end">
                        <button type="button" class="btn btn-white mx-4" @click="cancel">Cancel</button>
                        <button class="btn btn-orange" type="submit">Create</button>
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
                form: new Form({
                    name: "",
                    client_code: "",
                    annual_revenue: null
                })
            }
        },

        methods: {
            cancel() {
                this.$emit('cancel');
            },

            clientPersisted(data) {
                this.form.resetFields();

                this.$emit('client-created');
            },
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>