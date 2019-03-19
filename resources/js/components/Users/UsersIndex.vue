<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">Users</p>
            <div class="flex justify-end">
                <button @click="showNewUserForm = true" class="btn btn-orange">New User</button>
                <modal :show="showNewUserForm"
                       @close="showNewUserForm = false">
                    <new-user-form @cancel="showNewUserForm = false" @user-created="userAdded"></new-user-form>
                </modal>
            </div>
        </div>

        <div class="max-w-lg mx-auto my-20">
            <h3 class="px-4 mb-4">Managers</h3>
            <user-index-card v-for="manager in managers"
                 :key="manager.id" :user="manager">
            </user-index-card>
        </div>

        <div class="max-w-lg mx-auto my-20">
            <h3 class="px-4 mb-4">Staff</h3>
            <user-index-card v-for="staff in staffs"
                             :key="staff.id" :user="staff">
            </user-index-card>

        </div>
    </div>
</template>

<script type="text/babel">
    import NewUserForm from "./NewUserForm";
    import UserIndexCard from "./UserIndexCard";

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
        },

        methods: {
            fetchUsers() {
                axios.get("/admin/users")
                     .then(({data}) => this.users = data)
                     .catch(err => console.log(err));
            },

            userAdded() {
                this.showNewUserForm = false;
                this.fetchUsers();
            }

        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>