<template>
    <div class="w-screen max-w-sm mx-auto">
        <div class="border-t-2 border-orange">
            <p class="bg-navy text-white py-2 text-center text-xl font-bold">時間紀錄及工作細節</p>
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
                           class="font-bold text-navy block mb-2">日期</label>
                    <div tabindex="0"
                         ref="first_input">
                        <date-picker v-model="session.date"
                                     input-class="p-2 text-lg w-full border"></date-picker>
                    </div>
                </div>
                <div class="flex justify-between items-center my-8">
                    <div class="">
                        <label class="font-bold text-navy block mb-2"
                               for="">開始時間</label>
                        <div>
                            <time-input v-model="session.start_time"></time-input>
                        </div>
                    </div>
                    <div class="">
                        <label class="font-bold text-navy block mb-2"
                               for="">結束時間</label>
                        <div>
                            <time-input v-model="session.end_time"></time-input>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="font-bold text-navy block mb-2"
                           for="client">客戶</label>
                    <select name="client_id"
                            class="block w-full p-2 min-h-8 bg-white border rounded-none"
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
                           for="enagement_code">工作事項</label>
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
                <div class="my-8">
                    <label class="font-bold text-navy block mb-2"
                           for="enagement_code">服務期間</label>
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

            <div class="stage"
                 :class="{'inactive': step !== 2}">
                <p class="font-bold text-navy block mb-2">總結</p>
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
                           for="description">說明</label>
                    <textarea name="description"
                              id="description"
                              class="block w-full h-24 border"
                              v-model="session.description"
                              @focus="step = 2"
                    ></textarea>
                </div>
                <div class="my-8">
                    <label class="font-bold text-navy block mb-2"
                           for="notes">備註</label>
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
                    <p class="font-navy text xl font-bold">有錯誤喔！</p>
                    <p class="my-8 leading-normal">請檢查資料是否正確，務必再次確認所有相關細節。</p>
                    <div class="my-8 text-red">
                        <p class="my-3" v-for="error in validation_errors">{{ error }}</p>
                    </div>
                    <button class="btn btn-orange my-8"
                            @click="step = 1">回上一頁
                    </button>
                </div>
            </div>
        </div>
        <div class="p-4 flex justify-center items-center">
            <button @click="close"
                    v-if="step === 1"
                    class="btn btn-white mx-4">取消
            </button>
            <button @click="step = 1"
                    v-if="step === 2"
                    class="btn btn-white mx-4">回上一頁
            </button>
            <button @click="step = 2"
                    v-if="step === 1"
                    class="btn btn-orange mx-4">下一頁
            </button>
            <button @click="submitSession"
                    v-if="step === 2"
                    class="btn btn-orange mx-4">確認提交
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
                validation_errors: [],
                session: {
                    date: new Date(),
                    start_time: "",
                    end_time: "",
                    engagement_code: 2,
                    client: null,
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
                this.validation_errors = [];
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
                notify.success({message: '您的紀錄已新增儲存'});
            },
            resetSession() {
                this.session = {
                    date: new Date(),
                    start_time: "",
                    end_time: "",
                    engagement_code: 2,
                    client: 1,
                    service_period: '2019'
                };
            },
            saveFailed(res) {
                if (res.status === 422) {
                    Object.keys(res.data.errors).forEach(key => {
                        res.data.errors[key].forEach(err => this.validation_errors.push(err));
                    });
                    this.step = 3;
                    return;
                }
                this.$emit('close');
                notify.error({message: '出錯了！無法順利儲存您的資料。'});
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