<template>
    <div>
        <div class="max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">麥當勞報表</p>
            <div class="flex justify-end">

            </div>
        </div>
        <div class="flex justify-between max-w-xl mx-auto my-12">
            <div class="w-1/2 mr-8">
                <p class="text-xl mb-6 font-black">{{ lang.files_heading }}</p>
                <label for="file_upload">
                    <span class="btn btn-orange">{{ lang.add_files }}</span>
                    <input class="hidden" type="file" @change="handleFiles" id="file_upload" accepts=".xlsx" multiple/>
                </label>
                <span
                    class="ml-8 text-lg font-bold">{{ processing_status }}</span>
                <div class="mt-8">
                    <div v-for="file in files" :key="file.id" class="my-2 p-4 shadow flex">
                        <div class="w-16 flex justify-center items-center">
                            <div class="w-4 h-4 rounded-full mr-4" :class="fileStatusColour(file)"></div>
                        </div>
                        <div class="flex-1">
                            <div class="">
                                <p class="w-full truncate"><strong>{{ lang.card_name }}: </strong>{{ file.name }}</p>
                                <p class="mt-2"><strong>{{ lang.card_company }}: </strong>{{ file.company }}</p>
                                <p class="mt-2"><strong>{{ lang.card_status }}: </strong>{{ file.status }}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/2 ml-8">
                <p class="text-xl mb-6 font-black">{{ lang.report_heading }}</p>
                <div class="mb-6">
                    <p class="mb-2"><strong>{{ lang.report_date_label }}:</strong></p>
                    <label class="font-bold" for="report_year">{{ lang.year_label }}</label>
                    <select class="text-3xl" name="year" id="report_year" v-model="current_year">
                        <option v-for="year in years" :value="year">{{ year }}</option>
                    </select>
                    <label class="ml-6 font-bold" for="report_month">{{ lang.month_label }}</label>
                    <select class="text-3xl" name="year" id="report_month" v-model="current_month">
                        <option v-for="month in months" :value="month">{{ month }}</option>
                    </select>
                </div>
                <div class="my-4">
                    <label for="filename" class="font-bold block mb-2">{{ lang.filename_label }}: </label>
                    <input type="text" v-model="filename" id="filename"
                           class="p-2 bg-grey-lightest inline-block border">
                </div>
                <div class="mt-8">
                    <button :disabled="!canReport" class="btn btn-orange" @click="submit">{{ lang.make_report }}
                    </button>
                </div>
            </div>

        </div>
        <div>

        </div>

    </div>
</template>

