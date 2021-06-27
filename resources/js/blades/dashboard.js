require('../bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from '../components/Routes/routes.js';
import Navbar from '../components/dashboard/Navbar.vue';

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
    methods: {
        background(icon, position) {
            return `background: url(${sot.imgPath(icon)}) no-repeat ${position} center/contain;`
        },
    },
});