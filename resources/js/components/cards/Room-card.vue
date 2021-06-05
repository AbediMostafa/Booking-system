<template>
  <article class="special-room-card learning-card" v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation">
    <div class="sr-image-container sr-learning-image-container">
      <div :style="roomStyle" class="learning-card-image"></div>
    </div>

    <div class="sr-text-container">
      <h1>{{ room.name }}</h1>
      <h4>{{room.collectionName}}  ({{room.collectionAddress}})</h4>
      <p></p>
      <score-stars :score="room.totalScore"></score-stars>
      <read-more :txt="'اطلاعات بیشتر'"></read-more>

    </div>
  </article>
</template>

<script>
import ScoreStars from "../packages/Score-stars.vue";
import ReadMore from "../packages/Read-more.vue";

export default {
  components: {
    ScoreStars,
    ReadMore
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