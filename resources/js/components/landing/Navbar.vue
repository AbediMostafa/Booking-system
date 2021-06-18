<template>
  <nav>
    <a class="user-login-icon">
      <img :src="iconPath('user.svg')" />
    </a>

    <div class="right-nav">
      <div class="nav-menu-container" :style="navStyle">
        <ul class="nav-menu">
          <li>
            <a
              ><img
                :src="iconPath('gradiant-cancle.svg')"
                class="cancle-icon"
                @click="cancleClicked"
            /></a>
          </li>
          <li v-for="navBar in navBars" :key="navBar.id"><a :href="navBar.route">{{navBar.title}}</a></li>
        </ul>
      </div>

      <a class="logo" :href="homeRoute">
        <img :src="iconPath('logo.svg')" />
      </a>
      <a class="hamburger-menu" @click="hamburgerClicked">
        <img :src="iconPath('hamburger.svg')" />
      </a>
    </div>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      navStyle: "",
      navBars: {},
    };
  },

  computed:{
    homeRoute(){
      return Object.keys(this.navBars).length ? this.navBars['home'].route :'';
    }
  },

  methods: {
    /**
     * get icon path from sot
     */
    iconPath(icon) {
      return sot.iconPath(icon);
    },
    /**
     * get fired when clicked on hamburger icon
     */
    hamburgerClicked() {
      this.navStyle = "transform: translateX(0);";
    },

    /**
     * get fired when clicked on cancle icon
     */
    cancleClicked() {
      this.navStyle = "transform: translateX(100%);";
    },
  },

  created() {
    axios.post("/navbar").then((response) => {
      this.navBars = response.data;
    });
  },
};
</script>

<style scoped>
nav,
.right-nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

nav {
  padding: 0 4%;
}

a {
  cursor: pointer;
}

.logo img,
.hamburger-menu img {
  width: 2rem;
}

.user-login-icon img {
  width: 1.5rem;
}

.nav-menu li:first-child {
  border-top: none;
}
</style>

