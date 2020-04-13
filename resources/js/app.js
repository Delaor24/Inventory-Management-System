require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

//sweetalert2
import Swal from "sweetalert2";
window.Swal = Swal;
const Toast = Swal.mixin({
    toast:true,
    position:'top-end',
    showConfirmButton:false,
    timer:3000,
});
//laravel vue pagination
Vue.component('pagination', require('laravel-vue-pagination'));
window.Toast = Toast;
//notification
import Notification from "./Helpers/Notification";
window.Notification = Notification;
// globally onreload
window.Reload = new Vue();
//import user helpers
import User from "./Helpers/User";
window.User = User;
import {routes} from './routes';
const router = new VueRouter({
    routes,
});
const app = new Vue({
    el: '#app',
    router,
});
