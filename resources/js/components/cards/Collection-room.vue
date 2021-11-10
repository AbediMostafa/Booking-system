<template>
  <a class="collection-room-container" :href="getRoomPath">
    <div class="cr-text">
      <h4>{{ collectionRoom.name }} </h4>
      <score-stars :score="collectionRoom.total"></score-stars>
      <p>{{ collectionRoom.district }}</p>
    </div>
    <div class="cr-image-container">
      <img :src="roomImage(collectionRoom.image)" />
    </div>
  </a>
</template>

<script>
import ScoreStars from "../packages/Score-stars.vue";

export default {
  components: {
    ScoreStars,
  },
  props: ["collectionRoom"],
  computed:{
      getRoomPath() {
        return sot.getRoomPath(this.collectionRoom.id);
      },

  },
  methods: {
    roomImage(image) {
      return image?image:sot.noImage
    },
  },
};
</script>

<style scoped>
.collection-room-container:first-child {
  margin-top: 0;
}
.collection-room-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 1rem;
}

.cr-image-container {
  flex: 0 0 40%;
}

.cr-text p {
  margin: 0.5rem 0 0 0;
  font-size: 0.8rem;
}
.cr-text h4 {
  margin: 0;
}

.cr-text {
  flex: 0 0 56%;
  text-align: right;
}
</style>
