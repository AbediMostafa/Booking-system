<template>
  <div class="each-contact-info">
    <div class="ci-text">
      {{ text }}</div>
    <div class="ci-icon">
      <img :src="iconPath" />
    </div>
  </div>
</template>

<script>
export default {
  props: ["text", "icon"],
  computed: {
    iconPath() {
      return sot.iconPath(this.icon);
    },
  },
};
</script>

<style scoped>
.ci-icon img {
  width: 1rem;
}
.each-contact-info:last-child {
  margin-bottom: 0;
}

.each-contact-info {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}

.ci-text {
  flex: 1 0 85%;
  font-size: 0.8rem;
  color: var(--main-title);;
}
.ci-icon {
  flex: 0 0 10%;
}
</style>
