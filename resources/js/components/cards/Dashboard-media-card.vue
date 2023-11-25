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
    cardType(type = "") {
      switch (type) {
        case "room":
          break;
        case "city":
          break;
        case "collection":
          break;
        case "genre":
          break;
        case "post":
          break;
        case "specific-media":
          break;
        case "site-variable":
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
