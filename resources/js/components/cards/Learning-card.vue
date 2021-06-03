<template>
  <article
    class="learning-card"
    v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation"
  >
    <div class="sr-image-container sr-learning-image-container">
      <div :style="roomStyle" class="learning-card-image"></div>
    </div>

    <div class="sr-text-container sr-learn-text-container">
      <h4>{{ card.date }}</h4>
      <h1>{{ card.title }}</h1>
      <p>{{ card.brief }}</p>
      <read-more :txt="'مطالعه بیشتر'"></read-more>
    </div>
  </article>
</template>

<script>
import ReadMore from "../packages/Read-more.vue";

export default {
  components: { ReadMore },
  data() {
    return {
      enterAnimations: sot.enterAnimations,
    };
  },
  props: ["card"],
  computed: {
    roomStyle() {
      return `background: url('${this.card.image}') no-repeat center center/cover;`;
    },
  },
};
</script>

<style scoped>
.sr-text-container h4 {
  font-size: 0.7rem;
}
.sr-text-container h1 {
  margin-bottom: 1rem;
  font-size: 1.3rem;
}
</style>