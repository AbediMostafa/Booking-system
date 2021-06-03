<template>
  <div class="learning-container">
    <div class="header-and-cta">
      <section-header
        :titles="titles"
        v-scrollAnimation="enterAnimations.topAnimation"
      ></section-header>

      <div class="text-right">
        <a class="cta main-cta learning-cta">همه آموزش ها</a>
      </div>
    </div>
    <div class="learning-card-container">
      <learning-card
        v-for="learning in learnings"
        :key="learning.id"
        :card="learning"
      ></learning-card>
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
        mainTitle: "آموزش با",
        icon: true,
        secondTitle: "",
        text: `
        بعضی وقت ها توی بعضی از اتاق ها به مواردی برمیخوری که نیاز به اطلاعات قبلی داره. اطلاعاتی را جع به اتاق ها و انواع کلیدها.
        ما توی این بخش یه سری آموزش ها رو به شما میدیم که بیشتر از اتاق ها لذت ببرید.
        `,
      },
    };
  },
  created() {
    this.learnings = sot.learnings;
  },
};
</script>

<style scoped>
.learning-cta {
  margin-right: 1.5rem;
}
</style>