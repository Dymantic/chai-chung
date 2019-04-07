<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <div>
                <p class="font-black text-5xl">{{ name }}</p>
                <p>{{ client_code }}</p>
                <p>NT${{ annual_revenue }}/yr</p>
            </div>

            <div class="flex justify-end">
                <button @click="showEditForm = true"
                        class="btn btn-orange">Edit</button>
                <modal :show="showEditForm"
                       @close="showEditForm = false">
                    <edit-client-form @cancel="showEditForm = false"
                                     @client-updated="updateClient"
                                      :client-id="client.id"
                                      :client-name="name"
                                      :annual-revenue="annual_revenue"
                    ></edit-client-form>
                </modal>
                <button @click="showDeleteForm = true"
                        class="btn btn-red ml-4"
                >Delete
                </button>
                <modal :show="showDeleteForm"
                       @close="showDeleteForm = false">
                    <div class="w-screen max-w-sm">
                        <p class="text-center py-2 bg-red text-white font-bold text-lg">Delete {{ name }}?</p>
                        <div class="p-4">
                            <p>This will delete the client permanently. Are you sure you want to proceed?</p>
                        </div>
                        <div class="flex justify-end p-4">
                            <button type="button"
                                    class="bg-grey text-navy px-4 py-2 rounded font-bold hover:bg-grey-darker shadow"
                                    @click="showDeleteForm = false">Cancel
                            </button>
                            <button class="bg-red text-white px-4 py-2 rounded font-bold hover:bg-orange-light shadow ml-4"
                                    @click="deleteClient">OK, Delete
                            </button>
                        </div>
                    </div>

                </modal>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import EditClientForm from "./EditClientForm";
    import {notify} from "../notify";

    export default {
        components: {
            EditClientForm
        },

        props: ['client'],

        data() {
            return {
                showEditForm: false,
                showDeleteForm: false,
                name: this.client.name,
                client_code: this.client.client_code,
                annual_revenue: this.client.annual_revenue
            };
        },

        methods: {
            updateClient({name, annual_revenue}) {
                this.showEditForm = false;
                this.name = name;
                this.annual_revenue = annual_revenue;
            },

            deleteClient() {
                axios.delete(`/admin/clients/${this.client.id}`)
                    .then(() => window.location = '/admin/manage-clients')
                     .catch(() => notify.error({message: 'Unable to delete client.'}));
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>