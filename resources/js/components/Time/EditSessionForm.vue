<template>
    <div>
        <div class="max-w-xl mx-auto" v-if="ready">
            <div class="px-8 max-w-xl mb-12 mt-4 mx-auto items-center flex justify-between">
                <p class="font-black text-5xl">編輯</p>
                <div class="flex justify-end">
                    <router-link class="font-bold text-grey-dark no-underline" to="/">回上一頁</router-link>
                </div>
            </div>
            <session-form :original-session="session"
                          @session-saved="onSessionSaved"
                          @session-save-failed="onSessionSaveError"
            ></session-form>

        </div>
    </div>
</template>

<script type="text/babel">
    import SessionForm from "./SessionForm";
    import {notify} from "../notify";

    export default {

        components: {
            SessionForm,
        },

        data() {
            return {
                ready: false,
                session: null,
            };
        },

        computed: {
            session_id() {
                return this.$route.params.id;
            }
        },

        mounted() {
          this.getSession();
        },

        methods: {
            getSession() {
                this.$store.dispatch('userSessions/getSession', this.session_id)
                    .then(session => {
                        this.session = session;
                        this.ready = true;
                    })
                    .catch(console.log);
            },

            onSessionSaved() {
                notify.success({message: '紀錄已更新'});
                this.$router.push('/');
            },

            onSessionSaveError() {
                notify.error({message: '無法更新紀錄'});
            }
        }
    }
</script>
