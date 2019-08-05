<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">過去請假紀錄</p>
            <div class="flex justify-end items-center">
                <div class="flex-inline">
                    <select name="for_year" v-model="year"
                            id="for_year">
                        <option :value="current_year">{{ current_year }}</option>
                        <option v-for="y in previous_years" :value="y">{{ y }}</option>
                    </select>
                    <button class="btn btn-orange" @click="refreshRequests">查看</button>
                </div>

            </div>
        </div>
        <big-notice v-if="no_records"
                    text="沒有任何記錄">
        </big-notice>
        <big-notice v-if="fetching" text="請等待..."></big-notice>
        <div class="my-16 max-w-xl mx-auto" v-if="!fetching">
            <div v-for="(records, month) in sorted_months" :key="month">
                <p class="text-xl uppercase">{{ month }}</p>
                <past-leave-record v-for="request in records" :key="request.id" :record="request"></past-leave-record>

            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../notify";
    import PastLeaveRecord from "./PastLeaveRecord";
    import BigNotice from "../BigNotice";


    export default {
        components: {
            PastLeaveRecord,
            BigNotice
        },

        data() {
            return {
                monthly_requests: [],
                year: (new Date).getFullYear(),
                current_year: (new Date).getFullYear(),
                previous_years: [1,2,3,4,5,6,7,8,9].map(y => {
                    return (new Date).getFullYear() - y;
                }),
                fetching: false,
                has_fetched: false,
            };
        },

        computed: {
            sorted_months() {
                const ordered = {};
                const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                Object.keys(this.monthly_requests)
                      .sort((a, b) => months.indexOf(a) - months.indexOf(b))
                    .forEach(key => ordered[key] = this.monthly_requests[key]);

                return ordered;
            },

            no_records() {
                return this.has_fetched && (this.monthly_requests.length === 0);
            }
        },

        mounted() {
            this.refreshRequests();
        },

        methods: {

            fetchRequests() {
                this.fetching = true;
                return new Promise((resolve, reject) => {
                    axios.get(`/admin/past-leave-requests?year=${this.year}`)
                        .then(({data}) => {
                            this.monthly_requests = data;
                            resolve();
                        })
                        .catch(() => reject({message: '系統無法讀取資料'}))
                         .then(() => this.has_fetched = true)
                        .then(() => this.fetching = false);
                });
            },

            refreshRequests() {
                this.fetchRequests().catch(notify.error);
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>