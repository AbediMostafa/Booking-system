<template>
    <div>
        <div class="search-input-container">
            <img :src="search" class="search-icon"/>
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
        <div class="pagination-container">
            <div
                class="pagination-btns"
                v-for="(paginate, key) in pagination"
                :key="key"
                @click="getCollection(paginate.url)"
                :class="[paginate.active ? 'active-pagination' : '']"
            >
                {{ paginate.label }}
            </div>
        </div>
    </div>
</template>

<script>
import CollectionCard from "../cards/Collection-card.vue";

export default {
    components: {CollectionCard},
    data() {
        return {
            collections: [],
            search: sot.iconPath("search1.svg"),
            collectionKey: "",
            pagination: [],
        };
    },
    watch: {
        collectionKey() {
            this.getCollection();
        },
    },

    methods: {
        checkLocalStorage() {
            let lastUrl = localStorage.getItem('lastCollectionUrl'),
                isPageReloaded = () => window.performance.navigation.type === 1;

            return lastUrl && isPageReloaded() ? lastUrl : 'getCollections';
        },

        getCollection(url = "getCollections") {
            localStorage.setItem('lastCollectionUrl', url);
            axios.post(url, {key: this.collectionKey}).then((response) => {
                this.collections = response.data.data;
                this.pagination = response.data.meta.links;
            });
        }
    },
    created() {
        this.getCollection(
            this.checkLocalStorage()
        );
    },
};
</script>
