<template>
    <div class="max-w-xl mx-auto">
        <div class="px-8 max-w-xl mb-12 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">時間紀錄及工作細節</p>
            <div class="flex justify-end">
                <router-link class="font-bold text-grey-dark no-underline" to="/">回上一頁</router-link>
            </div>
        </div>
        <session-form @session-saved="onSessionCreated"
                      @session-save-failed="onSessionFailed"
        ></session-form>
    </div>
</template>

<script type="text/babel">

    import {notify} from "../notify";
    import SessionForm from "./SessionForm";

    export default {
        components: {
            SessionForm,
        },

        methods: {
            onSessionCreated() {
                notify.success({message: '您的紀錄已新增儲存'});
            },

            onInvalidData() {

            },

            onSessionFailed() {
                notify.error({message: '出錯了！無法順利儲存您的資料。'});
            }
        },


    }
</script>
