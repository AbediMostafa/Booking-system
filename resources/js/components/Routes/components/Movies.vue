<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div class="d-status-bar">
            <router-link to="/create/movie" class="d-add-item-cta">
                <img :src="iconPath('white-add.svg')" class="small-icon mr-2"/>
                <span> اضافه کردن فیلم جدید </span>
            </router-link>
            <div class="search-container">
                <img :src="iconPath('search1.svg')" class="search-icon"/>
                <input
                    type="text"
                    class="d-search-input pr-10"
                    v-model="itemKey"
                    placeholder="جستجو بر روی همه فیلم ها"
                />
            </div>
        </div>
        <div class="d-second-status-bar">

            <div class="d-delete-items-cta" v-if="selectedEntities.length" @click="deleteEntities">
                حذف فیلم های انتخاب شده
            </div>
        </div>

        <div class="d-cards-container">
            <dashboard-card
                v-for="(entity, key) in entities"
                :key="key"
                :card="entity"
                :has-edit="true"
                :edit-route="'updateMovie'"
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
        callApi(data, callB = null, url = '/movies') {
            axios.post(url, data).then(response => {
                callB && callB(response);
            })
        },
        deleteEntities() {

            this.callApi({
                    movies: this.selectedEntities,
                    method: 'actionDelete'
                },
                () => {
                    this.getEntities();
                    this.selectedEntities = [];
                }
            )
        },
        cardClicked(entity) {
            if (this.selectedEntities.includes(entity.id)) {
                this.selectedEntities = _.without(this.selectedEntities, entity.id);
            } else {
                this.selectedEntities.push(entity.id);
            }
        },
        getEntities(url = '/movies', data = {}) {

            this.callApi({
                    method: 'actionIndex',
                    search: this.itemKey,
                    ...data
                },
                (response) => {
                    this.entities = response.data.data;
                    this.paginations = response.data.meta.links;
                }, url);
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
            this.getEntities();
        },
    },

    created() {
        this.getEntities();
    },
};
</script>
