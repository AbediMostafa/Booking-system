import HeaderPart from '../components/packages/Header-part.vue';
import RoomFilter from '../components/packages/Room-filter.vue';
import ComplicatedRoomCard from '../components/cards/Complicated-room-card.vue';
import axios from 'axios';

const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        RoomFilter,
        ComplicatedRoomCard
    },

    data: {
        search: sot.reactiveVars.roomSearch,
        roomKey: '',
        rooms: [],
        tmpRooms: [],
        totalData: {},
        headerInfos: {
            title: '',
            text: '',
            media: ''
        },
    },
    computed: {
        background() {
            return `url('..${this.headerInfos.media}') no-repeat center center /cover`;
        },
    },
    methods: {
        roomSearch(searchKey) {
            this.tmpRooms = this.rooms.filter(tmpRoom => {
                return tmpRoom.name.toLowerCase().includes(searchKey.toLowerCase());
            });
        },
        filterChanged(filter) {
            this.callComplicatedRoom(filter)
        },

        callComplicatedRoom(data = {}) {
            axios.post('rooms/complicated-search', data).then((response) => {
                this.totalData = response.data;
                this.rooms = this.tmpRooms = response.data.rooms;
            console.log('get rooms ', response.data.rooms);
            });
        },
        getVars() {
            axios.post('/site-vars/genres-page').then(response => {
                this.headerInfos = response.data;
            });
        }
    },

    mounted() {
        this.getVars();
        if(collectionTitle){
            this.$refs.filter.collectionClicked(collectionTitle);
            return;
        }

        if(cityTitle){
            this.$refs.filter.cityClicked(cityTitle);
            return;
        }

        this.callComplicatedRoom();
    }
});