<script type="text/babel">
    import blueprint from "../../lib/blueprint";
    import xlsx from "xlsx";
    import axios from "axios";
    import {notify} from "../notify";

    function makeYears() {
        const start = (new Date()).getFullYear() - 4;

        return [1, 2, 3, 4, 5, 6, 7, 8].map(inc => start + inc);
    }

    function getCurrentMonth() {
        const month = (new Date()).getMonth() + 1;

        return month < 10 ? `0${month}` : `${month}`;
    }

    function orderBy(prop) {
        return (a, b) => {
            if (a[prop] > b[prop]) {
                return 1;
            }

            if (a[prop] < b[prop]) {
                return -1;
            }

            return 0;
        }
    }

    export default {
        data() {
            return {
                processed: [],
                files: [],
                next_id: 1,
                years: makeYears(),
                months: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
                current_year: (new Date()).getFullYear(),
                current_month: getCurrentMonth(),
                filename: '麥當勞報表.xlsx',
                lang: {
                    files_heading: '檔案',
                    add_files: '新增檔案',
                    card_name: '檔案名稱',
                    card_company: '公司代號',
                    card_status: '狀態',
                    report_heading: '報告',
                    report_date_label: '報告日期',
                    year_label: '年',
                    month_label: '月',
                    filename_label: '新檔案名稱',
                    make_report: '下載檔案',
                    error_read: '無法讀取檔案資料',
                    error_duplicate: '此公司的檔案已新增了',
                    error_invalid: '這不是有效的Excel檔',
                    error_format: '檔案形式不正確',
                    status_checked: '已確認',
                }
            };
        },

        computed: {
            report_date() {
                return `${this.current_year}${this.current_month}01`;
            },

            ordered_reports() {
                return this.processed.sort(orderBy('company_id'));
            },

            processing_status() {
                return `${this.processed.length} of ${this.files.length} 檔案已成功新增`;
            },

            canReport() {
                const has_processed = this.processed.length > 0;
                const finished_checking = this.files.filter(f => !f.processed).length === 0;
                const has_filename = this.filename !== "";

                return has_processed && finished_checking && has_filename;
            }

        },

        methods: {
            handleFiles({target}) {
                [...target.files].forEach(this.readFile);
                target.files.value = null;
            },

            readFile(file) {
                const new_file = this.makeFile(file.name);
                this.files.push(new_file);

                if (file.name.split(".").pop() !== 'xlsx') {
                    this.setFileTypeError(new_file.id);
                    return;
                }

                const reader = new FileReader();
                reader.onload = (data) => {
                    this.handleData(data, new_file.id);
                };
                reader.onerror = () => this.setReadError(new_file.id);

                reader.readAsArrayBuffer(file);
            },

            makeFile(file_name) {
                const file = {
                    id: this.next_id,
                    name: file_name,
                    company: '',
                    status: '',
                    error: false,
                    processed: false
                };

                this.next_id++;

                return file;
            },

            handleData(e, id) {

                const data = new Uint8Array(e.target.result);
                const workbook = xlsx.read(data, {type: "array"});

                if (!this.checkCorrectFormat(workbook)) {
                    this.setFormatError(id);
                    return;
                }

                const company_id = workbook.Sheets["試算表-累計(MCD)"]["B3"].v;

                if (this.hasProcessedCompany(company_id)) {
                    this.setDuplicateError(id, company_id);
                    return;
                }

                const report = blueprint.reduce((acc, row) => {
                    const cell = workbook.Sheets[row.sh][row.cell];
                    const val = cell ? cell.v : "";
                    acc[row.id] = val;
                    return acc;
                }, {});
                this.processed.push({
                    company_id,
                    report
                });
                this.setStatusProcessed(id, company_id);
            },

            checkCorrectFormat(workbook) {
                const expected_sheets = ["試算表(文中版)", "試算表-累計(MCD)", "損益表(MCD)", "資產負債表(MCD)"];
                const missing = expected_sheets.filter(sheet => !workbook.Sheets[sheet]);

                if (missing.length) {
                    return false;
                }

                const company_id_exists = workbook.Sheets["試算表-累計(MCD)"]["B3"] &&
                    workbook.Sheets["試算表-累計(MCD)"]["B3"].v;

                return company_id_exists;
            },

            hasProcessedCompany(company_id) {
                return this.processed.find(pro => pro.company_id === company_id);
            },

            submit() {
                axios.post("/admin/mac-reports", {
                    date: this.report_date,
                    reports: this.ordered_reports,
                    filename: this.filename,
                })
                     .then(({data}) => {
                         window.location = `/admin/mac-reports/${data.cache_key}`;
                     })
                     .catch(console.log);
            },

            setStatusProcessed(id, company_id) {
                const file = this.files.find(file => file.id === id);
                file.status = this.lang.status_checked;
                file.company = company_id;
                file.error = false;
                file.processed = true;
            },

            setReadError(id) {
                const file = this.files.find(file => file.id === id);
                file.status = this.lang.error_read;
                file.error = true;
                file.processed = true;
            },

            setFormatError(id) {
                const file = this.files.find(file => file.id === id);
                file.status = this.lang.error_format;
                file.error = true;
                file.processed = true;
            },

            setDuplicateError(id, company_id) {
                const file = this.files.find(file => file.id === id);
                file.status = this.lang.error_duplicate;
                file.company = company_id;
                file.error = true;
                file.processed = true;
            },

            setFileTypeError(id) {
                const file = this.files.find(file => file.id === id);
                file.status = this.lang.error_invalid;
                file.error = true;
                file.processed = true;
            },

            fileStatusColour(file) {
                if (!file.processed) {
                    return 'bg-grey-light';
                }

                return file.error ? 'bg-red' : 'bg-green';
            }
        }
    }
</script>
