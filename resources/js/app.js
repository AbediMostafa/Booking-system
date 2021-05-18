require('./bootstrap');


import Vue from 'vue';
import Navbar from './components/Navbar.vue'


const vue = new Vue({

    el: '#app',
    components: {
        Navbar
    }

});