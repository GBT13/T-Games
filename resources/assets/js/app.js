import Vue from 'vue'
import VueRouter from 'vue-router';
import Home from './components/Home.vue'
import Login from './components/user/login.vue'
import Register from './components/user/Register.vue';

Vue.use(VueRouter);

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
        {path: '/login', name: 'login', component: Login},
        {path: '/register', name: 'register', component: Register},

    ]
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('app', require('./components/App.vue'));

const app = new Vue({
    el: '#app',
    router
});
