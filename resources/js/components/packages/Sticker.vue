<template>
  <div :class="['flex-center', 'sr-sticker', innerClass]">
    <span class="sticker-txt">{{ text }}</span>
    <img :src="iconPath" class="sticker-img" />
  </div>
</template>

<script>
export default {
  props: ["text", "icon", "innerClass"],
  computed: {
    iconPath() {
      return sot.iconPath(this.icon);
    },
  },
};
</script>