<template>
  <div class="full-video-container flex-center">
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
    };
  },
  methods: {
    playVideo() {
      this.$emit("play-video", "1.mp4");
    },
  },
  computed: {
    fullImagePath() {
      return sot.imgPath("raz.jpg");
    },
  },
};
</script>