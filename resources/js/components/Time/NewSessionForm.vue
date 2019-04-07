<template>
    <div class="w-screen max-w-sm mx-auto">
        <div class="border-t-2 border-orange">
            <p class="bg-navy text-white py-2 text-center text-xl font-bold">Enter time and work details</p>
            <div class="flex justify-center items-center my-4">
                <div @click="step = 1"
                     :class="{'border-orange': step >= 1, 'border-grey': step < 1}"
                     class="w-8 h-8 rounded-full border-4 flex items-center justify-center font-bold text-sm cursor-pointer text-navy">
                    1
                </div>
                <div :class="{'bg-orange': step >= 2, 'bg-grey': step < 2}"
                     class="w-4 h-1"></div>
                <div @click="step = 2"
                     :class="{'border-orange': step >= 2, 'border-grey': step < 2}"
                     class="w-8 h-8 rounded-full border-4 flex items-center justify-center font-bold text-sm cursor-pointer text-navy">
                    2
                </div>
            </div>
        </div>
        <div class="px-8 py-4 form-main-body">
            <div class="stage"
                 :class="{'inactive': step !== 1}">
                <div class="my-6">
                    <label for="session_date"
                           class="font-bold text-navy block mb-2">Session date</label>
                    <div tabindex="0"
                         ref="first_input">
                        <date-picker v-model="session.date"
                                     input-class="p-2 text-lg w-full border"></date-picker>
                    </div>
                </div>
                <div class="flex justify-between items-center my-8">
                    <div class="">
                        <label class="font-bold text-navy block mb-2"
                               for="">Start time</label>
                        <div>
                            <time-input v-model="session.start_time"></time-input>
                        </div>
                    </div>
                    <div class="">
                        <label class="font-bold text-navy block mb-2"
                               for="">End time</label>
                        <div>
                            <time-input v-model="session.end_time"></time-input>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="font-bold text-navy block mb-2"
                           for="client">Client</label>
                    <select name="client_id"
                            class="block w-full p-2 h-8 bg-white border rounded-none"
                            id="client"
                            v-model="session.client">
                        <option v-for="client in client_list"
                                :key="client.id"
                                class="p-2"
                                :value="client.id">{{ `${client.client_code}: ${client.name}` }}
                        </option>
                    </select>
                </div>
                <div class="my-8">
                    <label class="font-bold text-navy block mb-2"
                           for="enagement_code">Engagement Code:</label>
                    <select name="engagement_code"
                            class="block w-full p-2 h-8 bg-white border rounded-none"
                            id="engagement_code"
                            v-model="session.engagement_code">
                        <option v-for="engagement in engagements"
                                :key="engagement.id"
                                class="p-2"
                                :value="engagement.id">{{ `${engagement.code}: ${engagement.description}` }}
                        </option>
                    </select>
                </div>
                <div class="my-8">
                    <label class="font-bold text-navy block mb-2"
                           for="enagement_code">Service Period:</label>
                    <select name="engagement_code"
                            class="block w-full p-2 h-8 bg-white border rounded-none"
                            id="service_period"
                            v-model="session.service_period">
                        <option v-for="period in service_periods"
                                :key="period.id"
                                class="p-2"
                                :value="period.text">{{ period.text }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="stage"
                 :class="{'inactive': step !== 2}">
                <p class="font-bold text-navy block mb-2">Summary</p>
                <div class="flex justify-between mb-8">
                    <div>
                        <p>{{ summary_date }}</p>
                        <p>{{ summary_time }}</p>
                        <p>{{ summary_duration }}</p>
                    </div>
                    <div>
                        <p>{{ summary_client }}</p>
                        <p>{{ summary_engagement }}</p>
                        <p>{{ summary_period }}</p>
                    </div>
                </div>
                <div>
                    <label class="font-bold text-navy block mb-2"
                           for="description">Description:</label>
                    <textarea name="description"
                              id="description"
                              class="block w-full h-24 border"
                              v-model="session.description"
                              @focus="step = 2"
                    ></textarea>
                </div>
                <div class="my-8">
                    <label class="font-bold text-navy block mb-2"
                           for="notes">Notes:</label>
                    <textarea name="notes"
                              id="notes"
                              v-model="session.notes"
                              class="block w-full h-24 border"
                    ></textarea>
                </div>
            </div>
            <div class="stage"
                 :class="{'inactive': step !== 3}">
                <div class="flex flex-col items center text-center">
                    <p class="font-navy text xl font-bold">There is a problem!</p>
                    <p class="my-8 leading-normal">There was a problem with some of your input. Please sure tou have
                                                   filled out eveything correctly, and that your start and end times are
                                                   correct.</p>
                    <button class="btn btn-orange my-8"
                            @click="step = 1">Okay
                    </button>
                </div>
            </div>
        </div>
        <div class="p-4 flex justify-center items-center">
            <button @click="close"
                    v-if="step === 1"
                    class="btn btn-white mx-4">Cancel
            </button>
            <button @click="step = 1"
                    v-if="step === 2"
                    class="btn btn-white mx-4">Back
            </button>
            <button @click="step = 2"
                    v-if="step === 1"
                    class="btn btn-orange mx-4">Next
            </button>
            <button @click="submitSession"
                    v-if="step === 2"
                    class="btn btn-orange mx-4">Submit
            </button>
        </div>
    </div>
</template>

<script type="text/babel">
    import DatePicker from 'vuejs-datepicker';
    import TimeInput from "./TimeInput";
    import DropDownSelect from "../DropDownSelect";
    import {duration, time_hours_ago} from "../../lib/time_helpers";
    import {notify} from "../notify";


    export default {
        components: {
            DatePicker,
            TimeInput,
            DropDownSelect
        },

        props: ['client_list', 'engagements', 'service_periods', 'open'],


        data() {
            return {
                step: 1,
                session: {
                    date: new Date(),
                    start_time: time_hours_ago(2),
                    end_time: time_hours_ago(0),
                    engagement_code: 2,
                    client: 1,
                    service_period: '2019'
                },

            };
        },

        watch: {
            open(opened, closed) {
                if (opened) {
                    this.step = 1;
                    this.$refs.first_input.focus();
                }
            }
        },

        computed: {
            summary_date() {
                return this.session.date.toDateString();
            },

            summary_time() {
                return `${this.session.start_time} - ${this.session.end_time}`
            },

            summary_duration() {
                return duration(this.session.start_time, this.session.end_time);
            },

            summary_client() {
                const client = this.client_list.find(client => client.id === this.session.client);

                if (client) {
                    return client.name;
                }
            },

            summary_engagement() {
                const engagement = this.engagements.find(engagement => engagement.id === this.session.engagement_code);

                if (engagement) {
                    return engagement.description;
                }
            },

            summary_period() {
                return this.session.service_period;
            }
        },

        methods: {
            close() {
                this.$emit('close');
            },

            submitSession() {
                const session_data = {
                    session_date: this.session.date.toISOString().slice(0, 10),
                    start_time: this.session.start_time,
                    end_time: this.session.end_time,
                    service_period: this.session.service_period,
                    client_id: this.session.client,
                    engagement_code_id: this.session.engagement_code,
                    description: this.session.description,
                    notes: this.session.notes
                };

                axios.post("/admin/sessions", session_data)
                     .then(({data}) => this.sessionSaved(data))
                     .catch(({response}) => this.saveFailed(response));
            },
            sessionSaved(data) {
                this.resetSession();
                this.$emit('close');
                this.$emit('session-created');
                notify.success({message: 'Your session has been logged'});
            },
            resetSession() {
                this.session = {
                    date: new Date(),
                    start_time: time_hours_ago(2),
                    end_time: time_hours_ago(0),
                    engagement_code: 2,
                    client: 1,
                    service_period: '2019'
                };
            },
            saveFailed(res) {
                if (res.status === 422) {
                    this.step = 3;
                    return;
                }
                this.$emit('close');
                notify.error({message: 'There was a problem saving your work session. Please refresh and try again'});
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">
    .form-main-body {
        height: 550px;
        overflow: hidden;
        position: relative;
    }

    .stage {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transform: rotateX(0deg);
        padding: 2rem;
    }

    .form-main-body .stage.inactive {
        transform: rotateX(-90deg);
    }

    textarea {
        resize: none;
    }
</style>