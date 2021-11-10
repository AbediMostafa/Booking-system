import HeaderPart from '../components/packages/Header-part.vue';
import VuePersianDatetimePicker from "vue-persian-datetime-picker";

const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        VuePersianDatetimePicker,
    },

    data: {
        headerInfos: {
            imageSrc: sot.absImgPath('carousel/2.jpg'),
            title: 'رزرو',
            text: `لطفا حتما ماسک به همراه خود داشته باشید.`
        },

        room: {
            customReserves: [],
            ordinaryReserves: [],
            hours: [],
            reservations: [],
            peopleCount: [],
        },

        postData: {
            day: '',
            hour: '',
            peopleCount: '',
        }
    },

    methods: {
        highlight() {

        },
        checkDate() {

        }
    },

    computed: {
        hourOptions() {
            return this.room.hours.map(hour => `${hour.start_time} - ${hour.end_time}`)
        }
    },

    created() {

    }
});
