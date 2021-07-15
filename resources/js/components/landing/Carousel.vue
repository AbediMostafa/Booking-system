<template>
  <div class="carousel">
    <div class="overlay"></div>

    <img
      :src="
        carouselImageSources.length ? carouselImageSources[counter].path : ''
      "
      :class="['carousel-img', zoom ? 'zoom-in' : 'zoom-out']"
    />
    <div class="image-content">
      <h1
        v-scrollAnimation="enterAnimations.topAnimation"
        class="ic-main-title"
      >
        {{
          carouselImageSources.length ? carouselImageSources[counter].text : ""
        }}
      </h1>
      <p
        v-scrollAnimation="enterAnimations.topWithDelayAnimation"
        class="ic-text-part"
      >
        {{
          carouselImageSources.length
            ? carouselImageSources[counter].paragraph
            : ""
        }}
      </p>
      <div class="cta-container">
        <play-icon
          v-scrollAnimation="enterAnimations.leftWithUltraDelayAnimation"
          size="small"
          @click.native="playVideo"
        >
        </play-icon>
        <a
          class="cta main-cta"
          v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation"
          href="/genres"
          >{{ carouselData ? carouselData.buttonText : "" }}</a
        >
      </div>
    </div>
  </div>
</template>

<script>
import PlayIcon from "./../packages/Play-icon.vue";
export default {
  props: ["carouselData"],
  components: {
    PlayIcon,
  },
  data() {
    return {
      enterAnimations: sot.enterAnimations,
      counter: 0,
      zoom: false,
      carouselImageSources: [],
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

    /**
     * changes zoom to true after 20ms
     */
    addBreak() {
      setTimeout(() => {
        this.zoom = true;
      }, 20);
    },
  },

  watch: {
    carouselData() {
      this.carouselImageSources = this.carouselData.carouselItems;
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
  },

  mounted() {},
};
</script>

<style scoped>
.zoom-in {
  transition: all 10s;
  transform: scale(1.4) !important;
}

.zoom-out {
  transition: all 0s;
  transform: scale(1);
}

.cta-container {
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
</style>