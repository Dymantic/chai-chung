<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">客戶</p>
            <div class="flex justify-end">
                <button @click="showNewClientForm = true"
                        class="btn btn-orange">新增客戶</button>
                <modal :show="showNewClientForm"
                       @close="showNewClientForm = false">
                    <new-client-form @cancel="showNewClientForm = false"
                                     @client-created="clientAdded"></new-client-form>
                </modal>
            </div>
        </div>
        <div class="max-w-xl mx-auto my-20">
            <div v-for="client in clients" :key="client.id" class="bg-grey-lighter p-4 my-2 max-w-md mx-auto">
                <p class="font-black text-navy text-xs uppercase tracking-wide mb-3">{{ client.client_code }}</p>
                <p><a :href="`/admin/clients/${client.id}`" class="text-navy text-xl hover:text-orange no-underline">{{ client.name }}</a></p>
                <p class="text-sm mt-3">NT${{ client.annual_revenue }}/yr</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import NewClientForm from "./NewClientForm";
    import {notify} from "../notify";

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
            this.fetchClients()
                .catch(() => notify.error({message: '系統無法顯示客戶資料'}));
        },

        methods: {
            fetchClients() {
                return new Promise((resolve, reject) => {
                    axios.get("/admin/clients")
                         .then(({data}) => {
                             this.clients = data;
                             resolve();
                         })
                         .catch(reject);
                });

            },

            clientAdded() {
                this.showNewClientForm = false;
                this.fetchClients()
                    .then(() => notify.success({message: '客戶資料已成功新增儲存', clear: true}))
                    .catch(() => notify.error({message: '系統無法顯示客戶資料'}));
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>