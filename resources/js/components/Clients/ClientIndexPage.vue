<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">Clients</p>
            <div class="flex justify-end">
                <button @click="showNewClientForm = true"
                        class="btn btn-orange">New Client
                </button>
                <modal :show="showNewClientForm"
                       @close="showNewClientForm = false">
                    <new-client-form @cancel="showNewClientForm = false"
                                     @client-created="clientAdded"></new-client-form>
                </modal>
            </div>
        </div>
        <div class="max-w-xl mx-auto my-20">
            <div v-for="client in clients" :key="client.id" class="bg-grey-lighter p-4 my-2 max-w-md mx-auto">
                <p class="font-black text-navy text-xs uppercase tracking-wide">{{ client.client_code }}</p>
                <p><a :href="`/admin/clients/${client.id}`" class="text-navy no-underline">{{ client.name }}</a></p>
                <p class="text-sm mt-3">NT${{ client.annual_revenue }}/yr</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import NewClientForm from "./NewClientForm";

    export default {
        components: {
            NewClientForm
        },

        data() {
            return {
                showNewClientForm: false,
                clients: []
            };
        },

        mounted() {
            this.fetchClients();
        },

        methods: {
            fetchClients() {
                axios.get("/admin/clients")
                     .then(({data}) => this.clients = data)
                     .catch(err => console.log(err));
            },

            clientAdded() {
                this.showNewClientForm = false;
                this.fetchClients();
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>