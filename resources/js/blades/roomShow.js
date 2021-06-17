import HeaderPart from '../components/packages/Header-part.vue';
import axios from 'axios';

const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
    },
    data: {
        room: {},
        headerInfos: {
            title: ''
        },
    },
    methods: {
        getRoom() {
            axios.post(`/${sot.exactPath}rooms/${roomId}`).then((response) => {
                this.room = response.data.data;
                this.headerInfos.title = response.data.data.name;
            });
        }
    },

    created() {
        this.getRoom()
    }
});