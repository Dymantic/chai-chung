<template>
    <div>
        <div class="max-w-xl mx-auto flex justify-between">
            <div class="px-8">
                <p class="text-sm font-bold mb-2">從:</p>
                <date-picker class="border py-2 pl-2" v-model="start"></date-picker>
            </div>
            <div class="px-8">
                <p class="text-sm font-bold mb-2">到:</p>
                <date-picker class="border py-2 pl-2" v-model="end"></date-picker>
            </div>
            <div class="pr-8 pt-6">
                <button @click="fetchReport" class="btn btn-orange">確認</button>
            </div>
        </div>
        <div class="my-20 max-w-md mx-auto" v-if="rows.length">
            <div class="flex justify-between my-12">
                <p class="text-lg font-bold text-navy">{{ start_date}} - {{ end_date }}</p>
                <div>
                    <button @click="clearReport" class="btn btn-white">清除</button>
                    <button @click="exportReport" class="btn btn-orange ml-4">下載</button>
                </div>
            </div>


        </div>
        <table class="w-full max-w-lg mx-auto">
            <thead>
            <tr>
                <th v-for="heading in headings" class="text-left">{{ heading }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in rows" :key="row.id" class="hover:bg-grey-lighter">
                <td v-for="value in row" class="py-1">{{ value }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script type="text/babel">
    import DatePicker from "vuejs-datepicker";
    import {subDays} from "date-fns";

    export default {
        components: {
            DatePicker
        },

        props: ['fetch-url', 'export-url'],

        data() {
            return {
                start: subDays(new Date(), 31),
                end: new Date(),
                rows: [],
                headings: [],
            };
        },

        computed: {
            date_query() {
                return `from=${this.start.toISOString().slice(0,10)}&to=${this.end.toISOString().slice(0,10)}`;
            },

            start_date() {
                return this.start.toDateString();
            },

            end_date() {
                return this.end.toDateString();
            }
        },

        methods: {
            fetchReport() {
                return new Promise((resolve, reject) => {
                    axios.get(`${this.fetchUrl}?${this.date_query}`)
                        .then(({data}) => {
                            this.rows = data.rows;
                            this.headings = data.headings;
                            resolve();
                        })
                        .catch(() => reject({message: '系統無法讀取資料'}));
                });
            },

            clearReport() {
                this.rows = [];
            },

            exportReport() {
                window.location = `${this.exportUrl}?${this.date_query}`;
            }
        }
    }
</script>

<style scoped lang="less" type="text/css">

</style>