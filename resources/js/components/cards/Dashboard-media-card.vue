<template>
  <div class="d-card-container">
    <div
      :style="roomStyle"
      class="d-card-image"
      v-if="card.type == 'image'"
    ></div>
    <video controls v-else>
      <source :src="card.path" type="video/mp4" />
      <source :src="card.path" type="video/ogg" />
      Your browser does not support the video tag.
    </video>

    <div class="d-card-text">{{ card.name }}</div>
    <div class="d-media-of" :key="media_of" v-for="media_of in card.media_of">
      {{ cardType(media_of) }}
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      enterAnimations: sot.enterAnimations,
    };
  },
  props: ["card"],
  computed: {
    roomStyle() {
      return `background: url('${this.card.path}') no-repeat center center/cover;`;
    },
  },

  methods: {
    cardType(type = "بدون دسته") {
      switch (type) {
        case "room":
          type = "اتاق";
          break;
        case "city":
          type = "شهر";
          break;
        case "collection":
          type = "مجموعه";
          break;
        case "genre":
          type = "ژانر";
          break;
        case "post":
          type = "آموزش";
          break;
        case "specific-media":
          type = "مدیای خاص";
          break;
        case "site-variable":
          type = "متغیرهای سایت";
          break;
      }
      return type;
    },
  },
};
</script>

<style scoped>
.d-card-image {
  height: 5rem;
  border-radius: 10px;
  box-shadow: 0 0px 27px 3px rgb(0 0 0 / 6%);
}
</style>
