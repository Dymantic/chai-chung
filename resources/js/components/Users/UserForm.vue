<template>
    <div>
        <p class="text-center py-2 bg-navy text-white">Edit Your Details</p>
        <div class="p-4">
            <vue-form :url="`/admin/users/${user_id}`" :form-model="form" @submission-okay="userUpdated">
                <div slot-scope="{formData, formErrors, waiting}">
                    <div class="form-group my-3" :class="{'has-error': formErrors.name}">
                        <label class="text-sm text-navy font-bold" for="name">Name</label>
                        <span class="text-xs text-red" v-show="formErrors.name">{{ formErrors.name }}</span>
                        <input type="text" name="name" v-model="formData.name" class="w-full h-8 pl-2 mt-1 border" id="name">
                    </div>
                    <div class="form-group my-3" :class="{'has-error': formErrors.email}">
                        <label class="text-sm text-navy font-bold" for="name">Email</label>
                        <span class="text-xs text-red" v-show="formErrors.email">{{ formErrors.email }}</span>
                        <input type="email" name="name" v-model="formData.email" class="w-full h-8 pl-2 mt-1 border" id="email">
                    </div>

                    <div class="my-4 flex justify-end">
                        <button type="button" class="btn btn-white" @click="$emit('cancel')">Cancel</button>
                        <button class="btn btn-orange ml-4" type="submit">Update</button>
                    </div>
                </div>
            </vue-form>

        </div>
    </div>
</template>

<script type="text/babel">
    import {Form} from "@dymantic/vue-forms";

    export default {
        props: ['name', 'email', 'user_id'],

        data() {
            return {
                form: new Form({name: this.name, email: this.email})
            }
        },

        methods: {
            userUpdated({name, email}) {
                this.$emit('user-edited', {name, email})
            },


        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>