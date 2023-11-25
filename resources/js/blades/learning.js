import HeaderPart from '../components/packages/Header-part.vue';
import ComplicatedRoomCard from '../components/cards/Complicated-room-card.vue';
import axios from 'axios';
import { sot } from '../sot';
import VideoModal from "../components/packages/Video-modal";
import PlayIcon from "../components/packages/Play-icon";

const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        ComplicatedRoomCard,
        VideoModal,
        PlayIcon,
    },

    data: {
        background: "url('../images/backgrounds/header-picture1.png') no-repeat center/cover",
        videoSrc:'',

        headerInfos: {
            imageSrc: sot.absImgPath('carousel/1.jpg'),
        },

        post: {},
        specialRooms: {},
        tags:[],
    },

    methods: {
        getPost(url) {
            axios.post(url).then(response => {
                this.post = response.data.data.post;
                this.specialRooms = response.data.data.special_rooms;
                this.tags = response.data.data.tags;
                this.headerInfos.title = this.post.title;
            });
        },
        iconPath(icon) {
            return sot.iconPath(icon)
        },
        playVideo() {
            this.videoSrc = this.post.video;
            this.showVideo = true;
            this.$refs.video.playVideo();
        },
    },

    created() {
        this.getPost(`/learn/${id}`);
    }
});
