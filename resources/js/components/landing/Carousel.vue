<template>
  <div class="carousel">
    <img
      :src="carouselImageSources[counter].path"
      :class="['carousel-img', zoom ? 'zoom-in' : 'zoom-out']"
    />
    <div class="image-content">
      <h1 v-scrollAnimation="enterAnimations.topAnimation">
        {{ carouselImageSources[counter].text }}
      </h1>
      <p v-scrollAnimation="enterAnimations.topWithDelayAnimation">
        {{ carouselImageSources[counter].paragraph }}
      </p>
      <div class="cta-container">
        <play-icon 
          v-scrollAnimation="enterAnimations.leftWithUltraDelayAnimation"
          size="small"
          >
        </play-icon>
        <a
          class="cta"
          v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation"
          >شروع ماجراجویی</a
        >
      </div>
    </div>
  </div>
</template>

<script>
import PlayIcon from "../packages/Play-icon.vue";
export default {
  components: {
    PlayIcon,
  },
  data() {
    return {
      enterAnimations: sot.enterAnimations,
      counter: 0,
      zoom: false,
      carouselImageSources: sot.carouselItems,
    };
  },
  methods: {
    /**
     * changes zoom to true after 20ms
     */
    addBreak() {
      setTimeout(() => {
        this.zoom = true;
      }, 20);
    },
  },

  mounted() {
    this.addBreak();

    setInterval(() => {
      this.zoom = false;
      this.addBreak();
      this.counter++;

      if (this.carouselImageSources.length === this.counter) {
        this.counter = 0;
      }
    }, 10000);
  },
};
</script>

<style scoped>
.carousel {
  position: relative;
  margin-top: 1rem;
  overflow: hidden;
  height: 25rem;
}

.zoom-in {
  transition: all 10s;
  transform: scale(1.4) !important;
}

.zoom-out {
  transition: all 0s;
  transform: scale(1);
}
.image-content {
  position: absolute;
  top: 0;
  right: 5%;
  color: white;
  text-align: right;
  width: 80%;
}

.image-content h1 {
  margin-bottom: 0;
  text-shadow: 1px 1px 8px rgba(0, 0, 0, 1);
  font-size: 2rem;
}
.image-content p {
  font-size: 0.8rem;
  text-shadow: 1px 1px 8px rgba(0, 0, 0, 1);
  line-height: 2;
}

.carousel-img {
  height: 100%;
  width: auto;
}

.cta-container {
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
</style>