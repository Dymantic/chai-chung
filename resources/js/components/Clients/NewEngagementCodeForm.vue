<template>
    <div class="w-screen max-w-sm">
        <p class="text-center py-2 bg-navy text-white">新增工作事項代號</p>
        <div class="p-4">
            <vue-form url="/admin/engagement-codes" :form-model="form" @submission-okay="engagementCodeCreated">
                <div slot-scope="{formData, formErrors, waiting}">
                    <div class="form-group my-3" :class="{'has-error': formErrors.code}">
                        <label class="text-sm text-navy font-bold" for="code">代號</label>
                        <span class="text-xs text-red" v-show="formErrors.code">{{ formErrors.code }}</span>
                        <input type="text" name="code" v-model="formData.code" class="w-full h-8 pl-2 mt-1 border" id="code">
                    </div>
                    <div class="form-group my-3" :class="{'has-error': formErrors.description}">
                        <label class="text-sm text-navy font-bold" for="description">說明</label>
                        <span class="text-xs text-red" v-show="formErrors.description">{{ formErrors.description }}</span>
                        <input type="text" name="description" v-model="formData.description" class="w-full h-8 pl-2 mt-1 border" id="description">
                    </div>
                    <div class="my-4 mt-8 flex justify-end">
                        <button type="button" class="btn btn-white mx-4" @click="cancel">取消</button>
                        <button class="btn btn-orange" type="submit">確認新增</button>
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
                    code: "",
                    description: "",
                })
            }
        },

        methods: {
            cancel() {
                this.$emit('cancel');
            },

            engagementCodeCreated(data) {
                this.form.resetFields();

                this.$emit('engagement-code-created');
            },
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>