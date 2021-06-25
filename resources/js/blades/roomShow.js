import HeaderPart from '../components/packages/Header-part.vue';
import Scores from '../components/packages/Scores.vue';
import contactInfos from '../components/packages/Contact-infos.vue';
import DescriptionBox from '../components/packages/description-box.vue'
import Comment from '../components/cards/Comment.vue';
import ModalComment from '../components/cards/Modal-comment.vue'
import CollectionRoom from '../components/cards/Collection-room.vue';
import NoEntity from '../components/packages/No-entity.vue';
import roomShowHeaderIcons from '../components/packages/Room-show-header-icons.vue';
import { VueEditor } from 'vue2-editor';
import axios from 'axios';
import { sot } from '../sot';

const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        Scores,
        contactInfos,
        DescriptionBox,
        Comment,
        ModalComment,
        CollectionRoom,
        NoEntity,
        roomShowHeaderIcons,
        VueEditor,
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

    },
    computed: {

        collectionRooms() {
            return this.room && this.room.collection ? this.room.collection.rooms : []
        },
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
            let url = `/${sot.exactPath}comments/${comment.id}/answers`;
            this.currentComment = comment;

            axios.post(url).then(response => {
                this.answers = response.data.data;
                this.displayModal = true;
            });
        }
    },
    created() {
        this.getRoom();
        this.getComments(`/${sot.exactPath}rooms/${roomId}/comments`);
    }
});