<template>
    <div class="learning-container">
        <div class="header-and-cta custom-header-cta">
            <div class="search-header-section" v-scrollAnimation="enterAnimations.topAnimation">
                <div class="title-icon">
                    <h1>{{ searchData ? searchData.title:'' }}</h1>
                </div>
                <p class="header-text">
                    {{ searchData ? searchData.text:'' }}
                </p>
            </div>
            <div class="search-room-cotainer">
                <Multiselect
                    v-model="selectedRooms"
                    :max-height="2000"
                    :options="rooms"
                    id="ajax"
                    placeholder="جستجو بر روی همه اتاق ها"
                    :searchable="true"
                    :loading="isLoading"
                    open-direction="bottom"
                    :internal-search="false"
                    :clear-on-select="false"
                    :close-on-select="false"
                    :limit="5"
                    @search-change="asyncFind"
                    @select="goToRoomsPage"
                    selectLabel=""
                >
                    <template slot="option" slot-scope="props">
                        <div class="option__desc">
                            <div class="option__title">{{ props.option.name }}</div>
                            <div class="option__small">{{ props.option.district }}</div>
                        </div>
                        <img class="option__image" :src="props.option.image" :alt="props.option.name">
                    </template>

                    <template slot="noOptions">هیچ اتاقی پیدا نشد</template>
                    <span slot="noResult">هیچ اتاقی پیدا نشد</span>
                    <span slot="deselectLabel">  </span>
                </Multiselect>
            </div>

            <div class="text-center">
                <a class="cta main-cta learning-cta" href="/rooms">
                    {{ searchData ? searchData.button:'' }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import SectionHeader from "../packages/Section-header.vue";
import Multiselect from "vue-multiselect";

export default {
    props: ['searchData'],

    components: {
        Multiselect,
        SectionHeader,
    },
    data() {
        return {
            enterAnimations: sot.enterAnimations,
            rooms: [],
            selectedRooms: [],
            isLoading: false,
        };
    },

    methods: {
        asyncFind(query) {
            this.isLoading = true;
            axios.post('/rooms/landing/search', {query}).then(response => {
                this.isLoading = false;
                this.rooms = response.data.data;
            });
        },

        goToRoomsPage(room) {
            location.href = `rooms/${room.id}`
        }
    },
};
</script>
