<template>
  <article class="collection-card" v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation">
    <div class="sr-image-container sr-collection-image-container">
      <div :style="roomStyle" class="learning-card-image"></div>
    </div>

    <div class="sr-collection-text-container">
      <h1 class="collection-card-title">{{ collection.title }}</h1>
      <h4 class="collection-card-room-count">{{collection.roomCount}} اتاق فرار</h4>
      <read-more :txt="'لیست اتاق ها'" :additionalClass="'collection-rm-txt'" :position="'center'" class="mt-4"></read-more>
    </div>
  </article>
</template>

<script>
import ReadMore from "../packages/Read-more.vue";

export default {
  components: {
    ReadMore
  },
  data() {
    return {
         enterAnimations: sot.enterAnimations,
    };
  },
  props: ["collection"],
  computed: {
    roomStyle() {
      return `background: url('${this.collection.image}') no-repeat center center/cover;`;
    },
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