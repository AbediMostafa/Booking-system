import HeaderPart from '../components/packages/Header-part.vue';
import axios from 'axios';
import { sot } from '../sot';
import VideoModal from "../components/packages/Video-modal";
import PlayIcon from "../components/packages/Play-icon";

const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        VideoModal,
        PlayIcon,
    },

    data: {
        background: "url('../images/backgrounds/header-picture1.png') no-repeat center/cover",
        videoSrc:'',

        headerInfos: {
            imageSrc: sot.absImgPath('carousel/1.jpg'),
            title: '',
        },

        movie: {},
    },

    methods: {
        getMovie(url) {
            let data = {
                method:'siteGet',
                id
            }
            axios.post('/movies', data).then(response => {
                this.movie = response.data.data;
                this.headerInfos.title = this.movie.title;
            });
        },
        iconPath(icon) {
            return sot.iconPath(icon)
        },
        playVideo() {
            this.videoSrc = this.movie.video;
            this.showVideo = true;
            this.$refs.video.playVideo();
        },
    },

    created() {
        this.getMovie();
    }
});
