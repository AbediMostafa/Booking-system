<template>
  <div class="relative-position">
    <div class="between-flex column-reverse">
      <div class="order1 flex-45">
        <section-header
          :titles="titles"
          v-scrollAnimation="enterAnimations.topAnimation"
        ></section-header>
      </div>

      <div class="text-center">
        <div class="mt-12 s-offer-nav-container">
          <span
            v-for="(specialType, key) in specialTypes"
            :class="[key == selectedSpecialKey ? 'special-active' : '']"
            :key="key"
            :ref="key"
            @click="specialClicked(key)"
          >
            {{ specialType.title }}
          </span>
        </div>
      </div>
      <hr class="s-o-n-hr" :style="hrStyle" />
    </div>

    <div class="special-room-cards">
      <room-card v-for="room in rooms" :key="room.id" :room="room" :type="selectedSpecialKey"></room-card>
    </div>
    <img :src="smallShap1" class="shape-1" ref="shape1" />
  </div>
</template>

<script>
import SectionHeader from "../packages/Section-header.vue";
import RoomCard from "../cards/Room-card.vue";
export default {
  components: { SectionHeader, RoomCard },
  data() {
    return {
      specialTypes: {},
      rooms: [],
      hrStyle: "",
      smallShap1: sot.iconPath("large-shape3.svg"),
      selectedSpecialKey: 0,
      rotateDeg: 0,
      enterAnimations: sot.enterAnimations,
      titles: {
        mainTitle: "اتاق های ویژه با",
        icon: true,
        secondTitle: "",
        text: "بعضی از اتاق ها تخفیف های مناسبی دارن و یا بعضیاشون پیشنهادهای ویژه ما هستن، یا بعضی از اتاق ها تازه درست شدن",
      },
    };
  },
  methods: {
    /**
     * get called when special room clicked
     */
    specialClicked(key) {
      // set current rooms
      this.getRooms(
        this.specialTypes[key].route

      );
      this.selectedSpecialKey = key;

      // set coordinate of navigation hr tag
      let el = this.$refs[key][0];
      this.setHrStyle(el);
    },

    /**
     * Set style of navigation HR
     */
    setHrStyle(el) {
      this.hrStyle = `
        width: ${el.getBoundingClientRect().width}px;
        left : ${el.offsetLeft}px;
        top: ${
          el.parentNode.offsetTop + el.parentNode.getBoundingClientRect().height
        }px
      `;
    },

    /**
     * move element on scroll
     */
    runOnScroll() {
      let position = window.pageYOffset / 10,
        degree = window.pageYOffset / 20,
        el = this.$refs.shape1;

      if (el) {
        el.style.cssText = `
        transform:translate(${position}px, ${position}px) rotate(${degree}deg) scale(.6)
        `;
      }
    },

    getRooms(route){
      axios
      .post(route)
      .then(response=>{
        this.rooms = response.data.data;
      });
    }
  },

  created() {
    var runOnScroll = this.runOnScroll;

    window.addEventListener("scroll", function (event) {
      runOnScroll();
    });
  },

  mounted() {
    this.specialTypes = sot.specialTypes;

    let specialTypeKeys = Object.keys(this.specialTypes),
    lastSpecialTypeKey = specialTypeKeys[specialTypeKeys.length - 1],
    selectedSpecial = this.specialTypes[lastSpecialTypeKey];
    this.getRooms(selectedSpecial.route);

    setTimeout(() => {
      let el = this.$refs[lastSpecialTypeKey][0];
      this.selectedSpecialKey = lastSpecialTypeKey;
      this.setHrStyle(el);
    }, 2000);
  },
};
</script>

<style scoped>
.relative-position {
  position: relative;
}

.s-offer-nav-container span:last-child {
  margin-left: 0;
}
.s-offer-nav-container span:hover {
  color: #010101;
}

.s-offer-nav-container {
  border-bottom: 1px solid #dadada;
  padding-bottom: 1rem;
  display: inline-block;
  direction: rtl;
}

.s-o-n-hr {
  position: absolute;
  border-top: 3px solid var(--first-color);
  transition: all 300ms ease-in-out;
  margin: 0;
  padding: 0;
}

.shape-1,
.shape-2 {
  position: absolute;
  width: 20%;
  height: auto;
  z-index: -1;
}

.shape-1 {
  top: -7rem;
  left: -12rem;
}
</style>