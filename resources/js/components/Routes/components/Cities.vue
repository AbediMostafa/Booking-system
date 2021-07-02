<template>
  <div class="d-item-container">
    <div class="d-status-bar">
      <router-link to="/create/media" class="d-add-item-cta">
        <img :src="iconPath('white-add.svg')" class="small-icon mr-2" />
        <span> اضافه کردن شهر جدید </span>
      </router-link>
      <div class="search-container">
        <img :src="iconPath('search1.svg')" class="search-icon" />
        <input
          type="text"
          class="search-input"
          v-model="itemKey"
          placeholder="جستجو بر روی همه شهرها"
        />
      </div>
    </div>
     <div class="d-second-status-bar">

      <div class="d-delete-items-cta" v-if="selectedEntities.length" @click="deleteEntities">
        حذف شهرهای انتخاب شده
      </div>
    </div>

    <div class="d-cards-container">
      <dashboard-card
        v-for="(entity, key) in entities"
        :key="key"
        :card="entity"
        :has-edit="true"
        :edit-route="'updateCity'"
        :class="[
          selectedEntities.includes(entity.id) ? 'selected-checked-item' : '',
        ]"
        @click.native="cardClicked(entity)"
      ></dashboard-card>
    </div>

    <div class="pagination-container">
      <div
        class="pagination-btns"
        v-for="(pagination, key) in paginations"
        :key="key"
        @click="getEntities(pagination.url)"
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
      entities: [],
      selectedEntities: [],
      itemKey: "",
    };
  },
  methods: {
    deleteEntities() {
      axios
        .post("/admin/city/delete", { cities: this.selectedEntities })
        .then((response) => {
          this.getEntities("/admin/city");
          this.selectedEntities = [];
        });
    },
    cardClicked(entity) {
      if (this.selectedEntities.includes(entity.id)) {
        this.selectedEntities = _.without(this.selectedEntities, entity.id);
      } else {
        this.selectedEntities.push(entity.id);
      }
    },
    getEntities(url, data = {}) {
      axios.post(url, data).then((response) => {
          this.entities = response.data.data;
        this.paginations = response.data.meta.links;
      });
    },

    iconPath(icon) {
      return sot.iconPath(icon);
    },
  },

  watch: {
    itemKey(value) {
      this.getEntities("admin/city/search", { search: value });
    },
  },

  created() {
    this.getEntities("/admin/city");
  },
};
</script>

<style scoped>
.d-type-filter-container {
  margin: 0 0.3rem 0.3rem 0;
}

.d-delete-items-cta {
  background: #dc2b20c9;
  padding: 0.6rem 1.1rem;
  border-radius: 0.5rem;
  color: white !important;
  font-size: 0.8rem;
  cursor: pointer;
  transition: all 300ms;
  margin: 0 0 0.3rem 0.3rem;
}
.search-input {
  border: none;
  padding: 0.5rem 2.8rem 0.5rem 1rem;
  border-radius: 0.5rem;
  width: 100%;
  text-align: right;
  background: rgba(255, 255, 255, 0.8);
  box-shadow: 0 0 1rem 3px rgb(0 0 0 / 7%);
}
.search-container {
  position: relative;
  flex: 0 0 11.1rem;
}

.pagination-btns {
  width: 2rem;
  height: 2rem;
  box-shadow: none;
  border: 1px solid rgba(0, 0, 0, 0.1);
  color: rgba(0, 0, 0, 0.6);
  font-size: 0.9rem;
}

.d-second-status-bar {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
}

@media screen and (min-width: 480px) {
  .search-container {
    position: relative;
    flex: 0 0 13.1rem;
  }
}

@media screen and (min-width: 768px) {
  .d-second-status-bar {
    justify-content: space-between;
  }
}
</style>