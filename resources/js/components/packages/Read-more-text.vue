<template>
  <a :class="[position=='end' ? 'end-flex' : 'flex-center', 'mt-10', 'r-m-container']">
    <span :class="`lc-read-more ${additionalClass}`">{{ txt }}</span>
    <img :src="rightArrow" class="card-right-arrow" />
  </a>
</template>

<script>
export default {
  props: {
    txt:{
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

.r-m-container{
    background: var(--second-color);
    padding: .5rem 1rem;
    border-radius: 0.6rem;
    display:inline-block
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
