import HeaderPart from '../components/packages/Header-part.vue';


const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
    },

    data: {
        headerInfos: {
            title: 'درباره ما',
            text: '',
            media: ''
        }
    },
});