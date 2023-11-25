<template>
  <div class="filter-container">
    <div class="end-flex">
      <sticker
        icon="new-icon.svg"
        inner-class="sr-right-sticker"
        class="mr-2"
        v-if="room.is_special"
      ></sticker>
      <sticker
        icon="check.svg"
        inner-class="sr-left-sticker"
        v-if="room.is_new"
      ></sticker>
      <sticker
        icon="check.svg"
        inner-class="sr-middle-sticker"
        v-if="room.has_discount"
      ></sticker>
    </div>

    <div class="span-container header-span-container">
      <header-badget
        :icon="'grey-person'"
      ></header-badget>
      <header-badget
        :icon="'grey-timer'"
      ></header-badget>

        <header-badget
            :icon="'grey-dollar'"
        ></header-badget>

      <div class="header-icon-child">
        <div>
          <img
            :src="getIcon('grey-key.svg')"
            class="room-key-icon header-room-icons"
            v-for="hard in hardness"
            :key="hard"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Sticker from "../packages/Sticker.vue";
import HeaderBadget from "../packages/Header-badget.vue";
export default {
  components: {
    Sticker,
    HeaderBadget,
  },
  props: ["room"],
  methods: {
    getIcon(icon) {
      return sot.iconPath(icon);
    },
  },

  computed:{
    hardness(){

      let hardness = parseInt(this.room.hardness);
      return hardness ? parseInt(this.room.hardness):[];
    }
  }
};
</script>
