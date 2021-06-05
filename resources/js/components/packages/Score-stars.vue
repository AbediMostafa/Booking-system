<template>
  <div class="flex-right">
    <div class="star-container">
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
.flex-right{
  display: flex;
  justify-content: flex-end;
}
</style>