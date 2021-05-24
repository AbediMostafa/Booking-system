<template>
  <div class="logo-container">
    <span
      v-for="logo in logos"
      :key="logo.id"
      :title="logo.name"
      :class="['collection-logo', logo.visible ? '' : 'hide']"
      :style="`background:url(${logo.image}) no-repeat center center/cover`"
    ></span>
  </div>
</template>

<script>
export default {
  data() {
    return {
      logos: [],
    };
  },

  methods: {
    random(min, max) {
      return Math.floor(Math.random() * (max - min + 1) + min);
    },
  },

  created() {
    this.logos = sot.logos;
    

    setInterval(() => {

        let randomNumber = this.random(0, this.logos.length-1);
        this.logos[randomNumber].visible = false;

        setTimeout(()=>{
            this.logos[randomNumber].visible = true;
        },3000)

    }, 2000);
  },
};
</script>

<style scoped>
.logo-container {
  text-align: center;
  margin-top: 2rem;
}

.hide {
  opacity: 0;
}

.collection-logo {
  width: 3rem;
  height: 3rem;
  display: inline-block;
  margin: 0 0.4rem 0.4rem;
  border-radius: 0.5rem;
  transition: all 400ms;
  filter: hue-rotate(280deg);
}
</style>