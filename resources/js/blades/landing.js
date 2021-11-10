import Carousel from '../components/landing/Carousel.vue';
import SpecialRooms from '../components/landing/Special-rooms.vue';
import FullVideo from '../components/landing/Full-video.vue';
import Learning from '../components/landing/Learning.vue';
import Collections from '../components/landing/Collections.vue';
import Slider from '../components/landing/Slider.vue';
import VideoModal from '../components/packages/Video-modal.vue';
import Counts from '../components/landing/Counts.vue';
import LandingSearch from '../components/landing/Landing-search.vue';
import Multimedia from '../components/landing/Multimedia.vue';

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
        Slider,
        LandingSearch,
        Multimedia
    },
    data: {
        showVideo: false,
        allData: '',
        videoSrc: '',
    },

    methods: {
        background(icon, position, coverage = 'cover') {
            return `background: url(${sot.imgPath(icon)}) no-repeat ${position} center/${coverage};`
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
