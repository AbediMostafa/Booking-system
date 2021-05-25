<template>
  <div class="full-video-container flex-center">
     <play-icon 
          v-scrollAnimation="enterAnimations.topAnimation"
          size="large"
     >
        </play-icon>
  </div>
</template>
<script>
import PlayIcon from '../packages/Play-icon.vue';
export default {
  components:{
    PlayIcon,
  },
  data() {
    return {
      enterAnimations: sot.enterAnimations,
    };
  },
  computed: {
    fullImagePath() {
      return sot.imgPath("raz.jpg");
    },
  },
};
</script>