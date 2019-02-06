<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">{{ user.name}}</p>
            <div class="flex justify-end">
                <user-status-button :user_id="user.id"
                                    :is_manager="is_manager"
                                    @promoted="is_manager = true"
                                    @demoted="is_manager = false"
                ></user-status-button>
                <button @click="showDeleteForm = true"
                        class="bg-red text-white px-4 py-2 rounded font-bold hover:bg-orange-light shadow ml-4"
                >Delete
                </button>
                <modal :show="showDeleteForm"
                       @close="showDeleteForm = false">
                    <div class="w-screen max-w-sm">
                        <p class="text-center py-2 bg-red text-white font-bold text-lg">Delete {{ user.name }}?</p>
                        <div class="p-4">
                            <p>This will remove the user from the system, and can not be undone. Please check before you
                               proceed.</p>
                        </div>
                        <div class="flex justify-end p-4">
                            <button type="button"
                                    class="bg-grey text-navy px-4 py-2 rounded font-bold hover:bg-grey-darker shadow"
                                    @click="showDeleteForm = false">Cancel
                            </button>
                            <button class="bg-red text-white px-4 py-2 rounded font-bold hover:bg-orange-light shadow ml-4"
                                    @click="deleteUser">OK, Delete
                            </button>
                        </div>
                    </div>

                </modal>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import UserStatusButton from "./UserStatusButton";

    export default {
        components: {
            UserStatusButton
        },

        props: ['user'],

        data() {
            return {
                showDeleteForm: false,
                is_manager: this.user.is_manager,
                name: this.user.name
            };
        },

        methods: {
            deleteUser() {
                axios.delete(`/admin/users/${this.user.id}`)
                     .then(() => window.location = "/admin/manage-users")
                     .catch(err => console.log(err));
            },

            promoteUser() {

            },


        }

    }
</script>

<style scoped
       lang="scss"
       type="text/scss">

</style>