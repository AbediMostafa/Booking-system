<template>
  <div
    :class="['fade-video-modal', showVideoModal ? 'visible-video-modal' : '']"
  >
    <img :src="iconPath" class="video-cancle-icon" @click="closeVideoModal" />
    <video :src="src" ref="landingVideo"></video>
  </div>
</template>

<script>
export default {
  props:['src'],
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
      this.$refs.landingVideo.play();
      this.showVideoModal = true;
    },

    /**
     * stop and close playing video
     */
    closeVideoModal() {
      this.showVideoModal = false;
      this.$refs.landingVideo.pause();
      this.$refs.landingVideo.currentTime = 0;
    },
  },
};
</script>