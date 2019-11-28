
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from "vue";

import VueRouter from "vue-router";
import Vuex from "vuex";

Vue.use(VueRouter);
Vue.use(Vuex);

import userSessionsStore from "./stores/user-sessions";

const store = new Vuex.Store({
    modules: {
        userSessions: userSessionsStore,
    }
});

import UserSessionsIndex from "./components/Time/UserSessionsIndex";
import UserSessionsPage from "./components/Time/UserSessionsPage";
import AddSessionForm from "./components/Time/AddSessionForm";
import EditSessionForm from "./components/Time/EditSessionForm";

const routes = [
    {path: '/', component: UserSessionsIndex},
    {path: '/sessions/create', component: AddSessionForm},
    {path: '/sessions/:id/edit', component: EditSessionForm},
];

const router = new VueRouter({routes});

import {Dropdown} from "@dymantic/vuetilities";
import Modal from "@dymantic/modal";
import {VueForm} from "@dymantic/vue-forms";

import NotificationHub from "./components/NotfificationHub";

import UsersIndex from "./components/Users/UsersIndex";
import UserPage from "./components/Users/UserPage";

import ProfilePage from "./components/Users/ProfilePage";

import ClientIndex from "./components/Clients/ClientIndexPage";
import ClientPage from "./components/Clients/ClientPage";
import EngagementCodesIndex from "./components/Clients/EngagementCodesIndex";
import EngagementCodePage from "./components/Clients/EngagementCodePage";



import HolidaysIndexPage from "./components/Time/HolidaysIndexPage";

import ManageSesions from "./components/Time/ManageSessions";

import TimeReport from "./components/Reports/TimeReport";
import DownloadReportButton from "./components/Reports/DownloadReportButton";

import StaffLeavePage from "./components/Leave/StaffLeavePage";
import CoveringRequestsPage from "./components/Leave/CoveringRequestsPage";
import ManageStaffLeavePage from "./components/Leave/ManageStaffLeavePage";
import PastLeaveRequests from "./components/Leave/PastLeaveRequests";

import MacReportsPage from "./components/MacDonalds/CreateSummaryPage";

Vue.component('dropdown-menu', Dropdown);
Vue.component('modal', Modal);
Vue.component('vue-form', VueForm);

Vue.component('notification-hub', NotificationHub);
Vue.component('user-sessions-page', UserSessionsPage);
Vue.component('users-index', UsersIndex);
Vue.component('user-page', UserPage);
Vue.component('profile-page', ProfilePage);

Vue.component('client-index', ClientIndex);
Vue.component('client-page', ClientPage);
Vue.component('engagement-codes-index', EngagementCodesIndex);
Vue.component('engagement-code-page', EngagementCodePage);

Vue.component('user-sessions-index', UserSessionsIndex);

Vue.component('holidays-index-page', HolidaysIndexPage);
Vue.component('manage-sessions', ManageSesions);

Vue.component('time-report', TimeReport);
Vue.component('download-report-button', DownloadReportButton);
Vue.component('staff-leave-page', StaffLeavePage);
Vue.component('covering-requests-page', CoveringRequestsPage);
Vue.component('manage-staff-leave-page', ManageStaffLeavePage);
Vue.component('past-leave-requests', PastLeaveRequests);

Vue.component('mac-reports-page', MacReportsPage);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store,
});
