<template>
  <div class="d-item-container">
    <div class="d-status-bar">
      <div class="search-container">
        <img :src="iconPath('search1.svg')" class="search-icon" />
        <input
          type="text"
          class="d-search-input pr-10"
          v-model="itemKey"
          placeholder="جستجو بر روی همه کامنت ها"
        />
      </div>
    </div>
    <div class="d-second-status-bar">
      <div v-if="selectedEntities.length" class="flex-center">
        <div class="d-delete-items-cta" @click="deleteEntities">
          حذف کامنت ها
        </div>

        <div class="d-delete-items-cta d-grant-cta" @click="grantEntities">دادن مجوز</div>
      </div>
    </div>

    <div class="d-cards-container">
      <comment
        v-for="(entity, key) in entities"
        :key="key"
        :comment="entity"
        :class="[
         'pointer', selectedEntities.includes(entity.id) ? 'selected-checked-item' : '',
        ]"
        @click.native="cardClicked(entity)"
      ></comment>
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
import Comment from "../../cards/Comment.vue";
export default {
  components: {
    Comment,
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
    grantEntities() {
        axios
        .post("/admin/comment/grant", { comments: this.selectedEntities })
        .then((response) => {
          this.getEntities("/admin/comment");
          this.selectedEntities = [];
        });
    },
    deleteEntities() {
      axios
        .post("/admin/comment/delete", { comments: this.selectedEntities })
        .then((response) => {
          this.getEntities("/admin/comment");
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
      this.getEntities("admin/comment/search", { search: value });
    },
  },

  created() {
    this.getEntities("/admin/comment");
  },
};
</script>

<style scoped>
.pointer{
    cursor: pointer;
}

.d-grant-cta{
    background:#65a856;
}
</style>