<template>
    <div class="relative" :class="{'is-manager': is_manager}">
        <div class="flex items-center main-bg p-2 rounded">
            <span class="font-bold">職稱: </span>
            <span class="px-4 w-24 text-center block">{{ status }}</span>
            <button class="p-1 ml-2 border-l border-grey pl-2" :class="{'text-white': is_manager}"
                    @click="showStatusPanel = !showStatusPanel">
                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 20 20"
                     height="12px"
                     class="fill-current"
                     :transform="iconTransform">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </button>
        </div>
        <div class="absolute change-status p-2 main-bg rounded"
             :class="{'show': showStatusPanel}">
            <div v-if="is_manager"
                 class="flex flex-col items-end">
                <p>更改職務為一般職員</p>
                <button @click="demote"
                        class="mt-4 p-2 text-xs bg-navy text-white font-bold rounded" :class="{'opacity-50': waiting}">
                    <span v-if="!waiting">確認</span>
                    <span v-else>請等候</span>
                </button>
            </div>
            <div v-if="!is_manager"
                 class="flex flex-col items-end">
                <p>員工升遷為管理職務</p>
                <button @click="promote"
                        class="mt-4 p-2 text-xs bg-navy text-white font-bold rounded"  :class="{'opacity-50': waiting}">
                    <span v-if="!waiting">確認</span>
                    <span v-else>請等候</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../notify";

    export default {
        props: ['is_manager', 'user_id'],

        data() {
            return {
                showStatusPanel: false,
                waiting: false
            };
        },

        computed: {
            status() {
                return this.is_manager ? '管理者' : '職員';
            },

            iconTransform() {
                return this.showStatusPanel ? "scale(1,-1)" : "scale(1,1)";
            }
        },

        methods: {
            promote() {
                this.waiting = true;

                axios.post("/admin/managers", {user_id: this.user_id})
                     .then(() => this.$emit('promoted'))
                     .catch(() => notify.error({message: 'Unable to perform that action. Please refresh and try again.'}))
                     .then(() => this.waiting = false)
                     .then(() => this.showStatusPanel = false);
            },

            demote() {
                this.waiting = true;

                axios.delete(`/admin/managers/${this.user_id}`)
                     .then(() => this.$emit('demoted'))
                     .catch(() => notify.error({message: 'Unable to perform that action. Please refresh and try again.'}))
                     .then(() => this.waiting = false)
                     .then(() => this.showStatusPanel = false);

            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">
    .change-status {
        top: calc(100% - .25rem);
        right: 0;
        transform-origin: top;
        transform: rotateX(90deg);
        transition: .3s;
        width: 100%;
        padding-top: 1rem;
    }

    .change-status.show {
        transform: rotateX(0deg);
    }

    .main-bg {
        @apply .bg-grey-lighter;
    }


    .is-manager .main-bg {
        @apply .bg-navy;
    }

    .is-manager {
        @apply .text-white;
    }

</style>