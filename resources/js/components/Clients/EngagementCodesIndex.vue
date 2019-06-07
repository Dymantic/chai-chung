<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">工作事項代號</p>
            <div class="flex justify-end">
                <button @click="showNewEngagementCodeForm = true"
                        class="btn btn-orange">新增工作事項</button>
                <modal :show="showNewEngagementCodeForm"
                       @close="showNewEngagementCodeForm = false">
                    <new-engagement-code-form @cancel="showNewEngagementCodeForm = false"
                                     @engagement-code-created="engagementCodeAdded"></new-engagement-code-form>
                </modal>
            </div>
        </div>
        <div class="max-w-xl mx-auto my-20">
            <div v-for="engagement_code in engagement_codes"
                 :key="engagement_code.id"
                 class="bg-grey-lighter p-4 my-2 max-w-md mx-auto"
            >
                <a :href="`/admin/engagement-codes/${engagement_code.id}`" class="text-navy hover:text-orange no-underline">
                    <p class="font-black text-navy text-lg uppercase tracking-wide mb-4">
                        {{ engagement_code.code }}
                    </p>
                    <p>{{ engagement_code.description }}</p>
                </a>

            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import NewEngagementCodeForm from "./NewEngagementCodeForm";
    import {notify} from "../notify";

    export default {
        components: {
            NewEngagementCodeForm
        },

        data() {
            return {
                showNewEngagementCodeForm: false,
                engagement_codes: []
            };

        },

        mounted() {
            this.fetchEngagementCodes()
                .catch(() => notify.error({message: "系統無法顯示工作事項資料"}));
        },

        methods: {
            fetchEngagementCodes() {
                return new Promise((resolve, reject) => {
                    axios.get("/admin/engagement-codes")
                         .then(({data}) => {
                             this.engagement_codes = data;
                             resolve();
                         })
                         .catch(reject);
                })

            },

            engagementCodeAdded() {
                this.showNewEngagementCodeForm = false;
                this.fetchEngagementCodes()
                    .then(() => notify.success({message: '此工作事項資料已成功新增儲存', clear: true}))
                    .catch(() => notify.error({message: "系統無法顯示工作事項資料"}));
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>