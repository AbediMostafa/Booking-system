<template>
  <div class="comments-boxes">
    <p class="comment-date">{{ comment.date }}</p>

    <h4>{{ comment ? comment.user.name : "" }}</h4>
    <score-stars :score="comment.user.rate"></score-stars>
    <div class="comment-recommend" v-if="comment.status == 'agree'">
      <span class="recomend-text">توصیه می کنم</span>
      <img class="recommend-icons" :src="iconPath('blue-check.svg')" />
    </div>
    <div class="comment-recommend" v-if="comment.status == 'disagree'">
      <span class="not-recomend-text">توصیه نمی کنم</span>
      <img class="recommend-icons" :src="iconPath('red-uncheck.svg')" />
    </div>

    <p class="comments-boxes-p">{{ comment.body }}</p>
    <div class="comment-thumbs-container">
      <div class="cth-up-container cth-containers">
        <img class="thumb-image" :src="iconPath('thumbs-up.svg')" />
        <span class="thumb-text">{{ comment.up_rate }}</span>
      </div>
      <div class="cth-down-container cth-containers">
        <img class="thumb-image" :src="iconPath('thumbs-down.svg')" />
        <span class="thumb-text">{{ comment.down_rate }}</span>
      </div>
    </div>
  </div>
</template>

<script>
import ScoreStars from "../packages/Score-stars.vue";
export default {
  components: {
    ScoreStars,
  },
  props: ["comment"],
  methods: {
    iconPath(icon) {
      return sot.iconPath(icon);
    },
  },
};
</script>

<style scoped>
.comment-recommend {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  margin-top: 0.2rem;
}

.recommend-icons {
  width: 1rem;
  margin-left: 0.4rem;
}

.not-recomend-text {
  font-size: 0.8rem;
  color: #bd4040;
}
.recomend-text {
  color: #176087;
  font-size: 0.8rem;
}

.cth-up-container,
.cth-down-container {
  display: flex;
  align-items: center;
  justify-content: center;
  flex: 0 0 16%;
  background: var(--background1);
  padding: 0.3rem 0.5rem;
  border-radius: 0.5rem;
  margin-left: 0.7rem;
  cursor: pointer;
  transition: all 300ms;
}

.cth-containers:hover{
    box-shadow: 0 0 1rem 0 rgb(0 0 0 / 20%)
}

.thumb-image {
  width: 1rem;
  margin-right: 0.3rem;
}

.thumb-text {
  font-size: 0.8rem;
}

.comment-thumbs-container {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  margin-top: 1.5rem;
}
</style>