<template>
  <a
    class="collection-card"
    v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation"
    :href="getCollectionPath"
    >
    <div class="sr-image-container sr-collection-image-container">
      <div :style="roomStyle" class="learning-card-image"></div>
    </div>

    <div class="sr-collection-text-container">
      <h1 class="collection-card-title">{{ collection.title }}</h1>
      <read-more-text
        :additionalClass="'collection-rm-txt'"
        :position="'center'"
        class="mt-4">
      </read-more-text>
    </div>
  </a>
</template>

<script>
import ReadMoreText from "../packages/Read-more-text.vue";

export default {
  components: {
    ReadMoreText
  },
  data() {
    return {
         enterAnimations: sot.enterAnimations,
    };
  },
  props: ["collection"],
  computed: {
    roomStyle() {
       let img = this.collection.image ? this.collection.image : sot.noImage;

      return `background: url('${img}') no-repeat center center/cover;`;
    },
    getCollectionPath(){
      return sot.complicatedPath('collection',this.collection.title);
    }
  },
};
</script>

<style scoped>
.mt-4{
    margin-top: 1rem;
}

.city-card-title{
    font-size: 1.4rem;
}

.city-card-room-count{
    direction:rtl
}

.sr-collection-image-container{
    width:5rem;
    height: 5rem;
    overflow: hidden;
    border-radius: 50%;
}
</style>
