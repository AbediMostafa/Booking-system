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
            title: '',
            text: '',
            media: ''
        }
    },
    computed: {
        background() {
            return `url('..${this.headerInfos.media}') no-repeat center center /cover`;
        }
    },

    methods: {
        getVars() {
            axios.post('/site-vars/cities-page').then(response => {
                this.headerInfos = response.data;
            });
        }
    },

    created() {
        this.getVars();
    },
});