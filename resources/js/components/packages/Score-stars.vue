<template>
  <div class="score-container">
      <div class="rates-count" v-if="rates_count">
      </div>

    <div class="star-container">
      <div class="c-empty-stars"></div>
      <div class="c-filled-stars" :style="starStyle"></div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["score", 'rates_count'],
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
