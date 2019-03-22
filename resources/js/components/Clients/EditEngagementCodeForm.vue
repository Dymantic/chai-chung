<template>
    <div class="w-screen max-w-sm">
        <p class="text-center py-2 bg-navy text-white">Edit Engagement Code {{ code }}</p>
        <div class="p-4">
            <vue-form :url="`/admin/engagement-codes/${codeId}`" :form-model="form" @submission-okay="engagementCodeUpdated">
                <div slot-scope="{formData, formErrors, waiting}">
                    <div class="form-group my-3" :class="{'has-error': formErrors.description}">
                        <label class="text-sm text-navy font-bold" for="description">Annual Revenue</label>
                        <span class="text-xs text-red" v-show="formErrors.description">{{ formErrors.description }}</span>
                        <input type="text" name="description" v-model="formData.description" class="w-full h-8 pl-2 mt-1 border" id="description">
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
        props: ['code-id', 'description', 'code'],
        data() {
            return {
                form: new Form({
                    description: this.description,
                })
            }
        },

        methods: {
            cancel() {
                this.$emit('cancel');
            },

            engagementCodeUpdated({description}) {
                this.form.resetFields();

                this.$emit('engagement-code-updated', {description});
            },
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>