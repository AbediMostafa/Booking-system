<template>
    <div class="d-item-container">

        <div class="d-status-bar">
            <div class="search-container">
                <img :src="iconPath('search1.svg')" class="search-icon"/>
                <input
                    type="text"
                    class="d-search-input pr-10"
                    v-model="itemKey"
                    placeholder="جستجو بر روی اتاق ها"
                />
            </div>
        </div>
        <div class="d-second-status-bar" v-if="userIsManager">
            <div class="d-type-filter-container">
                <ul class="d-inner-type-filter">
                    <li
                        @click="itemTypeClicked('allComments')"
                        :class="[commentType === 'allComments' ? 'clicked-d-inner-filter' : '']"
                    >
                        همه کامنت ها
                    </li>
                    <li
                        @click="itemTypeClicked('unApproved')"
                        :class="[commentType ==='unApproved' ? 'clicked-d-inner-filter' : '']"
                    >
                        تایید نشده ها
                    </li>
                </ul>
            </div>

            <div v-if="selectedEntities.length" class="flex-center">
                <div class="d-delete-items-cta" @click="deleteEntities">
                    حذف کامنت ها
                </div>

                <div v-if="commentType ==='unApproved'" class="d-delete-items-cta d-grant-cta" @click="grantEntities">
                    دادن مجوز
                </div>
            </div>
        </div>

        <div class="d-cards-container">
            <comment
                v-for="(entity, key) in entities"
                :key="key"
                :comment="entity"
                :rates="rates"
                :class="[
          'pointer',
          selectedEntities.includes(entity.id) ? 'selected-checked-item' : '',
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
import Comment from "../../cards/admin-comment";
import axios from "axios";

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
            rates: [],
            commentType: 'allComments',
            allComments: false,
            unApproved: false,
            itemKey: "",
        };
    },
    methods: {
        itemTypeClicked(type) {
            this.commentType = type
            this.selectedEntities = [];
            this.itemKey = '';
            this.getEntities("/admin/comment", {commentType: this.commentType});
        },
        grantEntities() {
            axios
                .post("/admin/comment/grant", {comments: this.selectedEntities})
                .then((response) => {
                    this.getEntities("/admin/comment", {commentType: this.commentType});
                    this.selectedEntities = [];
                });
        },
        deleteEntities() {
            axios
                .post("/admin/comment/delete", {comments: this.selectedEntities})
                .then((response) => {
                    this.getEntities("/admin/comment", {commentType: this.commentType});
                    this.selectedEntities = [];
                });
        },

        cardClicked(entity) {

            if (!this.userIsManager) return;

            if (this.selectedEntities.includes(entity.id)) {
                this.selectedEntities = _.without(this.selectedEntities, entity.id);
            } else {
                this.selectedEntities.push(entity.id);
            }
        },
        getEntities(url = "/admin/comment") {

            let data = {search: this.itemKey, commentType: this.commentType}
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
        userIsManager() {
            return user.type === 'admin' || user.type === 'manager';
        },
    },

    watch: {
        itemKey() {
            this.getEntities();
        },
    },

    created() {
        this.getEntities();
        axios.post('/site-vars/rate-titles').then(response => {
            this.rates = response.data;
        });
    },
};
</script>

<style scoped>

.d-inner-type-filter li {
    width: 6.5rem;
    font-size: 0.75rem;
}

.pointer {
    cursor: pointer;
}

.d-grant-cta {
    background: #65a856;
}
</style>
