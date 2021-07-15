import Carousel from '../components/landing/Carousel.vue';
import SpecialRooms from '../components/landing/Special-rooms.vue';
import FullVideo from '../components/landing/Full-video.vue';
import Learning from '../components/landing/Learning.vue';
import Collections from '../components/landing/Collections.vue';
import Slider from '../components/landing/Slider.vue';
import VideoModal from '../components/packages/Video-modal.vue';
import Counts from '../components/landing/Counts.vue';

const vue = new Vue({
    el: '#app',
    components: {
        Carousel,
        SpecialRooms,
        FullVideo,
        Learning,
        Collections,
        VideoModal,
        Counts,
        Slider
    },
    data: {
        showVideo: false,
        allData: '',
        videoSrc: '',
    },

    methods: {
        background(icon, position) {
            return `background: url(${sot.imgPath(icon)}) no-repeat ${position} center/contain;`
        },
        playVideo(videoPath) {
            this.videoSrc = videoPath
            this.showVideo = true;
            this.$refs.landingVideo.playVideo();
        }
    },
    created() {
        axios.post('site-vars/first-page').then(response => {
            this.allData = response.data.data;
        });
    },
});