<template>
  <div class="d-right-nav">
    <div class="d-user-infos" @click="displayLogout = !displayLogout" v-clickout>
      <img
        :src="iconPath('grey-arrow-down.svg')"
        class="d-icon d-user-icon mr-2 small-icon d-conditional-text"
      />
      <div class="d-user-name mr-2 d-conditional-text">{{ username }}</div>
      <img :src="iconPath('gb-person.svg')" class="d-icon d-user-icon" />
      <div class="logout-box" v-if="displayLogout" @click.stop="logout">
        <span>خروج</span>
      </div>
    </div>

    <ul class="d-nav-items">
      <li>
        <router-link to="/rooms">
          <span class="d-nav-text d-conditional-text">اتاق</span>
          <img :src="iconPath('grey-room.svg')" class="d-icon d-nav-icon" />
        </router-link>
      </li>
      <li class="d-active-nav">
        <router-link to="/cities">
          <span class="d-nav-text d-conditional-text">شهر</span>
          <img :src="iconPath('grey-city.svg')" class="d-icon d-nav-icon" />
        </router-link>
      </li>
      <li>
        <router-link to="/collections">
          <span class="d-nav-text d-conditional-text">مجموعه</span>
          <img
            :src="iconPath('grey-collection.svg')"
            class="d-icon d-nav-icon"
          />
        </router-link>
      </li>
      <li>
        <router-link to="/genres">
          <span class="d-nav-text d-conditional-text">ژانر</span>
          <img :src="iconPath('grey-genre.svg')" class="d-icon d-nav-icon" />
        </router-link>
      </li>
      <li>
        <router-link to="/learns">
          <span class="d-nav-text d-conditional-text">آموزش</span>
          <img :src="iconPath('grey-pencil.svg')" class="d-icon d-nav-icon" />
        </router-link>
      </li>
      <li>
        <router-link to="/medias">
          <span class="d-nav-text d-conditional-text">گالری</span>
          <img :src="iconPath('grey-media.svg')" class="d-icon d-nav-icon" />
        </router-link>
      </li>
      <li>
        <router-link to="/specific-medias">
          <span class="d-nav-text d-conditional-text">مدیاهای خاص</span>
          <img :src="iconPath('grey-media.svg')" class="d-icon d-nav-icon" />
        </router-link>
      </li>
      <li>
        <router-link to="/comments">
          <span class="d-nav-text d-conditional-text">نظرات کاربران</span>
          <img :src="iconPath('grey-pencil.svg')" class="d-icon d-nav-icon" />
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  directives:{
    clickout:{
      bind(el, binding, vnode){
        document.addEventListener('click', (e)=>{
          if(!e.target.closest('.d-user-infos')){
            vnode.context.displayLogout = false;
          }
        });
      }
    }
  },
  data() {
    return {
      username: "",
      displayLogout:false
    };
  },
  methods: {
    logout(){
      axios.post("/logout").then((response) => {
      window.location.href = '/dashboard';
    });

    },
    iconPath(icon) {
      return sot.iconPath(icon);
    },
  },
  created() {
    axios.post("get-credentials").then((response) => {
      this.username = response.data;
    });
  },
};
</script>