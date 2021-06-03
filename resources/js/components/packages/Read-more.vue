<template>
  <div class="end-flex mt-4">
    <span class="lc-read-more">{{ txt }}</span>
    <img :src="rightArrow" class="card-right-arrow" />
  </div>
</template>

<script>
export default {
  props: ["txt"],
  data() {
    return {
      rightArrow: sot.iconPath("right-arrow.svg"),
    };
  },
};
</script>

<style scoped>
.lc-read-more {
  color: #b259ca;
  font-size: 0.9rem;
  font-weight: bold;
}
</style>