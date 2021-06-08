<template>
  <div :class="[position=='end' ? 'end-flex' : 'flex-center', 'mt-10']">
    <span :class="`lc-read-more ${additionalClass}`">{{ txt }}</span>
    <img :src="rightArrow" class="card-right-arrow" />
  </div>
</template>

<script>
export default {
  props: {
    txt:{
      default:'اطلاعات بیشتر'
    },
    additionalClass:{
      default:''
    },
    position:{
      default:'end'
    }
  },
  data() {
    return {
      rightArrow: sot.iconPath("right-arrow.svg"),
    };
  },
};
</script>

<style scoped>
.lc-read-more {
  color: #b259ca;
  font-weight: bold;
  font-size: .9rem;
}

.collection-rm-txt{
  font-size:.7rem
}
@media screen and (min-width:768px) {

  .collection-rm-txt{
  font-size:.8rem
}
}
</style>