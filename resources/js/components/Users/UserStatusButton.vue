<template>
    <div class="relative">
        <div class="flex items-center bg-grey-lighter p-2 rounded">
            <span class="font-bold text-navy">Status: </span>
            <span class="px-4 text-navy w-24 text-center block">{{ status }}</span>
            <button class="p-1 ml-2 border-l border-grey pl-2"
                    @click="showStatusPanel = !showStatusPanel">
                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 20 20"
                     height="12px"
                     :transform="iconTransform">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </button>
        </div>
        <div class="absolute change-status p-2 bg-grey-lighter rounded"
             :class="{'show': showStatusPanel}">
            <div v-if="is_manager"
                 class="flex flex-col items-end">
                <p>You can demote this user to become a regular staff member, without any extra admin privileges on the
                   site</p>
                <button @click="demote"
                        class="mt-4 p-2 text-xs bg-navy text-white font-bold rounded" :class="{'opacity-50': waiting}">
                    <span v-if="!waiting">Demote</span>
                    <span v-else>Waiting</span>
                </button>
            </div>
            <div v-if="!is_manager"
                 class="flex flex-col items-end">
                <p>You can promote this user to become a manager, with extra admin privileges on the site</p>
                <button @click="promote"
                        class="mt-4 p-2 text-xs bg-navy text-white font-bold rounded"  :class="{'opacity-50': waiting}">
                    <span v-if="!waiting">Promote</span>
                    <span v-else>Waiting</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
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
                return this.is_manager ? 'Manager' : 'Staff';
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
                     .catch(err => console.log(err))
                     .then(() => this.waiting = false)
                     .then(() => this.showStatusPanel = false);
            },

            demote() {
                this.waiting = true;

                axios.delete(`/admin/managers/${this.user_id}`)
                     .then(() => this.$emit('demoted'))
                     .catch(err => console.log(err))
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
    }

    .change-status.show {
        transform: rotateX(0deg);
    }

</style>