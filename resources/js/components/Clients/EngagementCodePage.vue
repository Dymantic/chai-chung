<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">Engagement Code: {{ code }}</p>
            <div class="flex justify-end">
                <button @click="showEditEngagementCodeForm = true"
                        class="btn btn-orange">Edit
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
                >Delete
                </button>
                <modal :show="showDeleteForm"
                       @close="showDeleteForm = false">
                    <div class="w-screen max-w-sm">
                        <p class="text-center py-2 bg-red text-white font-bold text-lg">Delete {{ code }}?</p>
                        <div class="p-4">
                            <p>This will delete the code permanently. Are you sure you want to proceed?</p>
                        </div>
                        <div class="flex justify-end p-4">
                            <button type="button"
                                    class="bg-grey text-navy px-4 py-2 rounded font-bold hover:bg-grey-darker shadow"
                                    @click="showDeleteForm = false">Cancel
                            </button>
                            <button class="bg-red text-white px-4 py-2 rounded font-bold hover:bg-orange-light shadow ml-4"
                                    @click="deleteEngagementCode">OK, Delete
                            </button>
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
            },

            deleteEngagementCode() {
                axios.delete(`/admin/engagement-codes/${this.engagementCode.id}`)
                    .then(() => window.location = '/admin/manage-engagement-codes')
                    .catch(err => console.log(err));
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>