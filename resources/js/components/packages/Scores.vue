<template>
  <div class="rs-each-box-container">
    <h1 class="rs-box-title">امتیاز کاربران</h1>
    <div class="rs-box-shadow">
      <div class="rs-rate-sentence">
        <span class="rs-from5">5/</span>
        <span class="rs-rate-avg">{{ rates ? rates.rate_average : [] }}</span>
        <span class="rs-rate-count">
          از مجموع {{ rates ? rates.rate_count : [] }} امتیاز
        </span>
      </div>

      <div class="rs-diagram-container">
        <div
          class="rs-diagram-and-text"
          v-for="(rateItem, key) in rateItems"
          :key="key"
        >
          <div class="rs-diagram">
            <div class="res-diagram-title">
              <h4>
                {{ rateItem.title }}
              </h4>
            </div>

            <div class="rs-diagram-shape-container">
              <div
                class="rs-diagram-dynamic-shape"
                :style="`width:${rateItem.value}%`"
              ></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["rates"],

  data() {
    return {};
  },
  computed: {
    rateItems() {
      return this.rates ? this.rates.items : {};
    },
  },
};
</script>
