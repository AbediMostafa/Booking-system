<template>
  <div class="header-section" :style="titles.headerStyle">
    <div class="title-icon">
      <img :src="iconPath" alt="icon" v-if="titles.icon" />
      <h1>{{ titles.mainTitle }}</h1>
    </div>

    <h2 class="second-title" v-if="titles.secondTitle">
      {{ titles.secondTitle }}
    </h2>
    <p class="header-text" v-if="titles.text">{{ titles.text }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      iconPath: sot.iconPath("logo.svg"),
    };
  },
  props: ["titles"],
};
</script>

<style scoped>
.header-section {
  text-align: right;
  margin: 2rem 1.5rem 2rem 0;
}

.title-icon {
  display: flex;
  align-items: center;
  justify-content: flex-end;
}

.title-icon img {
  width: 3rem;
  margin-right: 0.5rem;
}
.header-text {
  font-size: 0.9rem;
  margin-top: 1.8rem;
  line-height: 1.9;
}
</style>