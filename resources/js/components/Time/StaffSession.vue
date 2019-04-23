<template>
    <div>
        <modal :show="open"
               @close="$emit('close')">
            <div class="w-screen max-w-sm">

                <div class="p-4">
                    <div class="flex items-center my-2">
                        <svg class="mr-4 fill-current text-grey-dark"
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20"
                             height="20">
                            <path d="M1 4c0-1.1.9-2 2-2h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4zm2 2v12h14V6H3zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z"/>
                        </svg>
                        <p class="text-navy font-bold">{{ session.date }}</p>
                    </div>
                    <div class="flex items-center my-2">
                        <svg class="mr-4 fill-current text-grey-dark"
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             height="20">
                            <path class="heroicon-ui"
                                  d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm1-8.41l2.54 2.53a1 1 0 0 1-1.42 1.42L11.3 12.7A1 1 0 0 1 11 12V8a1 1 0 0 1 2 0v3.59z"/>
                        </svg>
                        <p class="text-navy font-bold">{{ session.start_time }} - {{ session.end_time }}</p>
                    </div>
                    <div class="flex items-center my-2">
                        <svg class="mr-4 fill-current text-grey-dark"
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20"
                             height="20">
                            <path d="M3 18a7 7 0 0 1 4-6.33V8.33A7 7 0 0 1 3 2H1V0h18v2h-2a7 7 0 0 1-4 6.33v3.34A7 7 0 0 1 17 18h2v2H1v-2h2zM5 2a5 5 0 0 0 4 4.9V10h2V6.9A5 5 0 0 0 15 2H5z"/>
                        </svg>
                        <p class="text-navy font-bold">{{ session.duration }}</p>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex items-center my-2">
                            <svg class="mr-4 fill-current text-grey-dark" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 465.03 515.03"><path d="M375.58,64.44A220,220,0,1,0,64.44,375.58a218.22,218.22,0,0,0,126.05,62.48,150.65,150.65,0,0,1-9.91-42.4C100.22,377.64,40,305.73,40,220c0-99.26,80.75-180,180-180s180,80.75,180,180a181.42,181.42,0,0,1-1.72,24.93,153.39,153.39,0,0,1,36.22,24.3A221.31,221.31,0,0,0,440,220,218.54,218.54,0,0,0,375.58,64.44Z"/><path d="M220,240H120a20,20,0,1,1,0-40h80V70a20,20,0,0,1,40,0V220A20,20,0,0,1,220,240Z"/><path d="M428.35,291.1a133.5,133.5,0,0,0-34.09-25.81A131.73,131.73,0,0,0,332.52,250C259.45,250,200,309.46,200,382.52A132.53,132.53,0,0,0,332.52,515C405.58,515,465,455.59,465,382.52A132,132,0,0,0,428.35,291.1ZM332.52,475A92.46,92.46,0,1,1,425,382.52,92.42,92.42,0,0,1,332.52,475Z"/><polygon points="395.02 362.52 395.02 402.52 352.52 402.52 352.52 445.03 312.52 445.03 312.52 402.52 270.02 402.52 270.02 362.52 312.52 362.52 312.52 320.02 352.52 320.02 352.52 362.52 395.02 362.52"/><rect x="120.01" y="120.01" width="25" height="25"/><rect x="295.02" y="120.01" width="25" height="25"/><rect x="120.01" y="295.02" width="25" height="25"/></svg>
                            <p class="text-navy font-bold">{{ session.overtime }} mins.</p>
                        </div>
                        <button @click="showOvertimePanel = true"
                                v-show="session.for_manager && !showOvertimePanel"
                                class="text-sm font-bold text-orange underline">Set Overtime
                        </button>
                    </div>
                    <div v-if="session.overtime_reason" class="text-xs pl-8">
                        <p>{{ session.overtime_reason }} - {{ session.overtime_set_by}}</p>
                    </div>
                    <div v-if="showOvertimePanel"
                         class="p-4">
                        <form action=""
                              @submit.prevent="setOvertime">
                            <p class="my-8 text-lg font-bold text-navy">Set Overtime</p>
                            <div class="my-4">
                                <label for="overtime_minutes"
                                       class="text-sm font-bold">Overtime (minutes)</label>
                                <input type="text"
                                       id="overtime_minutes"
                                       name="overtime_minutes"
                                       class="block mt-1 w-full border h-8 pl-2"
                                       v-model="manual_overtime.minutes">
                            </div>
                            <div class="my-4">
                                <label for="overtime_reason"
                                       class="text-sm font-bold">Reason for overtime</label>
                                <input type="text"
                                       id="overtime_reason"
                                       name="overtime_reason"
                                       class="block mt-1 w-full border h-8 pl-2"
                                       v-model="manual_overtime.reason">
                            </div>
                            <div class="py-4 flex justify-end items-center">
                                <button @click="showOvertimePanel = false"
                                        type="button"
                                        class="btn btn-white">Cancel
                                </button>
                                <button type="submit"
                                        :class="{'opacity-50': setting_overtime}"
                                        :disabled="setting_overtime"
                                        class="btn btn-orange ml-4">Submit
                                </button>
                            </div>
                        </form>
                    </div>
                    <div v-else>
                        <div class="mt-8 mb-4">
                            <p class="text-sm font-bold text-grey-dark tracking-wide uppercase">{{ session.client_code
                                                                                                }}</p>
                            <p class="text-navy font-bold">{{ session.client_name }}</p>
                        </div>
                        <div class="my-4">
                            <p class="text-sm font-bold text-grey-dark tracking-wide uppercase">{{
                                                                                                session.engagement_code
                                                                                                }}</p>
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
                        <div class="my-4"
                             v-if="session.notes">
                            <p class="text-sm font-bold text-grey-dark tracking-wide uppercase">Notes</p>
                            <p class="text-navy font-bold">{{ session.notes }}</p>
                        </div>
                        <div>
                            <div v-if="showDelete"
                                 class="flex justify-between border border-red p-4 h-32">
                                <p class="w-2/5">Are you sure you want to delete this session. You will not be able to
                                                 retrieve it.</p>
                                <div class="flex items-center">
                                    <button class="mr-4 font-bold text-grey-darker underline"
                                            @click="showDelete = false">Cancel
                                    </button>
                                    <button class="btn btn-red"
                                            @click="deleteSession">Yes, Delete
                                    </button>
                                </div>
                            </div>
                            <div v-else
                                 class="flex justify-end items-center p-4 h-32">
                                <button class="mr-4 font-bold text-grey-darker underline"
                                        @click="$emit('close')">Close
                                </button>
                                <button :disabled="deleting"
                                        :class="{'opacity-50': deleting}"
                                        class="btn btn-red"
                                        @click="showDelete = true">Delete
                                </button>
                            </div>

                        </div>
                    </div>


                </div>

            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['session', 'open', 'expanded'],

        data() {
            return {
                showDelete: false,
                deleting: false,
                showOvertimePanel: false,
                setting_overtime: false,
                manual_overtime: {
                    minutes: this.session.overtime,
                    reason: this.session.overtime_reason
                }
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
            },

            setOvertime() {
                this.setting_overtime = true;
                axios.post(`/admin/sessions/${this.session.id}/overtime`, this.manual_overtime)
                    .then(({data}) => this.overtimeOverwritten(data))
                    .catch(console.log)
                    .then(() => this.setting_overtime = false);
            },

            overtimeOverwritten(data) {
                this.showOvertimePanel = false;
                this.$emit('session-updated');
                this.$emit('close');
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>