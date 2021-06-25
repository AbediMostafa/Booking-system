<template>
  <div class="header-icon-child">
    <img :src="getIcon(icon)" class="room-icons header-room-icons" v-if="icon"/>
    <span class="header-icon-txt">{{ text }}</span>
  </div>
</template>

<script>
export default {
  props: ["icon", "text"],
  methods: {
    getIcon(icon) {
      return sot.iconPath(icon) + ".svg";
    },
  },
};
</script>
