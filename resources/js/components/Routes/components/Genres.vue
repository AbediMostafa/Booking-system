<template>
  <div class="d-item-container" v-if="userHasAccessToCreate">
    <div class="d-status-bar">
      <router-link to="/create/genre" class="d-add-item-cta">
        <img :src="iconPath('white-add.svg')" class="small-icon mr-2" />
        <span> اضافه کردن ژانر جدید </span>
      </router-link>
      <div class="search-container">
        <img :src="iconPath('search1.svg')" class="search-icon" />
        <input
          type="text"
          class="d-search-input pr-10"
          v-model="itemKey"
          placeholder="جستجو بر روی همه ژانر ها"
        />
      </div>
    </div>
     <div class="d-second-status-bar">

      <div class="d-delete-items-cta" v-if="selectedEntities.length" @click="deleteEntities">
        حذف ژانر های انتخاب شده
      </div>
    </div>

    <div class="d-cards-container">
      <dashboard-card
        v-for="(entity, key) in entities"
        :key="key"
        :card="entity"
        :has-edit="true"
        :edit-route="'updateGenre'"
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
  </div >

    <div class="alert alert-danger" v-else>
        شما اجازه دسترسی به این صفحه را ندارید
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
        .post("/admin/genre/delete", { genres: this.selectedEntities })
        .then((response) => {
          this.getEntities("/admin/genre");
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

    computed: {
        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        }
    },

    watch: {
    itemKey(value) {
      this.getEntities("admin/genre/search", { search: value });
    },
  },

  created() {
    this.getEntities("/admin/genre");
  },
};
</script>
