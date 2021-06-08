<template>
  <div
    :class="['fade-video-modal', showVideoModal ? 'visible-video-modal' : '']"
  >
    <img :src="iconPath" class="video-cancle-icon" @click="closeVideoModal" />
    <video :src="src" ref="vid"></video>
  </div>
</template>

<script>
export default {
  props: ["src"],
  data() {
    return {
      iconPath: sot.iconPath("gradiant-cancle.svg"),
      showVideoModal: false,
    };
  },
  methods: {
    /**
     * play landing's video modal
     */
    playVideo() {

      setTimeout(() => {
        this.$refs.vid.play();
      }, 200);
      this.showVideoModal = true;
    },

    /**
     * stop and close playing video
     */
    closeVideoModal() {
      this.showVideoModal = false;
      this.$refs.vid.pause();
      this.$refs.vid.currentTime = 0;
    },
  },
};
</script>