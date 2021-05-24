<template>
  <div class="header-section">
    <div class="title-and-cta">
      <a class="cta" v-if="titles.btnText">{{titles.btnText}}</a>
      <div class="title-icon">
        <img :src="iconPath" alt="icon" v-if="titles.icon"/>
        <h1>{{ titles.mainTitle }}</h1>
      </div>
    </div>

    <h2 class="second-title" v-if="titles.secondTitle">{{ titles.secondTitle }}</h2>
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
}

.second-title {
  font-size: 1rem;
  margin: 0.5rem 0 0 0;
}
.title-icon {
  display: flex;
  align-items: center;
  justify-content: flex-end;
}

.title-icon h1 {
  font-size: 1.5rem;
  margin: 0;
  padding: 0;
}

.title-icon img {
  width: 3rem;
  margin-right: 0.5rem;
}
.header-text{
  font-size: .8rem;
  margin-top: 1.8rem;
}
</style>