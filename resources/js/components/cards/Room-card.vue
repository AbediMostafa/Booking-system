<template>
  <article class="special-room-card" v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation">
    <div class="sr-image-container" :style="roomStyle"></div>

    <div class="sr-text-container">
      <h1>{{ room.name }}</h1>
      <h4>{{room.collectionName}}  ({{room.collectionAddress}})</h4>
      <p></p>
      <score-stars :score="room.totalScore"></score-stars>
      <a class="second-cta cta">اطلاعات بیشتر</a>
    </div>
  </article>
</template>

<script>
import ScoreStars from "../packages/Score-stars.vue";
export default {
  components: {
    ScoreStars,
  },
  data() {
    return {
         enterAnimations: sot.enterAnimations,
    };
  },
  props: ["room"],
  computed: {
    roomStyle() {
      return `background: url('${this.room.image}') no-repeat center center/cover;`;
    },
  },
};
</script>