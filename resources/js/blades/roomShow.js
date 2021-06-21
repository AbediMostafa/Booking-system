import HeaderPart from '../components/packages/Header-part.vue';
import Scores from '../components/packages/Scores.vue';
import contactInfos from '../components/packages/Contact-infos.vue';
import DescriptionBox from '../components/packages/description-box.vue'
import Comment from '../components/cards/Comment.vue';
import axios from 'axios';
import { sot } from '../sot';

const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        Scores,
        contactInfos,
        DescriptionBox,
        Comment
    },
    data: {
        room: {},
        comments: {},
        paginateInfos: {},
        headerInfos: {
            title: ''
        },
    },
    computed: {
        background() {
            return `url('../${this.room.banner}') no-repeat center/cover`;
        },
        collectionImg() {
            return this.room.collection ? this.room.collection.image : ''
        }
    },
    methods: {
        getRoom() {
            axios.post(`/${sot.exactPath}rooms/${roomId}`).then((response) => {
                this.room = response.data.data;
                this.headerInfos.title = response.data.data.name;
            });
        },

        getComments(url) {
            axios.post(url).then((response) => {
                console.log(response.data);
                this.comments = response.data.data;
                this.paginateInfos = response.data.links;
            });
        },

        iconPath(icon) {
            return sot.iconPath(icon);
        },

        imageAsBackground(image) {
            return `background: url(../${image}) no-repeat center/cover`;
        }
    },

    created() {
        this.getRoom();
        this.getComments(`/${sot.exactPath}rooms/${roomId}/comments`);
    }
});