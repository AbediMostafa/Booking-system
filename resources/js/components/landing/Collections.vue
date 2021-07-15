<template>
  <div class="collection-container">
    <div class="collection-text-part">
      <section-header
        :titles="titles"
        v-scrollAnimation="enterAnimations.topAnimation"
      ></section-header>
      <a
      href="/collections"
        class="cta main-cta mr-6"
        v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation"
        >{{collectionData?collectionData.button:''}}</a
      >
    </div>
    <winking-logos class="flex-45"></winking-logos>
  </div>
</template>

<script>
import SectionHeader from "../packages/Section-header.vue";
import WinkingLogos from "../packages/Winking-logos.vue";

export default {
  props:['collectionData'],
  components: {
    SectionHeader,
    WinkingLogos,
  },
  data() {
    return {
      enterAnimations: sot.enterAnimations,
    };
  },

  computed:{
    titles(){
      return {
        mainTitle: this.collectionData?this.collectionData.title:'',
        icon: true,
        secondTitle: "",
        text:this.collectionData?this.collectionData.text:''
      };
    }
  }
};
</script>