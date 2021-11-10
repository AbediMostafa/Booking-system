<template>
  <div class="learning-container">
    <div class="header-and-cta">
      <section-header
        :titles="titles"
        v-scrollAnimation="enterAnimations.topAnimation"
      ></section-header>

      <div class="text-right">
        <a class="cta main-cta learning-cta" href="/learn">{{learningData?learningData.button:''}}</a>
      </div>
    </div>
    <div class="learning-card-container">
      <learning-card
        v-for="learning in learnings"
        :key="learning.id"
        :card="learning"
        uri="learn"
      ></learning-card>
    </div>
  </div>
</template>

<script>
import SectionHeader from "../packages/Section-header.vue";
import LearningCard from "../cards/Learning-card.vue";
export default {
  props:['learningData'],
  components: {
    SectionHeader,
    LearningCard,
  },
  data() {
    return {
      enterAnimations: sot.enterAnimations,
      learnings: [],
    };
  },

  computed:{
    titles(){
      return {
        mainTitle: this.learningData?this.learningData.title:'',
        icon: true,
        secondTitle: "",
        text: this.learningData?this.learningData.text:''
      };
    }
  },
  methods: {
    getStarredPosts() {
      axios.post("/posts/starred").then((response) => {
        this.learnings = response.data.data;
      });
    },
  },
  created() {
    this.getStarredPosts();
  },
};
</script>

<style scoped>
.learning-cta {
  margin-right: 1.5rem;
}
</style>
