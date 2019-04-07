
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

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

import UserSessionsIndex from "./components/Time/UserSessionsIndex";

Vue.component('dropdown-menu', Dropdown);
Vue.component('modal', Modal);
Vue.component('vue-form', VueForm);

Vue.component('notification-hub', NotificationHub);
Vue.component('users-index', UsersIndex);
Vue.component('user-page', UserPage);
Vue.component('profile-page', ProfilePage);

Vue.component('client-index', ClientIndex);
Vue.component('client-page', ClientPage);
Vue.component('engagement-codes-index', EngagementCodesIndex);
Vue.component('engagement-code-page', EngagementCodePage);

Vue.component('user-sessions-index', UserSessionsIndex);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
