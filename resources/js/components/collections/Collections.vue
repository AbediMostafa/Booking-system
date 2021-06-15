<template>
  <div>
    <div class="search-input-container">
      <img :src="search" class="search-icon" />
      <input
        type="text"
        class="search-input"
        v-model="collectionKey"
        placeholder="جستجو بر روی همه مجموعه ها"
      />
    </div>
    <div class="global-card-container">
      <collection-card
        v-for="collection in collections"
        :collection="collection"
        :key="collection.id"
      ></collection-card>
    </div>
  </div>
</template>

<script>
import CollectionCard from "../cards/Collection-card.vue";
export default {
  components: { CollectionCard },
  data() {
    return {
      collections: [],
      search: sot.iconPath("search1.svg"),
      collectionKey: "",
    };
  },
  watch: {
    collectionKey() {
      axios
        .post("collections/search", { key: this.collectionKey })
        .then((response) => {
          this.collections = response.data.data;
        });
    },
  },
  created() {
    axios.post("collections").then((response) => {
      this.collections = response.data.data;
    });
  },
};
</script>