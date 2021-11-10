import HeaderPart from '../components/packages/Header-part.vue';
import RoomFilter from '../components/packages/Room-filter.vue';
import ComplicatedRoomCard from '../components/cards/Complicated-room-card.vue';
import {Swiper, SwiperSlide} from 'vue-awesome-swiper';
import axios from 'axios';
import 'swiper/css/swiper.css';

const vue = new Vue({
    el: '#app',
    components: {
        Swiper,
        SwiperSlide,
        HeaderPart,
        RoomFilter,
        ComplicatedRoomCard
    },

    data: {
        firstInterSection: true,
        search: sot.reactiveVars.roomSearch,
        roomKey: '',
        rooms: [],
        tmpRooms: [],
        totalData: {},
        paginations: {},
        headerInfos: {
            title: '',
            text: '',
            media: ''
        },
        selectedFilters: {
            personCount: "",
            genres: "",
            collections: "",
            cities: "",
            searchKey: ''
        },
        swiperOptions: {
            spaceBetween: 30,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            loop: true,
            breakpoints: {
                1080: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                568: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                260: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },

            },
        },
    },
    computed: {
        background() {
            return `url('..${this.headerInfos.media}') no-repeat center center /cover`;
        },
    },
    methods: {
        filterChanged(filter) {
            this.selectedFilters = filter;
            this.callComplicatedRoom()
        },

        callComplicatedRoom() {
            axios.post('rooms/complicated-search', this.selectedFilters).then((response) => {
                this.totalData = response.data;
            });
            this.getComplicatedRooms('/rooms/complicated-rooms');
        },
        goToRoomPage(url) {
            window.scrollTo(0, 0);
            this.getComplicatedRooms(url);
        },

        getComplicatedRooms(url) {
            axios.post(url, this.selectedFilters).then((response) => {
                this.rooms = this.tmpRooms = response.data.data;
                this.paginations = response.data.meta.links;
            });
        },

        getVars() {
            axios.post('/site-vars/genres-page').then(response => {
                this.headerInfos = response.data;
                this.headerInfos.title = collectionTitle ?
                    collectionTitle :
                    (cityTitle ? cityTitle : this.headerInfos.title)
            });
        }
    },

    mounted() {
        this.getVars();
        if (collectionTitle) {
            this.$refs.filter.collectionClicked(collectionTitle);
            return;
        }

        if (cityTitle) {
            this.$refs.filter.cityClicked(cityTitle);
            return;
        }

        this.callComplicatedRoom();
    },
});
