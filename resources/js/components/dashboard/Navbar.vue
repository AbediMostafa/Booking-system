<template>
  <div class="d-right-nav">
    <div class="d-user-infos">
      <img
        :src="iconPath('grey-arrow-down.svg')"
        class="d-icon d-user-icon mr-2 small-icon"
      />
      <div class="d-user-name mr-2">علی رستمی</div>
      <img :src="iconPath('gb-person.svg')" class="d-icon d-user-icon" />
    </div>

    <ul class="d-nav-items">
      <li>
        <router-link to="/rooms">
          <span class="d-nav-text">اتاق</span>
          <img :src="iconPath('grey-room.svg')" class="d-icon d-nav-icon" />
        </router-link>
      </li>
      <li class="d-active-nav">
        <router-link to="/cities">
          <span class="d-nav-text">شهر</span>
          <img :src="iconPath('grey-city.svg')" class="d-icon d-nav-icon" />
        </router-link>
      </li>
      <li>
        <router-link to="/collections">
          <span class="d-nav-text">مجموعه</span>
          <img
            :src="iconPath('grey-collection.svg')"
            class="d-icon d-nav-icon"
          />
        </router-link>
      </li>
      <li>
        <router-link to="/genres">
          <span class="d-nav-text">ژانر</span>
          <img :src="iconPath('grey-genre.svg')" class="d-icon d-nav-icon" />
        </router-link>
      </li>
      <li>
        <router-link to="/learns">
          <span class="d-nav-text">آموزش</span>
          <img :src="iconPath('grey-pencil.svg')" class="d-icon d-nav-icon" />
        </router-link>
      </li>
      <li>
        <router-link to="/medias">
          <span class="d-nav-text">گالری</span>
          <img :src="iconPath('grey-media.svg')" class="d-icon d-nav-icon" />
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  methods: {
    iconPath(icon) {
      return sot.iconPath(icon);
    },
  },
};
</script>