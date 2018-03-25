import Vue from 'vue'
import VueRouter from 'vue-router';
import App from './components/App.vue';
import Home from './components/Home.vue'
import Login from './components/user/login.vue'
import Register from './components/user/Register.vue';
import Dashboard from './components/Dashboard.vue';
import UserProfile from './components/user/Profile.vue';
import AccountSettings from './components/user/AccountSettings.vue';
import Vuelidate from 'vuelidate';
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(VueRouter);
Vue.use(Vuelidate);
Vue.use(VueAxios, axios);

axios.defaults.baseURL="/api";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


const router = new VueRouter({
    mode: 'history',
    routes: [
        {path: '/', name: 'home', component: Home},
        {path: '/login', name: 'login', component: Login, meta: {auth: false}},
        {path: '/register', name: 'register', component: Register, meta: {auth: false}},
        {path: '/dashboard', name: 'dashboard', component: Dashboard, meta: {auth: true}},
        {path: '/user/profile', name: 'userProfile', component: UserProfile, meta: {auth: true}},
        {path: '/user/account', name: 'userDetails', component: AccountSettings, meta: {auth: true}},

    ]
});

Vue.router = router;

/**
 * Needed for authentication
 */
Vue.use(require('@websanova/vue-auth'), {

    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),

    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),

    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
    notFoundRedirect: {path: '/'}
});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('app', require('./components/App.vue'));

App.router = Vue.router;

const app = new Vue({
    el: '#app',
    router
});
