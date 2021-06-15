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
            imageSrc: sot.absImgPath('carousel/1.jpg'),
            title: '',
            text: ` 
            همه اتاق های فرار بر اساس فیلترهایی تقسیم بندی شده اند. با استفاده از این فیلترها می توانید اتاق مورد نظر خود را پیدا کنید که در شهر خاص، مجموعه خاص و یا ژانر خاص وجود دارند
            `
        },
    },
    computed: {
        city() {
            return this.search.city ? `شهر ${this.search.city}` : '';
        },
        genre() {
            return this.search.genre ? `در ژانر ${this.search.genre}` : '';
        },
        collection() {
            return this.search.collection ? `در مجموعه ${this.search.collection}` : '';
        },
        personCount() {
            return this.search.collection ? `${this.search.personCount} نفره` : '';
        },

        getTitle() {
            return `
                اتاق های فرار
                ${this.city}
                ${this.genre}
                ${this.collection}
                ${this.personCount}
            `;
        }
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
                console.log(this.rooms);
            });
        }
    },

    created() {
        this.headerInfos.title = this.getTitle;
        this.callComplicatedRoom()
    }
});