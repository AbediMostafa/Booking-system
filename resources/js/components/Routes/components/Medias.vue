<template>
  <div class="d-item-container">
    <div class="d-status-bar">
      <router-link to='/create/media' class="d-add-item-cta">
        <img :src="iconPath('white-add.svg')" class="small-icon mr-2" />
        <span> اضافه کردن مدیا جدید </span>
      </router-link>
      <div class="search-container">
        <img :src="iconPath('search1.svg')" class="search-icon" />
        <input
          type="text"
          class="search-input"
          v-model="itemKey"
          placeholder="جستجو بر روی همه مدیاها"
        />
      </div>
    </div>

    <div class="d-second-status-bar">
      <div class="d-type-filter-container">
        <ul class="d-inner-type-filter">
          <li
            v-for="(itemType, key) in itemTypes"
            :key="key"
            @click="itemTypeClicked(key)"
            :class="[itemType.clicked ? 'clicked-d-inner-filter' : '']"
          >
            {{ itemType.title }}
          </li>
        </ul>
      </div>
    </div>

    <div class="d-cards-container">
      <dashboard-card
        v-for="(media, key) in medias"
        :key="key"
        :card="media"
      ></dashboard-card>
    </div>

    <div class="pagination-container">
      <div
        class="pagination-btns"
        v-for="(pagination, key) in paginations"
        :key="key"
        @click="getMedias(pagination.url)"
        :class="[pagination.active ? 'active-pagination' : '']"
      >
        {{ pagination.label }}
      </div>
    </div>
  </div>
</template>

<script>
import DashboardCard from "../../cards/Dashboard-card.vue";
export default {
  components: {
    DashboardCard,
  },
  data() {
    return {
      medias: {},
      paginations: {},
      itemKey: "",
      itemTypes: {
        room: { title: "اتاق", value: "room", clicked: false },
        city: { title: "شهر", value: "city", clicked: false },
        collection: { title: "مجموعه", value: "collection", clicked: false },
        genre: { title: "ژانر", value: "genre", clicked: false },
        post: { title: "آموزش", value: "post", clicked: false },
      },
    };
  },
  methods: {
    itemTypeClicked(key) {
      let itemStatus = this.itemTypes[key].clicked;

      _.forOwn(this.itemTypes, function (itemType, key) {
        itemType.clicked = false;
      });

      this.itemTypes[key].clicked = !itemStatus;

      let postData = { filter: this.itemTypes[key].clicked ? key : "" };

      this.getMedias("admin/media/filter", postData);
    },
    getMedias(url, data = {}) {
      axios.post(url, data).then((response) => {
        this.medias = response.data.data;
        this.paginations = response.data.links;
      });
    },

    iconPath(icon) {
      return sot.iconPath(icon);
    },
  },

  watch: {
    itemKey(value) {
      this.getMedias("admin/media/search", { search: value });
    },
  },

  created() {
    this.getMedias("/admin/media");
  },
};
</script>

<style scoped>
.search-input {
  border: none;
  padding: 0.5rem 2.8rem 0.5rem 1rem;
  border-radius: 0.6rem;
  width: 100%;
  text-align: right;
  background: rgba(255, 255, 255, 0.8);
  box-shadow: 0 0 1rem 3px rgb(0 0 0 / 7%);
}
.search-container {
  position: relative;
  flex: 0 0 13.1rem;
}

.pagination-btns {
  width: 2rem;
  height: 2rem;
  box-shadow: none;
  border: 1px solid rgba(0, 0, 0, 0.1);
  color: rgba(0, 0, 0, 0.6);
  font-size: 0.9rem;
}
</style>