<template>
  <article class="special-room-card learning-card" v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation">
    <div class="sr-image-container sr-learning-image-container" :style="roomStyle"></div>

    <div class="sr-text-container">
      <h4>{{card.date}}</h4>
      <h1>{{ card.title }}</h1>
      <p>{{card.brief}}</p>
      <a class="second-cta cta">مطالعه بیشتر</a>
    </div>
  </article>
</template>

<script>
export default {
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
.sr-text-container h4{
  font-size:.7rem;
}
.sr-text-container h1{
  margin-bottom: .8rem;
}

.cta{
  margin-top: 1rem;
}

</style>