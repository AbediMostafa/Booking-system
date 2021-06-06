<template>
  <div class="header" :style="headerBackground">
    <div class="overlay header-overlay"></div>

    <div class="header-txt-content">
      <h1
        v-scrollAnimation="enterAnimations.topAnimation"
        class="header-main-title"
      >
        {{ info.title }}
      </h1>
      <p v-scrollAnimation="enterAnimations.topWithDelayAnimation">
        {{ info.text }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  props: ["info"],
  data() {
    return {
      enterAnimations: sot.enterAnimations,
    };
  },
  methods: {},
  computed: {
    headerBackground() {
      return `background:url(${this.info.imageSrc}) no-repeat top/cover`;
    },
  },
};
</script>

<style scoped>
.header {
  padding: 1rem 10% 2rem;
  color: white;
  position: relative;
}

.header-txt-content {
  text-align: center;
}

.header-overlay {
  top: 0;
  right: 0;
  z-index: initial;
}
</style>