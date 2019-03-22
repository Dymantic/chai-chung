<template>
    <div class="w-screen max-w-sm">
        <p class="text-center py-2 bg-navy text-white">Edit info for {{ clientName }}</p>
        <div class="p-4">
            <vue-form :url="`/admin/clients/${clientId}`" :form-model="form" @submission-okay="clientUpdated">
                <div slot-scope="{formData, formErrors, waiting}">
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

        props: ['client-name', 'annual-revenue', 'client-id'],

        data() {
            return {
                form: new Form({
                    name: this.clientName,
                    annual_revenue: this.annualRevenue
                })
            }
        },

        methods: {
            cancel() {
                this.$emit('cancel');
            },

            clientUpdated(data) {
                this.form.resetFields();

                this.$emit('client-updated', {
                    name: data.name,
                    annual_revenue: data.annual_revenue
                });
            },
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>