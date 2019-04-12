<template>
    <div>
        <modal :show="open" @close="$emit('close')">
            <div class="w-screen max-w-sm">
                <div class="p-4">
                    <div class="flex items-center my-2">
                        <svg class="mr-4 fill-current text-grey-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" height="20"><path d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 2v12h14V6H3zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z"/></svg>
                        <p class="text-navy font-bold">{{ session.date }}</p>
                    </div>
                    <div class="flex items-center my-2">
                        <svg class="mr-4 fill-current text-grey-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="20"><path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-8.41l2.54 2.53a1 1 0 0 1-1.42 1.42L11.3 12.7A1 1 0 0 1 11 12V8a1 1 0 0 1 2 0v3.59z"/></svg>
                        <p class="text-navy font-bold">{{ session.start_time }} - {{ session.end_time }}</p>
                    </div>
                    <div class="flex items-center my-2">
                        <svg class="mr-4 fill-current text-grey-dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" height="20"><path d="M3 18a7 7 0 0 1 4-6.33V8.33A7 7 0 0 1 3 2H1V0h18v2h-2a7 7 0 0 1-4 6.33v3.34A7 7 0 0 1 17 18h2v2H1v-2h2zM5 2a5 5 0 0 0 4 4.9V10h2V6.9A5 5 0 0 0 15 2H5z"/></svg>
                        <p class="text-navy font-bold">{{ session.duration }}</p>
                    </div>
                    <div class="mt-8 mb-4">
                        <p class="text-sm font-bold text-grey-dark tracking-wide uppercase">{{ session.client_code }}</p>
                        <p class="text-navy font-bold">{{ session.client_name }}</p>
                    </div>
                    <div class="my-4">
                        <p class="text-sm font-bold text-grey-dark tracking-wide uppercase">{{ session.engagement_code }}</p>
                        <p class="text-navy font-bold">{{ session.engagement_code_description }}</p>
                    </div>
                    <div class="my-4">
                        <p class="text-sm font-bold text-grey-dark tracking-wide uppercase">Service Period</p>
                        <p class="text-navy font-bold">{{ session.service_period }}</p>
                    </div>
                    <div class="my-4">
                        <p class="text-sm font-bold text-grey-dark tracking-wide uppercase">Description</p>
                        <p class="text-navy font-bold">{{ session.description }}</p>
                    </div>
                    <div class="my-4" v-if="session.notes">
                        <p class="text-sm font-bold text-grey-dark tracking-wide uppercase">Notes</p>
                        <p class="text-navy font-bold">{{ session.notes }}</p>
                    </div>
                </div>
                <div>
                    <div v-if="showDelete" class="flex justify-between border border-red p-4 h-32">
                        <p class="w-2/5">Are you sure you want to delete this session. You will not be able to retrieve it.</p>
                        <div class="flex items-center">
                            <button class="mr-4 font-bold text-grey-darker underline" @click="showDelete = false">Cancel</button>
                            <button class="btn btn-red" @click="deleteSession">Yes, Delete</button>
                        </div>
                    </div>
                    <div v-else class="flex justify-end items-center p-4 h-32">
                        <button class="mr-4 font-bold text-grey-darker underline" @click="$emit('close')">Close</button>
                        <button :disabled="deleting" :class="{'opacity-50': deleting}" class="btn btn-red" @click="showDelete = true">Delete</button>
                    </div>

                </div>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['session', 'open'],

        data() {
            return {
                showDelete: false,
                deleting: false
            };
        },

        methods: {
            deleteSession() {
                axios.delete(`/admin/sessions/${this.session.id}`)
                    .then(() => this.closeAndEmit('session-deleted'))
                    .catch(() => this.closeAndEmit('session-deleted-error'));
            },

            closeAndEmit(event_name) {
                this.showDelete = false;
                this.$emit('close');
                this.$emit(event_name, this.session);
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>