require('../bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from '../components/Routes/routes.js';
import Navbar from '../components/dashboard/Navbar.vue';
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import ScrollAnimation from '../directives/slow-move.js';


Vue.directive('scrollAnimation', ScrollAnimation);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin);
Vue.use(VueRouter);

const router = new VueRouter({
    routes
});

const vue = new Vue({
    router,
    components: {
        Navbar,
    },
    el: '#app',
});
