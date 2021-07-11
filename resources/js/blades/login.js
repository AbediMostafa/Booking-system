import HeaderPart from '../components/packages/Header-part.vue';


const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
    },

    data: {
        headerInfos: {
            imageSrc: sot.absImgPath('carousel/2.jpg'),
            title: 'ورود',
            text: `برای مدیریت سایت نیاز دارید که وارد شوید.
            `
        }
    },
});