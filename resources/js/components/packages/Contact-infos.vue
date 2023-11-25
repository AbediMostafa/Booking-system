<template>
  <div class="rs-each-box-container mt-8">
    <div class="rs-contact-infos rs-box-shadow">
      <each-contact-info
        icon="location.svg"
        :text="infos ? infos.address : ''"
        v-if="infos && infos.address"
      ></each-contact-info>

      <each-contact-info
        icon="phone.svg"
        :text="infos ? infos.phone : ''"
        v-if="infos&&infos.phone"
      ></each-contact-info>

        <each-contact-info
            icon="mobile.svg"
            :text="infos ? infos.mobile : ''"
            v-if="infos&&infos.mobile"
        ></each-contact-info>

      <each-contact-info
        icon="website.svg"
        :text="infos ? infos.website : ''"
        v-if="infos&&infos.website"
      ></each-contact-info>
    </div>
  </div>
</template>

<script>
import EachContactInfo from "../packages/Each-contact-info.vue";
export default {
  components: {
    EachContactInfo,
  },
  props: ["infos"],

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

<style scoped>
.rs-contact-infos {
  display: flex;
  flex-direction: column;
}
</style>
