require('./bootstrap');


import Vue from 'vue';
import Navbar from './components/landing/Navbar.vue';
import Carousel from './components/landing/Carousel.vue';
import SpecialRooms from './components/landing/Special-rooms.vue';
import ScrollAnimation from './directives/slow-move.js';
import FullVideo from './components/landing/Full-video.vue';
import Learning from './components/landing/Learning.vue';
import Collections from './components/landing/Collections.vue';
import SiteFooter from './components/landing/Site-footer.vue';
import VideoModal from './components/packages/Video-modal.vue';

Vue.directive('scrollAnimation', ScrollAnimation);

const vue = new Vue({
    el: '#app',
    components: {
        Navbar,
        Carousel,
        SpecialRooms,
        FullVideo,
        Learning,
        Collections,
        SiteFooter,
        VideoModal
    },
    data: {
        showVideo: false,
        videoSrc: '',

    },
    computed: {
        specialRoomBackground() {
            return this.background('x-rotated-back1.svg')
        },
        collectionBackground() {
            return this.background('rotated-back1.svg')

        },

    },

    methods: {
        background(icon) {
            return `background: url(${sot.imgPath(icon)}) no-repeat top center/contain;`
        },
        playVideo(videoPath) {

            console.log(videoPath);
            this.videoSrc = sot.videoPath(videoPath)
            this.showVideo = true;
            this.$refs.landingVideo.playVideo();
        }
    }
});