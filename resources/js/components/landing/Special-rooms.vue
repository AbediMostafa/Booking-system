<template>
  <div class="relative-position">
    <section-header
      :titles="titles"
      v-scrollAnimation="enterAnimations.topAnimation"
    ></section-header>
    <div class="flex-center mt-8 s-offer-nav-container">
      <span
        v-for="(specialType, key) in specialTypes"
        :key="key"
        :ref="key"
        @click="specialClicked(key)"
      >
        {{ specialType.name }}
      </span>
    </div>
    <hr class="s-o-n-hr" :style="hrStyle" />

    <div class="special-room-cards">
      <room-card v-for="room in rooms" :key="room.id" :room="room"></room-card>
    </div>
    <img :src="smallShap1" class="shape-1" />
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
      enterAnimations: sot.enterAnimations,
      titles: {
        mainTitle: "با",
        icon:true,
        secondTitle: "ویژه ها را به راحتی پیدا کن",
        text: "",
        btnText:'همه ویژه ها'
      },
    };
  },
  methods: {
    /**
     * get called when special room clicked
     */
    specialClicked(key) {
      // set current rooms
      this.rooms = this.specialTypes[key].rooms;

      // set coordinate of navigation hr tag
      let el = this.$refs[key][0];
      this.setHrStyle(el);
    },

    /**
     * Set style of navigation HR
     */
    setHrStyle(el) {
      el.classList.add("special-active");
      this.hrStyle = `
        width: ${el.getBoundingClientRect().width}px;
        left : ${el.offsetLeft}px;
        top: ${el.offsetTop + el.parentNode.getBoundingClientRect().height}px
      `;
    },
  },
  mounted() {
    this.specialTypes = sot.specialTypes;

    let specialTypeKeys = Object.keys(this.specialTypes);
    let lastSpecialTypeKey = specialTypeKeys[specialTypeKeys.length - 1];
    this.rooms = this.specialTypes[lastSpecialTypeKey].rooms;

    setTimeout(() => {
      let el = this.$refs[lastSpecialTypeKey][0];

      this.setHrStyle(el);
    }, 2000);
  },
};
</script>

<style scoped>
.relative-position {
  position: relative;
}

.shape-1 {
  position: absolute;
  top: 0;
  left: 0;
  width: 30%;
  height: auto;
  z-index: -1;
}

.s-offer-nav-container span:first-child {
  margin-left: 0;
}
.s-offer-nav-container span:hover {
  color: #010101;
}
.s-offer-nav-container span {
  font-size: 0.8rem;
  margin-left: 1rem;
  color: var(--title);
  cursor: pointer;
}

.s-offer-nav-container {
  border-bottom: 1px solid #dadada;
  padding-bottom: 1rem;
}

.s-o-n-hr {
  position: absolute;
  border-top: 2px solid;
  transition: all 300ms ease-in-out;
  margin: 0;
  padding: 0;
}
</style>