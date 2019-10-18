<template>
    <div class="flex justify-between" v-if="ready">
        <form @submit.prevent="submit" class="max-w-md pl-4 shadow py-8">
            <p class="border-b mb-8">時間</p>
            <div class="flex items-center mb-12 px-8">

                <div class="mr-6">
                    <label for="session_date"
                           class="font-bold text-navy block mb-2">日期</label>
                    <div tabindex="0"
                         ref="first_input">
                        <date-picker v-model="session.date"
                                     input-class="p-2 text-lg w-full border"></date-picker>
                    </div>
                </div>
                <div class="mx-6">
                    <label class="font-bold text-navy block mb-2"
                           for="">開始時間</label>
                    <div>
                        <time-input v-model="session.start_time"></time-input>
                    </div>
                </div>
                <div class="mx-6">
                    <label class="font-bold text-navy block mb-2"
                           for="">結束時間</label>
                    <div>
                        <time-input v-model="session.end_time"></time-input>
                    </div>
                </div>
            </div>
            <p class="border-b mb-8">客戶</p>
            <div class="flex items-center mb-12 pl-8">
                <div class="w-64">
                    <label class="font-bold text-navy block mb-2"
                           for="client">客戶</label>
                    <select name="client_id"
                            class="block w-full px-2 min-h-8 bg-white border rounded-none"
                            id="client"
                            v-model="session.client">
                        <option v-for="client in client_list"
                                :key="client.id"
                                class="p-2"
                                :value="client.id">{{ `${client.client_code}: ${client.name}` }}
                        </option>
                    </select>
                </div>
                <div class="mx-4">
                    <label class="font-bold text-navy block mb-2"
                           for="engagement_code">工作事項</label>
                    <select name="engagement_code"
                            class="block w-full p-2 min-h-8 bg-white border rounded-none"
                            id="engagement_code"
                            v-model="session.engagement_code">
                        <option v-for="engagement in engagements"
                                :key="engagement.id"
                                class="p-2"
                                :value="engagement.id">{{ `${engagement.code}: ${engagement.description}` }}
                        </option>
                    </select>
                </div>
                <div class="mx-4">
                    <label class="font-bold text-navy block mb-2"
                           for="service_period">服務期間</label>
                    <select name="engagement_code"
                            class="block w-full p-2 min-h-8 bg-white border rounded-none"
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
            <p class="border-b mb-8">紀錄</p>
            <div class="flex mb-12 px-8">
                <div class="w-80">
                    <label class="font-bold text-navy block mb-2"
                           for="description">說明</label>
                    <textarea name="description"
                              id="description"
                              class="block w-full h-16 border"
                              v-model="session.description"
                    ></textarea>
                </div>
                <div class="mx-8 w-80">
                    <label class="font-bold text-navy block mb-2"
                           for="notes">備註</label>
                    <textarea name="notes"
                              id="notes"
                              v-model="session.notes"
                              class="block w-full h-16 border"
                    ></textarea>
                </div>
            </div>
            <div class="my-8 flex justify-center">
                <button :disabled="waiting" type="submit" class="w-64 btn btn-orange">{{ button_text }}</button>
            </div>
        </form>
        <div class="p-8">
            <p v-if="validation_errors.length" class="text-lg font-bold text-red mb-6">錯誤</p>
            <p class="mb-4" v-for="error in validation_errors">{{ error }}</p>
        </div>
    </div>
</template>

<script type="text/babel">
    import DatePicker from "vuejs-datepicker";
    import TimeInput from "./TimeInput";
    import {formattedDate} from "../../lib/time_helpers";

    export default {
        components: {
            DatePicker,
            TimeInput,
        },

        props: ['original-session'],

        data() {
            return {
                ready: false,
                waiting: false,
                validation_errors: [],
                session: {
                    date: new Date(),
                    start_time: '',
                    end_time: '',
                    client: '',
                    engagement_code: '',
                    service_period: `${(new Date()).getFullYear()}`,
                    notes: '',
                    description: '',
                }
            };
        },

        computed: {
            client_list() {
                return this.$store.state.userSessions.clients;
            },

            engagements() {
                return this.$store.state.userSessions.engagements;
            },

            service_periods() {
                return this.$store.state.userSessions.service_periods;
            },

            is_edit() {
                return !! this.originalSession;
            },

            button_text() {
                return this.is_edit ? '更新' : '儲存';
            }

        },

        watch: {
            client_list() {
                this.checkReady();
            },

            engagements() {
                this.checkReady();
            },

            service_periods() {
                this.checkReady();
            }
        },

        mounted() {
            this.checkReady();
            this.setInitialState();
        },

        methods: {
            checkReady() {
                this.ready = (this.client_list.length > 0) && (this.engagements.length > 0) && (this.service_periods.length > 0);
            },

            setInitialState() {
              if(!this.originalSession) {
                  return this.session = {
                      date: new Date(),
                      start_time: '',
                      end_time: '',
                      client: '',
                      engagement_code: '',
                      service_period: `${(new Date()).getFullYear()}`,
                      notes: '',
                      description: '',
                  };
              }

              const orig_date = this.originalSession.date_comp;

              this.session = {
                  date: new Date(orig_date.slice(0,4), orig_date.slice(4,6), orig_date.slice(6,8)),
                  start_time: this.originalSession.start_time,
                  end_time: this.originalSession.end_time,
                  client: this.originalSession.client_id,
                  engagement_code: this.originalSession.engagement_code_id,
                  service_period: this.originalSession.service_period,
                  notes: this.originalSession.notes,
                  description: this.originalSession.description,
              };
            },

            submit() {
                this.validation_errors = [];
                this.waiting = true;
                const session_data = {
                    session_date: formattedDate(this.session.date),
                    start_time: this.session.start_time,
                    end_time: this.session.end_time,
                    service_period: this.session.service_period,
                    client_id: this.session.client,
                    engagement_code_id: this.session.engagement_code,
                    description: this.session.description,
                    notes: this.session.notes
                };
                this.$store.dispatch('userSessions/saveSession', {
                    formData: session_data,
                    id: this.originalSession ? this.originalSession.id : null,
                })
                    .then(this.onSaveSuccess)
                    .catch(response => this.onSaveError(response))
                    .then(() => this.waiting = false);
            },

            onSaveSuccess() {
                this.$emit('session-saved');

                this.session = {
                    date: new Date(),
                    start_time: '',
                    end_time: '',
                    client: '',
                    engagement_code: '',
                    service_period: `${(new Date()).getFullYear()}`,
                    notes: '',
                    description: '',
                };


            },

            onSaveError({status, data}) {
                if (status === 422) {
                    Object.keys(data.errors).forEach(key => {
                        data.errors[key].forEach(err => this.validation_errors.push(err));
                    });
                    this.$emit('invalid-session-data');
                    return;
                }
                this.$emit('session-save-failed');

            }
        }
    }
</script>
