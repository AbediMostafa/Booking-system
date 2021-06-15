require('./bootstrap');

import Vue from 'vue';
import ScrollAnimation from './directives/slow-move.js';
import Navbar from './components/landing/Navbar.vue';
import SiteFooter from './components/landing/Site-footer.vue';

window.Vue = Vue;

Vue.directive('scrollAnimation', ScrollAnimation);

Vue.component('navbar', Navbar);
Vue.component('site-footer', SiteFooter);