<template>
</template>
<script>
export default {
  props:['countData'],
  methods: {
    /**
     * get exact path of icon
     */
    iconPath(icon) {
      return sot.iconPath(icon);
    },
  },
};
</script>

<style scoped>

</style>
