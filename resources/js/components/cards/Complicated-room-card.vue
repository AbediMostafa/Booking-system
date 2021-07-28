<template>
  <a
    :href="getRoomPath"
    class="special-room-card learning-card"
    v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation"
  >
    <div class="sr-image-container sr-learning-image-container">
      <div :style="roomStyle" class="learning-card-image"></div>
    </div>

    <div class="sr-text-container">
      <h1>{{ room.name }}</h1>
      <h4>{{ room.collectionName }} ({{ room.district }})</h4>
      <score-stars :score="room.rate_percent"></score-stars>
      <div class="span-container">
        <badget
          :icon="'white-person'"
          :text="`${room.min_person} - ${room.max_person}`"
        ></badget>
        <badget :icon="'white-timer'" :text="`${room.game_time}`"></badget>
          <badget :icon="'white-dollar'" :text="`${room.price}`"></badget>

      </div>
      <read-more v-if="noReadmore !== 'learn'"></read-more>
    </div>
  </a>
</template>

<script>
import ScoreStars from "../packages/Score-stars.vue";
import ReadMore from "../packages/Read-more.vue";
import Badget from "../packages/badget.vue";

export default {
  components: {
    ScoreStars,
    ReadMore,
    Badget,
  },
  data() {
    return {
      enterAnimations: sot.enterAnimations,
    };
  },
  props: ["room", "noReadmore"],
  computed: {
    roomStyle() {
      let img = this.room.image ? this.room.image : sot.noImage;
      return `background: url('${img}') no-repeat center center/cover;`;
    },
    getRoomPath() {
      return sot.getRoomPath(this.room.id);
    },
  },
  methods: {
    getIcon(icon) {
      return sot.iconPath(icon) + ".svg";
    },
  },
};
</script>

<style scoped>
.sr-text-container h1 {
  font-size: 1.2rem;
}
.sr-text-container h4 {
  direction: rtl;
}
</style>
