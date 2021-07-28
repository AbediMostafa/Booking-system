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

        headerInfos: {
            title: '',
            text: '',
            media: ''
        },
        learnings: {},
        paginations: {},
    },
    computed: {
        background() {
            return `url('..${this.headerInfos.media}') no-repeat center center /cover`;
        }
    },

    methods: {
        gotoPage(url) {
            if (!url)
                return;
            axios.post(url).then(response => {
                this.learnings = response.data.data;
                this.paginations = response.data.meta.links
            });
        },

        getVars() {
            axios.post('/site-vars/learnings-page').then(response => {
                this.headerInfos = response.data;
            });
        }
    },

    created() {
        this.getVars();
        this.gotoPage('/posts');
    }
});