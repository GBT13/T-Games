import Vue from 'vue'
import VueRouter from 'vue-router';
import App from './components/App.vue';
import Home from './components/Home.vue'
import Login from './components/user/login.vue'
import Register from './components/user/Register.vue';
import Dashboard from './components/Dashboard.vue';
import EditProfile from './components/user/EditProfile.vue';
import ShowProfile from './components/user/ShowProfile.vue';
import AccountSettings from './components/user/AccountSettings.vue';
import PageNotFound from './components/PageNotFound.vue';
import Image from './components/shared/Image.vue';
import Vuelidate from 'vuelidate';
import axios from 'axios'
import Toastr from 'vue-toastr';
import VueAxios from 'vue-axios'
import VueSelect from 'vue-select';
import VModal from 'vue-js-modal'


Vue.use(VueRouter);
Vue.use(Vuelidate);
Vue.use(VueAxios, axios);
Vue.use(VueSelect);
Vue.use(Toastr);
Vue.use(VModal, {dynamic: true});


Vue.filter('capitalize', function (value) {
    if (!value) return '';

    let splitString = value.toString().split(" ");
    splitString.forEach((element, index) => {
        splitString[index] = element.charAt(0).toUpperCase() + element.slice(1);
    });

    return splitString.join(" ");
});

/**
 *
 * @param {String} text
 * @param {Number} length
 * @param {String} clamp
 *
 */
Vue.filter('truncate', function (text, length, clamp) {
    clamp = clamp || '...';
    length = length || 30;

    if (text.length <= length) return text;

    let tcText = text.slice(0, length - clamp.length);
    let last = tcText.length - 1;

    while (last > 0 && tcText[last] !== ' ' && tcText[last] !== clamp[0]) last -= 1;

    last = last || length - clamp.length;

    tcText = tcText.slice(0, last);

    return tcText + clamp;
});

axios.defaults.baseURL = "/api";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('vue-toastr/src/vue-toastr.scss');

window.Vue = require('vue');


const router = new VueRouter({
    mode: 'history',
    routes: [
        {path: '/', name: 'home', component: Home},
        {path: '/login', name: 'login', component: Login, meta: {auth: false}},
        {path: '/register', name: 'register', component: Register, meta: {auth: false}},
        {path: '/dashboard', name: 'dashboard', component: Dashboard, meta: {auth: true}},
        {path: '/user/profile', name: 'userProfile', component: EditProfile, meta: {auth: true}},
        {path: '/user/match/:id', name: 'userMatch', component: ShowProfile, meta: {auth: true}},
        {path: '/user/account', name: 'userDetails', component: AccountSettings, meta: {auth: true}},
        {path: "*", name: 'page404', component: PageNotFound}

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
Vue.component('v-select', VueSelect);
Vue.component('v-image', Image);

App.router = Vue.router;

//Eventbus
export const eventBus = new Vue({});

const app = new Vue({
    el: '#app',
    router,
    mounted() {
        this.$toastr.defaultProgressBar = false;
        this.$toastr.defaultPosition = 'toast-bottom-center'
    }

});

