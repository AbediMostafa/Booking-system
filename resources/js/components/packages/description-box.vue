<template>
  <div class="rs-box-shadow rsd-image-text-container">
    <div class="rsd-descripton-text">
      <h4 class="rsd-h">{{ room.name }}</h4>
      <p class="rsd-p">{{ room.description }}</p>
      <div class="rsd-cta-collection-container">
        <a class="rsd-cta">
          <span class="lc-read-more">ارسال نظر</span>
          <img :src="iconPath('white-pencil.svg')" class="card-right-arrow" />
        </a>

        <div class="rsd-collection">
          <div class="rsd-collection-name">
            {{ room.collection ? room.collection.name : "" }}
          </div>
          <div
            class="rsd-collection-image"
            :style="imageAsBackground(collectionImg)"
          ></div>
        </div>
      </div>
    </div>
    <div
      class="rsd-image-container"
      :style="imageAsBackground(room.image)"
    ></div>
  </div>
</template>

<script>
export default {
  props: ["room"],
  methods: {
    iconPath(icon) {
      return sot.iconPath(icon);
    },

    imageAsBackground(image) {
      let img = image ? image : sot.noImage;

      return `background: url(${img}) no-repeat center/cover`;
    },
  },

  computed: {
    collectionImg() {
      return this.room.collection ? this.room.collection.image : "";
    },
  },
};
</script>