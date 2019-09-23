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
                    <button @click="download" class="text-grey-darker hover:text-orange bg-white mx-4">下載</button>
                </div>

            </div>
        </div>
        <div class="my-6 flex justify-end items-center max-w-xl mx-auto px-8">
            <label for="show_cancelled_checkbox">另外顯示已取消的請求： </label>
            <input type="checkbox" class="ml-2" id="show_cancelled_checkbox" v-model="show_cancelled">
        </div>
        <big-notice v-if="no_records"
                    text="沒有任何記錄">
        </big-notice>
        <big-notice v-if="fetching" text="請等待..."></big-notice>
        <div class="my-16 max-w-xl mx-auto" v-if="!fetching">
            <div v-for="(records, month) in sorted_months" :key="month">
                <p class="text-xl font-bold mb-6 uppercase">{{ month }}</p>
                <table class="w-full p-4 bg-white mb-12">
                    <thead>
                        <tr class="">
                            <th class="pb-2 text-left">姓名</th>
                            <th class="text-left">開始</th>
                            <th class="text-left">結束</th>
                            <th class="text-left">代班</th>
                            <th class="text-left">請假類別</th>
                            <th class="text-left">狀態</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="request in records" :key="request.id" v-if="!request.was_cancelled || (show_cancelled)">
                            <td class="pb-1">{{ request.requestee }}</td>
                            <td>
                                <span>{{ request.starts_date.slice(5) }}</span>

                                <span class="ml-2 text-sm text-grey-dark">{{ request.starts_time }}</span>
                                <span class="ml-2 text-sm text-grey-dark">{{ request.starts_day }}</span>
                            </td>
                            <td>
                                <span>{{ request.ends_date.slice(5) }}</span>
                                <span class="ml-2 text-sm text-grey-dark">{{ request.ends_time }}</span>
                                <span class="ml-2 text-sm text-grey-dark">{{ request.ends_day }}</span>
                            </td>
                            <td>{{ request.covered_by }}</td>
                            <td>{{ request.leave_type }}</td>
                            <td>{{ request.status_summary }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../notify";
    import BigNotice from "../BigNotice";


    export default {
        components: {
            BigNotice
        },

        data() {
            return {
                monthly_requests: [],
                year: (new Date).getFullYear(),
                show_cancelled: false,
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
            },

            download() {
                window.location = `/admin/exports/reports/annual-leave?year=${this.year}`;
            }
        }
    }
</script>

<style scoped lang="scss" type="text/scss">

</style>