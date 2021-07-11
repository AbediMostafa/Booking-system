<template>
  <div>
    <VueSlickCarousel v-bind="config" v-if="medias.length">
      <div v-for="(media, key) in medias" :key="key" class="pr-4">
        <img :src="media" class="slider-img">
      </div>
    </VueSlickCarousel>
  </div>
</template>

<script>
import VueSlickCarousel from "vue-slick-carousel";
import "vue-slick-carousel/dist/vue-slick-carousel.css";
// optional style for arrows & dots
import "vue-slick-carousel/dist/vue-slick-carousel-theme.css";
export default {
  components: { VueSlickCarousel },
  data() {
    return {
      config: {
        dots: true,
        arrows:true,
        infinite: true,
        speed: 400,
        slidesToShow: 2,
        slidesToScroll: 2,
        autoplay:true,
      },
      medias: [],
    };
  },
  methods: {
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
.slider-img{
    margin: 0 auto;
    width:100%;
    height: auto;
}
</style>