<template>
  <div class="comments-boxes">
      <p class="comment-date">{{comment.date}}</p>
    <h4>{{userName}}</h4>
    <score-stars :score="commentRate"></score-stars>
    <div class="comment-recommend" v-if="comment.status == 'agree'">
      <span class="recomend-text">توصیه می کنم</span>
      <img class="recommend-icons" :src="iconPath('blue-check.svg')" />
    </div>
    <div class="comment-recommend" v-if="comment.status == 'disagree'">
      <span class="not-recomend-text">توصیه نمی کنم</span>
      <img class="recommend-icons" :src="iconPath('red-uncheck.svg')" />
    </div>

    <p class="comments-boxes-p">{{ comment.body }}</p>
  </div>
</template>

<script>
import ScoreStars from "../packages/Score-stars.vue";
export default {
  components: {
    ScoreStars,
  },
  props: ["comment"],
  
  computed:{
      commentRate(){
          return this.comment && this.comment.user ? this.comment.user.rate : '';
      },
      userName(){
          return this.comment && this.comment.user ? this.comment.user.name : '';
      }
  },
  methods: {
    iconPath(icon) {
      return sot.iconPath(icon);
    },
  },
};
</script>

<style scoped>
.comments-boxes h4{
    font-size: 1.1rem;
}
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

.comments-boxes{
    cursor: initial;
}
</style>