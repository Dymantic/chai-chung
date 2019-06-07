<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">工作事項代號: {{ code }}</p>
            <div class="flex justify-end">
                <button @click="showEditEngagementCodeForm = true"
                        class="btn btn-orange">編輯
                </button>
                <modal :show="showEditEngagementCodeForm"
                       @close="showEditEngagementCodeForm = false">
                    <edit-engagement-code-form
                        :code-id="engagementCode.id"
                        :description="description"
                        :code="engagementCode.code"
                        @cancel="showEditEngagementCodeForm = false"
                        @engagement-code-updated="updateEngagementCode"
                    ></edit-engagement-code-form>
                </modal>
                <button @click="showDeleteForm = true"
                        class="btn btn-red ml-4"
                >刪除
                </button>
                <modal :show="showDeleteForm"
                       @close="showDeleteForm = false">
                    <div class="w-screen max-w-sm">
                        <p class="text-center py-2 bg-red text-white font-bold text-lg">刪除 {{ code }}?</p>
                        <div class="p-4">
                            <p>一旦系統刪除此筆資料將無法回復，請您再次確認是否執行刪除？</p>
                        </div>
                        <div class="flex justify-end p-4">
                            <button type="button"
                                    class="bg-grey text-navy px-4 py-2 rounded font-bold hover:bg-grey-darker shadow"
                                    @click="showDeleteForm = false">取消
                            </button>
                            <button class="bg-red text-white px-4 py-2 rounded font-bold hover:bg-orange-light shadow ml-4"
                                    @click="deleteEngagementCode">是的，確認刪除！</button>
                        </div>
                    </div>

                </modal>
            </div>
        </div>
        <div class="max-w-lg mx-auto my-20">
            <p class="text-2xl text-grey-dark font-light">{{ description }}</p>
        </div>
    </div>
</template>

<script type="text/babel">
    import EditEngagementCodeForm from "./EditEngagementCodeForm";
    import {notify} from "../notify";

    export default {
        components: {
            EditEngagementCodeForm
        },

        props: ['engagement-code'],

        data() {
            return {
                showEditEngagementCodeForm: false,
                showDeleteForm: false,
                code: this.engagementCode.code,
                description: this.engagementCode.description
            };
        },

        methods: {
            updateEngagementCode({description}) {
                this.showEditEngagementCodeForm = false;
                this.description = description;

                notify.success({message: '此工作事項資料已成功更新儲存'})
            },

            deleteEngagementCode() {
                axios.delete(`/admin/engagement-codes/${this.engagementCode.id}`)
                    .then(() => window.location = '/admin/manage-engagement-codes')
                    .catch(() => notify.error({message: '無法刪除此工作事項資料'}));
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>