<template>
  <div class="rs-each-box-container">
    <div class="rs-box-shadow" v-if="rates ? rates.rate_average : 0">
      <div class="rs-rate-sentence">
        <span class="rs-from5">5/</span>
        <span class="rs-rate-avg">{{
          rates ? rates.rate_average.toFixed(1) : []
        }}</span>
        <span class="rs-rate-count">
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

    <no-entity
      v-else
      image="no-rate.svg"
      image-width="50"
    ></no-entity>
  </div>
</template>

<script>
import NoEntity from "../packages/No-entity.vue";
export default {
  components: {
    NoEntity,
  },
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
