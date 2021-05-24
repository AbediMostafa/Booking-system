require('./bootstrap');


import Vue from 'vue';
import Navbar from './components/landing/Navbar.vue';
import Carousel from './components/landing/Carousel.vue';
import SpecialRooms from './components/landing/Special-rooms.vue';
import ScrollAnimation from './directives/slow-move.js';
import FullVideo from './components/landing/Full-video.vue';
import Learning from './components/landing/Learning.vue';
import Collections from './components/landing/Collections.vue'

Vue.directive('scrollAnimation', ScrollAnimation);

const vue = new Vue({
    el: '#app',
    components: {
        Navbar,
        Carousel,
        SpecialRooms,
        FullVideo,
        Learning,
        Collections
    }
});