import Collections from '../components/collections/Collections.vue'
import HeaderPart from '../components/packages/Header-part.vue';


const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        Collections,
    },

    data: {
        headerInfos: {
            imageSrc: sot.absImgPath('carousel/2.jpg'),
            title: 'همه برندهای اتاق فرار',
            text: `بیش از 40 شهر و 250 اتاق فرار.با اتاق های فرار سرگرمی های مناسبی برای خودتان فراهم کنید و از ساعات مناسب برای خود 
            لذت ببرید
            `
        }
    },
});