<template>
  <div class="score-container">
    <div class="star-container" v-if="score">
      <div class="c-empty-stars"></div>
      <div class="c-filled-stars" :style="starStyle"></div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["score"],
  computed: {
    starStyle() {
      return `width:${this.score}%`;
    },
  },
};
</script>

<style scoped>
.flex-right {
  display: flex;
  justify-content: flex-end;
}

.no-rate{
  font-size: 0.7rem;
    margin-right: .5rem;
    color: var(--text);
    display: block;
}

.score-container{
  display: flex;
    justify-content: flex-end;
    align-items: center;
}
</style>