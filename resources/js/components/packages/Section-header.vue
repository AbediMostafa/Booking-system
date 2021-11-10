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
