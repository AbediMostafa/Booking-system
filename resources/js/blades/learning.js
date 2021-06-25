import HeaderPart from '../components/packages/Header-part.vue';
import ComplicatedRoomCard from '../components/cards/Complicated-room-card.vue';
import axios from 'axios';
import { sot } from '../sot';

const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        ComplicatedRoomCard
    },

    data: {
        background: "url('../images/backgrounds/header-picture1.png') no-repeat -20% 50%, url('../images/backgrounds/header-picture2.png') no-repeat 140% 50%",

        headerInfos: {
            imageSrc: sot.absImgPath('carousel/1.jpg'),
            title: 'همه آموزش ها',
        },

        post: {},
        specialRooms: {}
    },

    methods: {
        getPost(url) {
            axios.post(url).then(response => {
                this.post = response.data.data.post;
                this.specialRooms = response.data.data.special_rooms;
                this.headerInfos.title = this.post.title;
            });
        },
        iconPath(icon) {
            return sot.iconPath(icon)
        }
    },

    created() {
        this.getPost(`/learn/${id}`);
    }
});