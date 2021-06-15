<template>
<div class="right-carot-container">
  <div class="carot-child-container">
    <img :src="rightArrow" class="card-left-carot" />
  </div>

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
      rightArrow: sot.iconPath("left-carot.svg"),
    };
  },
};
</script>
<style scoped>
.right-carot-container{
  display: flex;
    align-items: center;
    text-align: right;
    justify-content: flex-start;
}

.carot-child-container{
      margin: 1rem 0 -1.5rem -1.5rem;
    background: var(--second-color);
    padding: 1rem 1.4rem;
    border-top-right-radius: 1rem;
    border-bottom-left-radius: 10px;
    display: flex;
}
</style>