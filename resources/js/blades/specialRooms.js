import SectionHeader from "../components/packages/Section-header.vue";
import RoomCard from "../components/cards/Room-card.vue";
import HeaderPart from '../components/packages/Header-part.vue';
import {Swiper, SwiperSlide} from 'vue-awesome-swiper';
import 'swiper/css/swiper.css';

const vue = new Vue({
    el: '#app',
    components: {
        SectionHeader,
        RoomCard,
        HeaderPart,
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            specialRoomData: {},
            specialTypes: {},
            rooms: [],
            hrStyle: "",
            selectedSpecialKey: 0,
            rotateDeg: 0,
            enterAnimations: sot.enterAnimations,
            headerInfos: {
                title: '',
                text: '',
                media: ''
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
        };
    },
    computed: {
        titles() {
            return {
                mainTitle: this.specialRoomData ? this.specialRoomData.title : "",
                icon: true,
                secondTitle: "",
                text: this.specialRoomData ? this.specialRoomData.text : "",
                specialTypes,
                paginations: []
            };
        },
    },
    methods: {

        getSpecialRooms() {
            axios.post('/site-vars/special-rooms').then(response => {
                this.specialRoomData = response.data.data;
                this.navigationProcess();
                this.headerInfos.title = 'اتاق های ویژه'
                this.headerInfos.text = response.data.data.text
            })
        },
        /**
         * get called when special room clicked
         */
        specialClicked(key) {
            // set current rooms
            this.getRooms(this.specialTypes[key].route);
            this.selectedSpecialKey = key;

            // set coordinate of navigation hr tag
            let el = this.$refs[key][0];
            this.setHrStyle(el);
        },

        /**
         * Set style of navigation HR
         */
        setHrStyle(el) {
            this.hrStyle = `
        width: ${el.getBoundingClientRect().width}px;
        left : ${el.offsetLeft}px;
        top: ${
                el.parentNode.offsetTop + el.parentNode.getBoundingClientRect().height-2
            }px
      `;
        },

        getRooms(route) {
            axios.post(route).then((response) => {
                this.rooms = response.data.data;
                this.paginations = response.data.meta.links;
            });
        },

        navigationProcess() {
            this.specialTypes = this.specialRoomData.nav;

            let specialTypeKeys = Object.keys(this.specialTypes),
                lastSpecialTypeKey = roomType ? roomType : specialTypeKeys[0],
                selectedSpecial = this.specialTypes[lastSpecialTypeKey];

            this.getRooms(selectedSpecial.route);

            setTimeout(() => {
                let el = this.$refs[lastSpecialTypeKey][0];
                this.selectedSpecialKey = lastSpecialTypeKey;
                this.setHrStyle(el);

            }, 500)
        }
    },


    mounted() {
        this.getSpecialRooms();
    }
});
