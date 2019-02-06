<template>
    <div>
        <div class="max-w-xl mx-auto mt-4 px-8 mb-20 flex justify-between items-center">
            <p class="text-5xl font-black">{{ name }}</p>
            <div class="flex justify-end items-center">
                <button @click="showUserForm = true"
                        class="bg-orange text-navy px-4 py-2 rounded uppercase hover:bg-orange-light shadow ml-4">Edit
                </button>
                <modal :show="showUserForm"
                       @close="showUserForm = false">
                    <user-form :name="name"
                               :email="email"
                               :user_id="user.id"
                               @cancel="showUserForm = false"
                               @user-edited="updateUserDetails"
                    ></user-form>
                </modal>
            </div>
        </div>
        <div class="max-w-lg mt-12 mx-auto p-4">
            <div class="flex items-center text-navy">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" height="16px" class="fill-current"><path d="M18 2a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2h16zm-4.37 9.1L20 16v-2l-5.12-3.9L20 6V4l-10 8L0 4v2l5.12 4.1L0 14v2l6.37-4.9L10 14l3.63-2.9z"/></svg>
                <span class="pl-4 text-xl align-middle">{{ email }}</span>
            </div>
            <div class="flex items-center text-navy my-4">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="16" class="fill-current"><path d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z"/></svg>
                <span class="pl-4 text-xl align-middle">{{ user.is_manager ? 'Manager' : 'Regular staff' }}</span>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import UserForm from "./UserForm";

    export default {
        components: {
            UserForm
        },

        props: ['user'],

        data() {
            return {
                showUserForm: false,
                name: this.user.name,
                is_manager: this.user.is_manager,
                email: this.user.email
            };
        },

        methods: {
            updateUserDetails({name, email}) {
                this.name = name;
                this.email = email;
                this.showUserForm = false;
            }
        }
    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>