<template>
    <div>
        <div class="header-section" :style="titles.headerStyle">
            <div class="title-icon justify-center">
                <img src="/images/icons/logo.svg" alt="icon" />
                <h1>{{ titles.mainTitle }}</h1>
            </div>

            <p class="text-center header-text" v-if="titles.text">{{ titles.text }}</p>
        </div>

        <VueSlickCarousel v-bind="config" v-if="medias.length">
            <a v-for="(media, key) in medias" :key="key" :href="getRoomPath(media)">
                <div class="pr-4">
                    <img :src="media.media" class="slider-img">
                </div>
            </a>
        </VueSlickCarousel>
    </div>
</template>

<script>
import sectionHeader from '../packages/Section-header'
import VueSlickCarousel from "vue-slick-carousel";
import "vue-slick-carousel/dist/vue-slick-carousel.css";
import "vue-slick-carousel/dist/vue-slick-carousel-theme.css";

export default {
    components: {VueSlickCarousel, sectionHeader},
    data() {
        return {
            config: {
                dots: true,
                infinite: true,
                speed: 400,
                slidesToShow: 2,
                slidesToScroll: 2,
                autoplay: true,
                arrows: false,
            },
            enterAnimations: sot.enterAnimations,
            medias: [],
            titles: {
                mainTitle: '',
                icon: true,
                secondTitle: "",
                text: '',
            }
        };
    },
    methods: {
        getRoomPath(media) {
            return media.roomId ? `rooms/${media.roomId}` : '#'
        },
        getMedias() {
            axios.post("/specific-medias/get-carousel-medias").then((response) => {
                this.medias = response.data.medias;
                this.titles.mainTitle = response.data.title;
                this.titles.text = response.data.text;
            });
        },
    },
    created() {
        this.getMedias();
    },
};
</script>

<style scoped>
.slider-img {
    margin: 0 auto;
    width: 100%;
    height: auto;
    border-radius: 1rem;
}
</style>
