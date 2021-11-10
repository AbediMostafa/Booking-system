<template>
  <a
    class="special-room-card learning-card"
    v-scrollAnimation="enterAnimations.leftWithExtraDelayAnimation"
    :href="getRoomPath"
    dir="ltr"
  >
    <div class="sr-image-container sr-learning-image-container">
      <div :style="roomStyle" class="learning-card-image"></div>
      <div class="discount-countdown" v-if="room.discount">
        <div class="discount-sentence">{{ room.discount.amount }}% تخفیف</div>
        <div class="discount-timer">
          <div class="discount-period">
            <div class="discount-time-var">
              {{ second }}
            </div>
            <div class="discount-time-word">ثانیه</div>
          </div>
          <div class="discount-period">
            <div class="discount-time-var">
              {{ minute }}
            </div>
            <div class="discount-time-word">دقیقه</div>
          </div>
          <div class="discount-period">
            <div class="discount-time-var">
              {{ hour }}
            </div>
            <div class="discount-time-word">ساعت</div>
          </div>
          <div class="discount-period">
            <div class="discount-time-var">
              {{ day }}
            </div>
            <div class="discount-time-word">روز</div>
          </div>
        </div>
      </div>
    </div>

    <div class="sr-text-container">
      <h1>{{ room.name }}</h1>
      <h4>{{ room.collectionName }} ({{ room.collectionAddress }})</h4>
      <p></p>
      <score-stars :score="room.totalScore" class="mb-12"></score-stars>

      <div class="carot-child-container">
        <img :src="rightArrow" class="card-left-carot" />
        <div class="end-flex">
          <sticker
            text="ویژه"
            icon="new-icon.svg"
            inner-class="sr-right-sticker"
            v-if="isSpecial"
            class="mr-2"
          ></sticker>
          <sticker
            text="جدید"
            icon="check.svg"
            inner-class="sr-left-sticker"
            v-if="isNew"
          ></sticker>
          <sticker
            text="تخفیف دار"
            icon="check.svg"
            inner-class="sr-middle-sticker"
            v-if="discounted"
          ></sticker>
        </div>
      </div>
    </div>
  </a>
</template>

<script>
import ScoreStars from "../packages/Score-stars.vue";
import ReadMore from "../packages/Read-more.vue";
import Sticker from "../packages/Sticker.vue";

export default {
  components: {
    ScoreStars,
    ReadMore,
    Sticker,
  },
  data() {
    return {
      enterAnimations: sot.enterAnimations,
      rightArrow: sot.iconPath("left-carot.svg"),
      day: "",
      hour: "",
      minute: "",
      second: "",
    };
  },
  props: ["room", "type"],

  methods: {
    calculateTimer() {
      setInterval(() => {
        var now = Math.floor(new Date().getTime() / 1000),
          distance = this.room.discount.ended_at - now;
        if (distance < 0) {
          this.day = this.hour = this.minute = this.second = "00";
        } else {
          let day = Math.floor(distance / (60 * 60 * 24)),
            hour = Math.floor((distance % (60 * 60 * 24)) / (60 * 60)),
            minute = Math.floor((distance % (60 * 60)) / 60),
            second = Math.floor(distance % 60);

          this.day = day < 10 ? `0${day}` : day;
          this.hour = hour < 10 ? `0${hour}` : hour;
          this.minute = minute < 10 ? `0${minute}` : minute;
          this.second = second < 10 ? `0${second}` : second;
        }
      }, 1000);
    },
  },
  computed: {
    getRoomPath() {
      return sot.getRoomPath(this.room.id);
    },
    roomStyle() {
      let img = this.room && this.room.image ? this.room.image : sot.noImage;
      return `background: url('${img}') no-repeat center center/cover;`;
    },

    isNew() {
      return this.type !== "new" && this.room.is_new;
    },

    isSpecial() {
      return this.type !== "special" && this.room.is_special;
    },

    discounted() {
      return this.room.discount;
    },
  },

  mounted() {
    if (this.room.discount) {
      this.calculateTimer();
    }
  },
};
</script>

<style scoped>
</style>
