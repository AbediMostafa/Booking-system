<template>
  <nav>
    <div class="nav-user-login" @click="displayUserDialog = !displayUserDialog" v-clickout>
      <a class="user-login-icon">
        <img
          :src="iconPath('arrow-down.svg')"
          class="d-icon d-user-icon mr-2 tiny-icon"
        />
        <span class="nav-username">
          {{ username }}
        </span>
        <img :src="iconPath('grey-user.svg')" />
      </a>

      <div v-if="displayUserDialog">
        <div class="nav-user-submenu" v-if="username">
          <a href="/logout" class="nav-logout-container">
            <span> خروج </span>
            <img :src="iconPath('logout.svg')" class="log-in-out-img" />
          </a>
        </div>

        <div class="nav-user-submenu" v-else>
          <a href="/phone-check/home" class="nav-logout-container">
            <span> ورود </span>
            <img :src="iconPath('grey-user.svg')" class="log-in-out-img" />
          </a>
        </div>
      </div>
    </div>

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
          <li v-for="navBar in navBars" :key="navBar.id">
            <a :href="navBar.route">{{ navBar.title }}</a>
          </li>
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
  directives:{
    clickout:{
      bind(el, binding, vnode){
        document.addEventListener('click', (e)=>{
          if(!e.target.closest('.nav-user-login')){
            vnode.context.displayUserDialog = false;
          }
        });
      }
    }
  },
  data() {
    return {
      navStyle: "",
      navBars: {},
      username: "",
      displayUserDialog:false
    };
  },

  computed: {
    homeRoute() {
      return Object.keys(this.navBars).length ? this.navBars["home"].route : "";
    },
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

    axios.post("/get-credentials").then((response) => {
      this.username = response.data;
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
  width: 1rem;
}

.user-login-icon {
  display: flex;
  align-items: center;
  justify-content: center;
}

.nav-menu li:first-child {
  border-top: none;
}

.tiny-icon {
  width: 0.7rem !important;
}

.nav-user-submenu {
  position: absolute;
  top: calc(100% + 21px);
  left: -16px;
  width: 150px;
  background: #fff;
  box-shadow: 0 6px 27px 7px rgb(0 0 0 / 6%);
  z-index: 100;
  cursor: pointer;
  border-radius: 10px;
  padding: 0.5rem 2rem;
  text-align: right;
  font-size: 0.9rem;
}

.nav-user-login {
  position: relative;
}

.nav-username {
  margin-right: 0.5rem;
  font-size: 0.9rem;
  color: var(--title);
}

.nav-logout-container {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  color: var(--title);
}

.log-in-out-img {
  width: 0.8rem;
  margin-left: 0.7rem;
}
</style>

