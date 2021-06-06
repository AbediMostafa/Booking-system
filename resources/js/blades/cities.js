import Vue from 'vue';
import Navbar from '../components/landing/Navbar.vue';
import Cities from '../components/cities/Cities.vue'
import HeaderPart from '../components/packages/Header-part.vue';
import SiteFooter from '../components/landing/Site-footer.vue';
import ScrollAnimation from '../directives/slow-move.js';

Vue.directive('scrollAnimation', ScrollAnimation);

const vue = new Vue({
    el: '#app',
    components: {
        Navbar,
        HeaderPart,
        Cities,
        SiteFooter,
    },

    data: {
        headerInfos: {
            imageSrc: sot.absImgPath('carousel/1.jpg'),
            title: 'همه شهرهای دارای اتاق فرار',
            text: `بیش از 40 شهر و 250 اتاق فرار.با اتاق های فرار سرگرمی های مناسبی برای خودتان فراهم کنید و از ساعات مناسب برای خود 
            لذت ببرید
            `
        }
    },
});