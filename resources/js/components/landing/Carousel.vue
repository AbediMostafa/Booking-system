<template>
    <!--    <div class="carousel">-->
    <swiper
        class="pt-0 swiper-autoplay"
        :options="swiperOptions"
    >
        <swiper-slide
            v-for="(data, key) in carouselItems"
            :key="key"
        >
            <a :href="`/rooms/${data.roomId}`" target="_blank">
                <img :src="data.media" class="carousel-img"/>
            </a>

            <div class="count-container">
                <div class="count-parts">
                    <a class="count-text-part" href="/cities" target="_blank">
                        <span>+{{ countData ? countData.city : '' }}</span>
                    </a>
                    <img src="/images/icons/white-city.svg" class="white-icons"/>
                </div>
                <div class="count-parts">
                    <a class="count-text-part" href="/collections" target="_blank">
                        <span>+{{ countData ? countData.collection : '' }}</span>
                    </a>
                    <img src="/images/icons/white-collection.svg" class="white-icons"/>
                </div>
                <div class="count-parts">
                    <a class="count-text-part" href="/rooms" target="_blank">
                        <span>+{{ countData ? countData.room : '' }}</span>
                    </a>
                    <img src="/images/icons/white-escape.svg" class="white-icons"/>
                </div>
            </div>

        </swiper-slide>
        <div
            slot="button-next"
            class="swiper-button-next"
        />
        <div
            slot="button-prev"
            class="swiper-button-prev"
        />
    </swiper>
</template>
<script>
import PlayIcon from "./../packages/Play-icon.vue";
import {Swiper, SwiperSlide} from 'vue-awesome-swiper';
import 'swiper/css/swiper.css';

export default {
    props: ["carouselData", "countData"],
    components: {
        Swiper,
        SwiperSlide,
        PlayIcon,
    },
    data() {
        return {
            enterAnimations: sot.enterAnimations,
            counter: 0,
            zoom: false,
            carouselImageSources: [],
            swiperOptions: {
                effect: 'cube',
                cubeEffect: {
                    shadow: false,
                    slideShadows: false,
                },
                // spaceBetween: 30,
                // centeredSlides: true,
                autoplay: {
                    delay: 4500,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            },
        };
    },
    methods: {
        playVideo() {
            axios
                .post("/specific-medias/first-page-medias", {
                    type: "first_page_video",
                })
                .then((response) => {
                    this.$emit("play-video", response.data);
                });
        },
    },

    computed: {
        carouselItems() {
            return this.carouselData ? this.carouselData : [];
        }
    },
};
</script>
