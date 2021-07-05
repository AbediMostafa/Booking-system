<template>
  <div class="full-video-container flex-center" :style="back">
    <play-icon
      v-scrollAnimation="enterAnimations.topAnimation"
      size="large"
      @click.native="playVideo"
    >
    </play-icon>
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
      back:''
    };
  },
  methods: {
    playVideo() {
      axios
        .post("/specific-medias/first-page-medias", {
          type: "first_page_full_video",
        })
        .then((response) => {
          this.$emit("play-video", response.data);
        });
    },
  },
  created() {
    axios
      .post("/specific-medias/first-page-medias", {
        type: "first_page_full_image",
      })
      .then((response) => {
        this.back = `background: url(${response.data}) no-repeat fixed center center/cover;`;
      });
  },
};
</script>