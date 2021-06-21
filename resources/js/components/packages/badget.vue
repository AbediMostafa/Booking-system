<template>
  <div class="span-child">
    <img :src="getIcon(icon)" class="room-icons" v-if="icon"/>
    <span>{{ text }}</span>
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
