import HeaderPart from '../components/packages/Header-part.vue';
import LearningCard from "../components/cards/Learning-card.vue";
import axios from 'axios';

const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        LearningCard
    },

    data: {
        newses: {},
        paginations: {},
        headerInfos: {
            title: '',
            text: '',
            media: ''
        },
    },
    computed: {
        background() {
            return `url('..${this.headerInfos.media}') no-repeat center center /cover`;
        },
    },

    methods: {
        gotoPage(url = '/news') {

            let data = {
                method:'siteIndex'
            }

            axios.post(url, data).then(response => {
                this.newses = response.data.data;
                this.paginations = response.data.meta.links
            });
        },
        getVars() {
            axios.post('/site-vars/news-page').then(response => {
                this.headerInfos = response.data;
            });
        }
    },

    created() {
        this.gotoPage();
        this.getVars();
    }
});
