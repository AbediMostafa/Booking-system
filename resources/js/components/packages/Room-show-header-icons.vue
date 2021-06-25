<template>
  <div class="filter-container">
    <div class="end-flex">
      <sticker
        text="اتاق ویژه"
        icon="new-icon.svg"
        inner-class="sr-right-sticker"
        class="mr-2"
        v-if="room.is_special"
      ></sticker>
      <sticker
        text="اتاق جدید"
        icon="check.svg"
        inner-class="sr-left-sticker"
        v-if="room.is_new"
      ></sticker>
      <sticker
        text="اتاق تخفیف دار"
        icon="check.svg"
        inner-class="sr-middle-sticker"
        v-if="room.has_discount"
      ></sticker>
    </div>

    <div class="span-container header-span-container">
      <header-badget
        :icon="'grey-person'"
        :text="`${room.min_person} - ${room.max_person} نفره`"
      ></header-badget>
      <header-badget
        :icon="'grey-timer'"
        :text="`${room.game_time} دقیقه`"
      ></header-badget>

      <div class="header-icon-child">
        <img
          :src="getIcon('grey-key.svg')"
          class="room-key-icon header-room-icons"
          v-for="hard in room.hardness"
          :key="hard"
        />
        <span class="header-icon-txt hardness-header-text">درجه سختی</span>
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
};
</script>