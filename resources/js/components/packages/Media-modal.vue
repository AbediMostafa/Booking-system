<template>
  <div :class="['fade-video-modal', mediaObj.show ? 'visible-video-modal' : '']">
    <img :src="iconPath" class="video-cancle-icon" @click="mediaObj.show = false" />
    <div class="d-cards-container d-modal-card-container">
      <dashboard-media-card
        v-for="(media, key) in medias"
        :key="key"
        :card="media"
        @click.native="cardClicked(media)"
      ></dashboard-media-card>
      <h1 ></h1>
    </div>
  </div>
</template>

<script>

import dashboardMediaCard from '../cards/Dashboard-media-card.vue';
export default {
    components:{
        dashboardMediaCard
    },
  props: ["mediaObj"],
  data() {
    return {
      iconPath: sot.iconPath("gradiant-cancle.svg"),
      medias: [],
    };
  },
  watch:{
    'mediaObj.show'(){
      this.getMedias();
    }
  },
  methods: {
    cardClicked(media) {
        this.$emit('modalMediaClicked', media)
    },
    getMedias() {
      axios.post("/admin/media/modal", {type:this.mediaObj.type}).then((response) => {
        this.medias = response.data;
      });
    },
  },
};
</script>

<style scoped>
.d-modal-card-container{
    width: 80vw;
    height: 80vh;
    background: white;
    overflow: auto;
    border-radius: .5rem;
}
</style>