<template>
    <div>
        <div class="px-8 max-w-xl mb-20 mt-4 mx-auto items-center flex justify-between">
            <p class="font-black text-5xl">員工請假申請</p>
            <div class="flex justify-end">

            </div>
        </div>
        <div>
            <undecided-request v-for="request in requests"
                               :key="request.id"
                               :request="request"
                               @request-accepted="requestAccepted"
                               @request-denied="requestDenied"
                               @action-failed="requestActionError"
            ></undecided-request>
            <big-notice v-if="fetched_list && (requests.length === 0)"
                        text="There are no current requests.">
            </big-notice>
        </div>
        <div class="max-w-lg mx-auto">
            <p class="text-3xl font-black mb-12">Upcoming Leave</p>
            <upcoming-leave v-for="leave in upcoming" :key="leave.id" :leave="leave"></upcoming-leave>
            <big-notice v-if="fetched_upcoming && (upcoming.length === 0)"
                        text="There is no upcoming leave.">
            </big-notice>
        </div>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../notify";
    import UndecidedRequest from "./UndecidedRequest";
    import UpcomingLeave from "./UpcomingLeave";
    import BigNotice from "../BigNotice";

    export default {
        components: {BigNotice, UndecidedRequest, UpcomingLeave},
        data() {
            return {
                requests: [],
                upcoming: [],
                fetched_list: false,
                fetched_upcoming: false,
            };
        },

        mounted() {
            this.refreshList();

            this.fetchUpcoming()
                .catch(notify.error);
        },

        methods: {

            fetchRequests() {
                return new Promise((resolve, reject) => {
                    axios.get("/admin/staff-leave-requests")
                         .then(({data}) => {
                             this.requests = data;
                             this.fetched_list = true;
                             resolve();
                         })
                         .catch(() => reject({message: '系統無法讀取資料'}));
                });
            },

            fetchUpcoming() {
                return new Promise((resolve, reject) => {
                    axios.get("/admin/upcoming-leave")
                        .then(({data}) => {
                            this.upcoming = data;
                            this.fetched_upcoming = true;
                            resolve();
                        })
                        .catch(() => reject({message: 'failed to fetch upcoming leave'}))
                })
            },

            refreshList() {
                this.fetchRequests()
                    .catch(notify.error);
            },

            refreshUpcoming() {
                this.fetchUpcoming()
                    .catch(notify.error);
            },


            requestActionError() {
                notify.error({message: '系統無法存取資料'});
                this.refreshList();
            },

            requestAccepted() {
                notify.success({message: '已批准請假申請'});
                this.refreshList();
                this.refreshUpcoming();
            },

            requestDenied() {
                notify.success({message: '已拒絕請假申請'});
                this.refreshList();
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">

</style>