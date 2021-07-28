<template>
    <div>
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
import VueSlickCarousel from "vue-slick-carousel";
import "vue-slick-carousel/dist/vue-slick-carousel.css";
import "vue-slick-carousel/dist/vue-slick-carousel-theme.css";

export default {
    components: {VueSlickCarousel},
    data() {
        return {
            config: {
                dots: true,
                arrows: true,
                infinite: true,
                speed: 400,
                slidesToShow: 2,
                slidesToScroll: 2,
                autoplay: true,
            },
            medias: [],
        };
    },
    methods: {
        getRoomPath(media) {
            return media.roomId ? `rooms/${media.roomId}` : '#'
        },
        getMedias() {
            axios.post("/specific-medias/get-carousel-medias").then((response) => {
                this.medias = response.data;
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
}
</style>
