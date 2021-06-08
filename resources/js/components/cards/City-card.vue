<template>
  <article class="special-room-card learning-card" v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation">
    <div class="sr-image-container sr-learning-image-container">
      <div :style="roomStyle" class="learning-card-image"></div>
    </div>

    <div class="sr-text-container">
      <h1 class="city-card-title">{{ city.name }}</h1>
      <h4 class="city-card-room-count">{{city.roomCount}} اتاق فرار</h4>
      <read-more :txt="'لیست اتاق ها'" class="mt-4"></read-more>
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
  props: ["city"],
  computed: {
    roomStyle() {
      return `background: url('${this.city.image}') no-repeat center center/cover;`;
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
</style>