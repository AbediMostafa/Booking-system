<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div class="d-status-bar flex-end">
        </div>

        <div class="d-form-container">
            <div class="d-form-row d-form d-special-room-container">
                <div class="d-for-group d-flex-30">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.news.title"
                        />
                    </div>
                </div>

                <!--  brief-->
                <div class="d-for-group d-flex-70 mr-4">
                    <div class="d-form-input">
                        <textarea
                            type="text"
                            class="d-search-input"
                            v-model="postData.news.brief"
                        >
                        </textarea>
                    </div>
                </div>

                <div class="d-for-group mr-4">
                    <div class="d-form-input">
                        <input
                            type="number"
                            class="d-search-input"
                            v-model="postData.news.news_order"
                        />
                    </div>
                </div>

                <div class="d-for-group">
                    <multiselect
                        v-model="selectedTags"
                        :options="tags"
                        label="name"
                        :show-labels="false"
                        :close-on-select="false"
                        track-by="id"
                        :multiple="true"
                        :taggable="true"
                    ></multiselect>
                </div>

            </div>

            <div class="d-form-row d-form">
                <vue-editor v-model="postData.news.description"></vue-editor>
            </div>
            <div class="d-form-row d-form justify-content-start">
                <div
                    class="d-each-image-select"
                    @click="selectMedia('image')"
                    :style="getBackground"
                >
                    <img
                        :src="trashIcon"
                        v-if="postData.medias.image.background"
                        class="shadowed-icon"
                        @click.stop="removeSelectedMedia('image')"
                    />
                </div>

                <div class="d-each-image-select mr-4" @click="selectMedia('video')">
                    <div v-if="postData.medias.video.background">
                        <img
                            :src="trashIcon"
                            class="shadowed-icon"
                            @click.stop="removeSelectedMedia('video')"
                        />
                        <video controls>
                            <source
                                :src="postData.medias.video.background"
                                type="video/mp4"
                            />
                            <source
                                :src="postData.medias.video.background"
                                type="video/ogg"
                            />
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>

            <media-modal
                :media-obj="mediaObj"
                @modalMediaClicked="modalMediaClicked"
            ></media-modal>

            <div class="d-create-entity-container">
                <div
                    class="d-entity-cta d-cancel-entity low-order"
                    @click="cancelCreatingRoom"
                >
                </div>
                <div
                    class="d-entity-cta d-make-entity high-order"
                    @click="createEntity"
                >
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-danger" v-else>
    </div>

</template>

<script>
import MediaModal from "../../packages/Media-modal.vue";
import {VueEditor} from "vue2-editor";
import Multiselect from "vue-multiselect";


export default {
    components: {
        MediaModal,
        VueEditor,
        Multiselect
    },
    data() {
        return {
            postData: {
                news: {
                    title: "",
                    brief: "",
                    description: "",
                    news_order: '',
                },
                medias: {
                    video: {
                        background: "",
                        id: "",
                    },
                    image: {
                        background: "",
                        id: "",
                    },
                },
            },
            trashIcon: sot.iconPath("trash.svg"),
            tags:[],
            selectedTags:[],
            mediaObj: {
                show: false,
                type: "image",
            },
        };
    },
    methods: {
        selectMedia(type) {
            this.mediaObj.type = type;
            this.mediaObj.show = true;
        },
        cancelCreatingRoom() {
            this.$router.push({path: "/news"});
        },
        createEntity() {
            let data = {
                ...this.postData,
                method: 'actionCreateNews',
                tagIds:_.map(this.selectedTags, 'id')
            }
            axios.post(`/news`, data).then((response) => {
            });
        },
        removeSelectedMedia(type) {
            this.postData.medias[type] = {
                background: "",
                id: "",
            };
        },

        modalMediaClicked(payload) {

            this.postData.medias[this.mediaObj.type] = {
                background: payload.path,
                id: payload.id
            }

            this.mediaObj.show = false;
        },
    },

    computed: {
        getBackground() {
            return `background:url(${this.postData.medias.image.background}) no-repeat center/cover`;
        },

        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        },

    },
    created() {
        this.tags = tags;
    }
};
</script>
