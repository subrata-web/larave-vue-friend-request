/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window.Vue = require('vue').default;

import Vue from 'vue'
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import Toasted from 'vue-toasted';
import App from './app.vue';
import { routes } from './routes';

axios.defaults.withCredentials = true;
axios.defaults.baseURL = process.env.MIX_VUE_APP_ROOT_DEV_API;

Vue.config.productionTip = false;

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(Toasted, {
    duration: 4000,
    theme: 'toasted-primary',
    iconPack: 'material',
    action: {
        text: 'Close',
        onClick: (e, toastObject) => {
            toastObject.goAway(0);
        }
    }
});
const router = new VueRouter({
    mode: 'history',
    routes: routes,
    linkActiveClass: 'active'
});
const loginToken = window.localStorage.getItem("logintoken") || "";
const isAuthenticated = loginToken ? true : false;

// setting auth middleware

new Vue({
    el: '#app',
    router: router,
    render: (h) => h(App)
});