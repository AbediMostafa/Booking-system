<template>
  <div class="count-container">
    <div class="count-parts">
      <div class="count-text-part">
        <span>٧٥+</span>
        <span>شهر</span>
      </div>
      <img :src="iconPath('white-city.svg')" class="white-icons" />
    </div>
    <div class="count-parts">
      <div class="count-text-part">
        <span>۴۰+</span>
        <span>مجموعه</span>
      </div>
      <img :src="iconPath('white-collection.svg')" class="white-icons" />
    </div>
    <div class="count-parts">
      <div class="count-text-part">
        <span>۵۰۰+</span>
        <span>اتاق فرار</span>
      </div>
      <img :src="iconPath('white-escape.svg')" class="white-icons" />
    </div>
  </div>
</template>
<script>
export default {
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
.count-parts {
  border-left: 1px solid rgba(255, 255, 255, 0.4);
}

.count-parts:first-child {
  border-left: none;
}

.count-text-part {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-right: 1rem;
  line-height: 1;
  padding-left: 1rem;
}
</style>