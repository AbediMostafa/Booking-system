<template>
  <div>
    <section-header
      :titles="titles"
      v-scrollAnimation="enterAnimations.topAnimation"
    ></section-header>

    <div class="learning-card-container">
      <learning-card
        v-for="learning in learnings"
        :key="learning.id"
        :card="learning"
      ></learning-card>
    </div>

    <div class="text-right">
      <a class="cta mt-12 main-cta learning-cta">همه آموزش ها</a>
    </div>

  </div>
</template>

<script>
import SectionHeader from "../packages/Section-header.vue";
import LearningCard from "../cards/Learning-card.vue";
export default {
  components: {
    SectionHeader,
    LearningCard,
  },
  data() {
    return {
      enterAnimations: sot.enterAnimations,
      learnings: [],
      titles: {
        mainTitle: "آموزش ها",
        icon: false,
        secondTitle: "",
        text: "",
        headerStyle: 'margin-right:3rem'
      },
    };
  },
  created() {
    this.learnings = sot.learnings;
  },
};
</script>

<style scoped>
.learning-cta{
  margin-right: 3rem;
}
</style>