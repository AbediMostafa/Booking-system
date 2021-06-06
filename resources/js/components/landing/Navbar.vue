<template>
  <nav>
    
    <a class="user-login-icon">
      <img :src="sot.iconPath('user.svg')" />
    </a>

    <div class="right-nav">
      <div class="nav-menu-container" :style="navStyle">
        <ul class="nav-menu">
          <li>
            <a
              ><img
                :src="sot.iconPath('gradiant-cancle.svg')"
                class="cancle-icon"
                @click="cancleClicked"
            /></a>
          </li>
          <li><a>ویژه ها</a></li>
          <li><a>خانه</a></li>
          <li><a>ژانر</a></li>
          <li><a>مجموعه ها</a></li>
          <li><a>شهر</a></li>
        </ul>
      </div>

      <a class="logo">
        <img :src="sot.iconPath('logo.svg')" />
      </a>
      <a class="hamburger-menu" @click="hamburgerClicked">
        <img :src="sot.iconPath('hamburger.svg')" />
      </a>
    </div>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      navStyle: "",
      sot
    };
  },

  methods: {
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
};
</script>

<style scoped>
nav,
.right-nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

nav{
  padding:0 4%;
  margin-bottom: 1rem;
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

