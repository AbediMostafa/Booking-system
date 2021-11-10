<template>
  <a
    :href="`/${uri}/${card.id}`"
    class="learning-card"
    v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation"
  >
    <div class="sr-image-container sr-learning-image-container">
      <div :style="roomStyle" class="learning-card-image"></div>
    </div>

    <div class="sr-text-container sr-learn-text-container">
      <h4>{{ card.date }}</h4>
      <h1>{{ card.title }}</h1>
      <p>{{ chupedBrief }}</p>
      <read-more :txt="'مطالعه بیشتر'"></read-more>
    </div>
  </a>
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
  props: ["card", "uri"],
  computed: {
    roomStyle() {
       let img = this.card.image ? this.card.image : sot.noImage;
      return `background: url('${img}') no-repeat center center/cover;`;
    },
      chupedBrief(){
        let brief = this.card.brief;
        return brief.length>200 ? brief.substr(0,200)+ ' ... ' : brief;
      }
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
