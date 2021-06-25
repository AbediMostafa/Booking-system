<template>
  <div class="ne-image-text-container rs-box-shadow">
    <div class="no-entity-image-container" :style="`width:${imageWidth}%`">
      <img :src="iconPath" />
    </div>
    <div class="no-entity-text">
      {{text}}
    </div>
  </div>
</template>

<script>
export default {
    props:['image', 'text', 'imageWidth'],
    computed: {
        iconPath(){
            return sot.iconPath(this.image)
        }
    },
};
</script>