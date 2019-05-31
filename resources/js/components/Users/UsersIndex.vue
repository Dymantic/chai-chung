<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">工作同仁</p>
            <div class="flex justify-end">
                <button @click="showNewUserForm = true" class="btn btn-orange">新增員工</button>
                <modal :show="showNewUserForm"
                       @close="showNewUserForm = false">
                    <new-user-form @cancel="showNewUserForm = false" @user-created="userAdded"></new-user-form>
                </modal>
            </div>
        </div>

        <div class="max-w-lg mx-auto my-20">
            <h3 class="px-4 mb-4">管理者</h3>
            <user-index-card v-for="manager in managers"
                 :key="manager.id" :user="manager">
            </user-index-card>
        </div>

        <div class="max-w-lg mx-auto my-20">
            <h3 class="px-4 mb-4">員工</h3>
            <user-index-card v-for="staff in staffs"
                             :key="staff.id" :user="staff">
            </user-index-card>

        </div>
    </div>
</template>

<script type="text/babel">
    import NewUserForm from "./NewUserForm";
    import UserIndexCard from "./UserIndexCard";
    import {notify} from "../notify";

    export default {
        components: {
            NewUserForm,
            UserIndexCard,
        },

        data() {
            return {
                showNewUserForm: false,
                users: []
            };
        },

        computed: {
            managers() {
                return this.users.filter(user => user.is_manager);
            },

            staffs() {
                return this.users.filter(user => !user.is_manager);
            }


        },


        mounted() {
            this.fetchUsers()
                .catch(() => notify.error({message: "Unable to fetch users"}));
        },

        methods: {
            fetchUsers() {
                return new Promise((resolve, reject) => {
                    axios.get("/admin/users")
                         .then(({data}) => {
                             this.users = data;
                             resolve();
                         })
                         .catch(reject);
                });

            },

            userAdded() {
                this.showNewUserForm = false;
                this.fetchUsers()
                    .then(() => notify.success({message: 'New user added', clear: true}))
                    .catch(() => notify.error({message: "Unable to fetch users"}));
            }

        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>