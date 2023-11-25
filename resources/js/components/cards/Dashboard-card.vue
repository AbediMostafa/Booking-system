<template>
  <div
    class="d-card-container"
  >
      <div class="room-disabled-container">
      </div>
    <div :style="roomStyle" class="d-card-image"></div>
    <div class="d-card-text">{{card.name}}</div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      enterAnimations: sot.enterAnimations,
    };
  },
  props: ["card", 'hasEdit', 'editRoute'],
  computed: {
    roomStyle() {
      let image = this.card.image ? this.card.image : sot.noImage;
      return `background: url('${image}') no-repeat center center/cover;`;
    },
  },
  methods: {
    editCard(){
      this.$router.push({name:this.editRoute, params:{id:this.card.id}})
    }
  },
};
</script>

<style scoped>
.d-card-image{
    height: 5rem;
    border-radius: 10px;
    box-shadow: 0 0px 27px 3px rgb(0 0 0 / 6%);
}
</style>
