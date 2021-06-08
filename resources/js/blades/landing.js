import Carousel from '../components/landing/Carousel.vue';
import SpecialRooms from '../components/landing/Special-rooms.vue';
import FullVideo from '../components/landing/Full-video.vue';
import Learning from '../components/landing/Learning.vue';
import Collections from '../components/landing/Collections.vue';
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
        Counts
    },
    data: {
        showVideo: false,
        videoSrc: '',
    },

    methods: {
        background(icon, position) {
            return `background: url(${sot.imgPath(icon)}) no-repeat ${position} center/contain;`
        },
        playVideo(videoPath) {
            this.videoSrc = sot.videoPath(videoPath)
            this.showVideo = true;
            this.$refs.landingVideo.playVideo();
        }
    }
});