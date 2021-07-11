<template>
  <div class="header">
    <div class="header-txt-content">
      <h1
        v-scrollAnimation="enterAnimations.topAnimation"
        class="header-main-title"
      >
        {{ info.title }}
      </h1>
      <p
        class="header-paragraph"
        v-scrollAnimation="enterAnimations.topWithDelayAnimation"
      >
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
};
</script>

<style scoped>

.header-txt-content {
  text-align: center;
    max-width: 40rem;
    padding: 3rem 0;
    margin: 0 auto;
}

.header-overlay {
  top: 0;
  right: 0;
  z-index: initial;
}

.header-paragraph {
  line-height: 2;
  direction: rtl;
  padding: 0 .5rem;
}

</style>