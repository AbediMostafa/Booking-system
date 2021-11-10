<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div class="d-status-bar">
            <router-link to="/create/media" class="d-add-item-cta">
                <img :src="iconPath('white-add.svg')" class="small-icon mr-2"/>
                <span> اضافه کردن مدیا جدید </span>
            </router-link>
            <div class="search-container">
                <img :src="iconPath('search1.svg')" class="search-icon"/>
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

            <div class="d-delete-items-cta" v-if="selectedMedias.length" @click="deleteMedias">
                حذف مدیاهای انتخاب شده
            </div>
        </div>

        <div class="d-cards-container">
            <dashboard-media-card
                v-for="(media, key) in medias"
                :key="key"
                :card="media"
                :class="[
          selectedMedias.includes(media.id) ? 'selected-checked-item' : '',
        ]"
                @click.native="cardClicked(media)"
            ></dashboard-media-card>
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

    <div class="alert alert-danger" v-else>
        شما اجازه دسترسی به این صفحه را ندارید
    </div>
</template>

<script>
import DashboardMediaCard from "../../cards/Dashboard-media-card.vue";

export default {
    components: {
        DashboardMediaCard,
    },
    data() {
        return {
            medias: {},
            paginations: {},
            selectedMedias: [],
            itemKey: "",
            itemTypes: {
                room: {title: "اتاق", value: "room", clicked: false},
                city: {title: "شهر", value: "city", clicked: false},
                collection: {title: "مجموعه", value: "collection", clicked: false},
                genre: {title: "ژانر", value: "genre", clicked: false},
                post: {title: "آموزش", value: "post", clicked: false},
            },
        };
    },
    methods: {

        deleteMedias() {
            axios.post('/admin/media/delete', {medias: this.selectedMedias}).then(response => {
                this.getMedias("/admin/media");
                this.selectedMedias = [];
            });
        },
        cardClicked(media) {
            if (this.selectedMedias.includes(media.id)) {
                this.selectedMedias = _.without(this.selectedMedias, media.id);
            } else {
                this.selectedMedias.push(media.id);
            }
        },
        itemTypeClicked(key) {
            let itemStatus = this.itemTypes[key].clicked;

            _.forOwn(this.itemTypes, function (itemType, key) {
                itemType.clicked = false;
            });

            this.itemTypes[key].clicked = !itemStatus;

            let postData = {filter: this.itemTypes[key].clicked ? key : ""};

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

    computed: {
        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        }
    },

    watch: {
        itemKey(value) {
            this.getMedias("admin/media/search", {search: value});
        },
    },

    created() {
        this.getMedias("/admin/media");
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
