<template>
    <div :class="['fade-video-modal flex-column-direction', mediaObj.show ? 'visible-video-modal' : '']">
        <img :src="iconPath" class="video-cancle-icon" @click="mediaObj.show = false"/>
        <div class="relative-position">
            <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="search"
                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-search b-icon bi search-icon"
                 style="color: rgb(172, 182, 190) !important;">
                <g>
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                </g>
            </svg>
            <input
                type="text"
                class="d-search-input pr-10"
                v-model="itemKey"
                placeholder="جستجو بر روی همه مدیاها"
            />
        </div>
        <div class="d-cards-container d-modal-card-container">
            <dashboard-media-card
                v-for="(media, key) in medias"
                :key="key"
                :card="media"
                @click.native="cardClicked(media)"
            ></dashboard-media-card>
            <h1></h1>
        </div>
    </div>
</template>

<script>

import dashboardMediaCard from '../cards/Dashboard-media-card.vue';

export default {
    components: {
        dashboardMediaCard
    },
    props: ["mediaObj"],
    data() {
        return {
            iconPath: sot.iconPath("gradiant-cancle.svg"),
            medias: [],
            itemKey: '',
        };
    },
    watch: {
        'mediaObj.show'() {
            this.getMedias();
            this.itemKey = '';
        },
        itemKey() {
            this.getMedias();
        }
    },
    methods: {
        cardClicked(media) {
            this.$emit('modalMediaClicked', media)
        },
        getMedias() {
            let data = {
                type: this.mediaObj.type,
                itemKey: this.itemKey,
            }

            axios.post("/admin/media/modal", data).then((response) => {
                this.medias = response.data;
            });
        },
    },
};
</script>

<style scoped>
.d-modal-card-container {
    width: 80vw;
    height: 80vh;
    background: white;
    overflow: auto;
    border-radius: .5rem;
}
</style>
