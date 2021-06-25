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
        background: "url('../images/backgrounds/header-picture1.png') no-repeat -20% 50%, url('../images/backgrounds/header-picture2.png') no-repeat 140% 50%",

        headerInfos: {
            imageSrc: sot.absImgPath('carousel/1.jpg'),
            title: 'همه آموزش ها',
            text: `
            بعضی از وقت ها توی اتاق های فرار نیاز به اطلاعاتی داری که قبلا باید یکی بهت میگفت. ما اینجا سعی کردیم این آموزش ها رو به شما بدیم
            `
        },
        learnings: {},
        paginations: {},
    },

    methods: {
        gotoPage(url) {
            if (!url)
                return;
            axios.post(url).then(response => {
                this.learnings = response.data.data;
                this.paginations = response.data.meta.links
            });
        }
    },

    created() {
        this.gotoPage('/posts');
    }
});