import HeaderPart from '../components/packages/Header-part.vue';
import Scores from '../components/packages/Scores.vue';
import ScoreStars from '../components/packages/Score-stars.vue';
import contactInfos from '../components/packages/Contact-infos.vue';
import VideoModal from '../components/packages/Video-modal.vue'
import PlayIcon from '../components/packages/Play-icon.vue'
import Comment from '../components/cards/Comment.vue';
import ModalComment from '../components/cards/Modal-comment.vue'
import CollectionRoom from '../components/cards/Collection-room.vue';
import NoEntity from '../components/packages/No-entity.vue';
import roomShowHeaderIcons from '../components/packages/Room-show-header-icons.vue';
import DescriptionBox from "../components/packages/description-box.vue";

import axios from 'axios';
import {sot} from '../sot';

const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        VideoModal,
        PlayIcon,
        Scores,
        contactInfos,
        Comment,
        ModalComment,
        CollectionRoom,
        NoEntity,
        roomShowHeaderIcons,
        ScoreStars,
        DescriptionBox
    },
    data: {
        room: {},
        comments: {},
        paginateInfos: {},
        headerInfos: {
            title: ''
        },
        displayModal: false,
        currentComment: {},
        videoSrc: '',
        showVideo: false,
        enterAnimations: sot.enterAnimations,
    },
    computed: {

        ratingIcon() {
            return `/images/icons/${this.room.rates ? this.room.rates.rateName : ''}.svg`;
        },
        collectionRooms() {
            return this.room && this.room.collection ? this.room.collection.rooms : []
        },
        background() {
            let banner = this.room.banner ? this.room.banner : ''
            return `url('${banner}') no-repeat center/cover`;
        },
        collectionImg() {
            return this.room.collection ? this.room.collection.image : ''
        }
    },
    methods: {
        reserveRoom() {
            location.href = `/checkout/${roomId}`;
        },
        sendComment() {
            axios.post('/auth-check').then(response => {
                location.href = response.data ? `/insert-comment/${this.room.id}` : `/phone-check/${this.room.id}`;
            });
        },
        getRoom() {
            axios.post(`/rooms/${roomId}`).then((response) => {
                this.room = response.data.data;
                this.headerInfos.title = response.data.data.name;
            });
        },
        playVideo() {
            this.videoSrc = this.room.teaser;
            this.showVideo = true;
            this.$refs.landingVideo.playVideo();
        },

        getComments(url) {
            axios.post(url).then((response) => {
                this.comments = response.data.data;
                this.paginateInfos = response.data.links;
            });
        },

        iconPath(icon) {
            return sot.iconPath(icon);
        },

        imageAsBackground(image) {
            let img = image ? image : sot.noImage;

            return `background: url(..${img}) no-repeat center/cover`;
        },
        commentClicked(comment) {
            this.currentComment = comment;
            this.displayModal = true;
        },

        closeModal(){
            this.displayModal = false;
        },

        paymentCallbackProcess() {
            Swal.fire({
                title: reserveStatus == 1 ? 'success' : 'error',
                text: msg,
                icon: reserveStatus == 1 ? 'success' : 'error',
                confirmButtonText: "Ok",
            });
        }
    },
    created() {

        if (paymentCallback) {
            this.paymentCallbackProcess()
        }

        this.getRoom();
        this.getComments(`/rooms/${roomId}/comments`);

    }
});
