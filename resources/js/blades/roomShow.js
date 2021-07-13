import HeaderPart from '../components/packages/Header-part.vue';
import Scores from '../components/packages/Scores.vue';
import contactInfos from '../components/packages/Contact-infos.vue';
import DescriptionBox from '../components/packages/description-box.vue'
import VideoModal from '../components/packages/Video-modal.vue'
import PlayIcon from '../components/packages/Play-icon.vue'
import Comment from '../components/cards/Comment.vue';
import ModalComment from '../components/cards/Modal-comment.vue'
import CollectionRoom from '../components/cards/Collection-room.vue';
import NoEntity from '../components/packages/No-entity.vue';
import roomShowHeaderIcons from '../components/packages/Room-show-header-icons.vue';
import axios from 'axios';
import { sot } from '../sot';

const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        VideoModal,
        PlayIcon,
        Scores,
        contactInfos,
        DescriptionBox,
        Comment,
        ModalComment,
        CollectionRoom,
        NoEntity,
        roomShowHeaderIcons,
    },
    data: {
        room: {},
        comments: {},
        paginateInfos: {},
        headerInfos: {
            title: ''
        },
        displayModal: false,
        answers: {},
        currentComment: {},
        videoSrc: '',
        showVideo: false,
        enterAnimations: sot.enterAnimations,
    },
    computed: {
        collectionRooms() {
            return this.room && this.room.collection ? this.room.collection.rooms : []
        },
        background() {
            let banner = this.room.banner ? this.room.banner : '/storage/images/backgrounds/header-picture1.png'
            return `url('${banner}') no-repeat center/cover`;
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
            return `background: url(../${image}) no-repeat center/cover`;
        },
        commentClicked(comment) {
            let url = `/comments/${comment.id}/answers`;
            this.currentComment = comment;

            axios.post(url).then(response => {
                this.answers = response.data.data;
                this.displayModal = true;
            });
        }
    },
    created() {
        this.getRoom();
        this.getComments(`/rooms/${roomId}/comments`);
    }
});