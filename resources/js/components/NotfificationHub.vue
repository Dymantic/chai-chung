<template>
    <div :class="notificationClasses"
         class="fixed alert-box mx-auto max-w-sm w-full rounded shadow leading-normal border bg-white">
        <div>
            <header class="text-white text-center font-bold py-3">{{ title }}</header>
            <p class="p-8 text-center">{{ message }}</p>
            <p v-if="status === 'error'" class="text-center">建議您更新網頁後再試一次</p>
        </div>
        <div class="flex justify-end py-4 px-8">
            <button @click="show = false">關閉</button>
        </div>
    </div>
</template>

<script type="text/babel">
    import {EventHub} from "./EventBus";

    export default {
        data() {
            return {
                show: false,
                status: 'error',
                title: '',
                message: '',
                timeout: null
            };
        },

        computed: {
            notificationClasses() {
                return {
                    'in-active': !this.show,
                    'error': this.status === 'error',
                    'success': this.status === 'success',
                    'warning': this.status === 'warning'
                };
            }
        },

        mounted() {
            EventHub.$on('notify', this.handleNotification);
            EventHub.$on('notify:error', this.handleErrorNotification);
            EventHub.$on('notify:success', this.handleSuccessNotification);

            window.addEventListener('keyup', ({key}) => {
                if (key === 'Escape') {
                    this.show = false;
                }
            });

            window.addEventListener('load', this.checkFlashMessages);


        },
        methods: {
            handleNotification({type, title = 'Notification', message, clear}) {
                this.status = type;
                this.title = title;
                this.message = message;
                this.showNotification(clear);
            },

            handleErrorNotification({title = '錯誤!', message, clear}) {
                this.status = 'error';
                this.title = title;
                this.message = message;
                this.showNotification(clear);
            },

            handleSuccessNotification({title = '成功!', message, clear}) {
                this.status = 'success';
                this.title = title;
                this.message = message;
                this.showNotification(clear);
            },

            showNotification(clear) {
                this.show = true;

                if(clear) {
                    if(this.timeout) {
                        window.clearTimeout(this.timeout);
                    }

                    this.timeout = window.setTimeout(() => this.show = false, 2000);
                }
            },

            checkFlashMessages() {
                if(window.flashMessage) {
                    this.handleNotification(window.flashMessage);
                }
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">
    .alert-box {
        bottom: 50px;
        left: 50%;
        transform-origin: center center;
        transform: scale(1) translate3d(-50%, 0, 0);
        opacity: 1;
        transition: .2s ease-in-out;
        visibility: visible;
    }

    .alert-box.in-active {
        opacity: 0;
        transform: scale(.8) translate3d(-50%, 40px, 0);
        visibility: hidden;
        pointer-events: none;
    }

    .alert-box.error {
        @apply .border-red;
    }

    .alert-box.success {
        @apply .border-green;
    }

    .alert-box.error header {
        @apply .bg-red;
    }

    .alert-box.success header {
        @apply .bg-green;
    }
</style>