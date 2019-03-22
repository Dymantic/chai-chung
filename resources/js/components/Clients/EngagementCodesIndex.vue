<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">Engagement Codes</p>
            <div class="flex justify-end">
                <button @click="showNewEngagementCodeForm = true"
                        class="btn btn-orange">New Engagement Code
                </button>
                <modal :show="showNewEngagementCodeForm"
                       @close="showNewEngagementCodeForm = false">
                    <new-engagement-code-form @cancel="showNewEngagementCodeForm = false"
                                     @engagement-code-created="engagementCodeAdded"></new-engagement-code-form>
                </modal>
            </div>
        </div>
        <div class="max-w-xl mx-auto my-20">
            <div v-for="engagement_code in engagement_codes" :key="engagement_code.id" class="bg-grey-lighter p-4 my-2 max-w-md mx-auto">
                <p class="font-black text-navy text-xs uppercase tracking-wide mb-4">{{ engagement_code.code }}</p>
                <p><a :href="`/admin/engagement-codes/${engagement_code.id}`" class="text-navy no-underline">{{ engagement_code.description }}</a></p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import NewEngagementCodeForm from "./NewEngagementCodeForm";

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
            this.fetchEngagementCodes();
        },

        methods: {
            fetchEngagementCodes() {
                axios.get("/admin/engagement-codes")
                    .then(({data}) => this.engagement_codes = data)
                    .catch(err => console.log(err));
            },

            engagementCodeAdded() {
                this.showNewEngagementCodeForm = false;
                this.fetchEngagementCodes();
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>