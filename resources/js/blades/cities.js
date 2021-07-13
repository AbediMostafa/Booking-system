import Cities from '../components/cities/Cities.vue'
import HeaderPart from '../components/packages/Header-part.vue';


const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        Cities,
    },

    data: {
        headerInfos: {
            title: 'همه شهرهای دارای اتاق فرار',
            text: `بیش از 40 شهر و 250 اتاق فرار.با اتاق های فرار سرگرمی های مناسبی برای خودتان فراهم کنید و از ساعات مناسب برای خود 
            لذت ببرید
            `
        }
    },
});