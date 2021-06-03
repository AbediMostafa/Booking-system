<template>
  <div class="collection-container">
    <div class="collection-text-part">
      <section-header
        :titles="titles"
        v-scrollAnimation="enterAnimations.topAnimation"
      ></section-header>
      <a
        class="cta main-cta mr-6"
        v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation"
        >همه برندهای اتاق فرار</a
      >
    </div>
    <winking-logos class="flex-45"></winking-logos>
  </div>
</template>

<script>
import SectionHeader from "../packages/Section-header.vue";
import WinkingLogos from "../packages/Winking-logos.vue";

export default {
  components: {
    SectionHeader,
    WinkingLogos,
  },
  data() {
    return {
      enterAnimations: sot.enterAnimations,
      titles: {
        mainTitle: "همراهان",
        icon: true,
        secondTitle: "",
        text:
          "هر کدام از کالکشن ها و یا شرکت های اتاق فرار چند اتاق فرار را مدیریت می کنند که ممکن است در هر کجای کشور باشند. این کالکشن ها به سرعت در حال ازدیاد هستند. شما می توانید به کالکشن ها مراجعه و از اتاق های آنها لذت ببرید",
        btnText: "همه برندها",
      },
    };
  },
};
</script>

<style scoped>
.flex-45 {
  flex: 0 0 45%;
}
</style>