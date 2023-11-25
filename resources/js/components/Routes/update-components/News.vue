<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">
                {{ postData.newsName }}
            </h3>
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

                <div class="d-for-group mr-4">
                    <span class="d-form-lable">   </span>
                    <multiselect
                        v-model="postData.selectedTags"
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
            <div class="d-form-row d-form">
                <div class="d-each-image-select"
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

                <div class="d-each-image-select" @click="selectMedia('video')">
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
                     cancel
                </div>
                <div
                    class="d-entity-cta d-make-entity high-order"
                    @click="updateEntity"
                >
                     update
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
                newsName: "",
                news: {
                    id: "",
                    title: "",
                    brief: "",
                    description: "",
                    starred: 0,
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
                selectedTags:[]
            },
            trashIcon: sot.iconPath("trash.svg"),
            mediaObj: {
                show: false,
                type: "image",
            },
            tags:[],
        };
    },
    methods: {

        callApi(data, callB = null) {
            axios.post('/news', data).then(response => {
                callB && callB(response);
            })
        },
        selectMedia(type) {
            this.mediaObj.type = type;
            this.mediaObj.show = true;
        },
        cancelCreatingRoom() {
            this.$router.push({path: "/news"});
        },
        updateEntity() {
            this.callApi({
                method: 'actionUpdate',
                ...this.postData.news,
                tagIds:_.map(this.postData.selectedTags, 'id'),
            });
        },
        removeSelectedMedia(type) {

            this.callApi({
                type,
                id: this.postData.news.id,
                method: 'actionDetachMedia'
            }, () =>
                this.postData.medias[type] = {
                    background: "",
                    id: "",
                });
        },

        modalMediaClicked(payload) {
            let media = this.postData.medias[this.mediaObj.type];
            media.background = payload.path;
            media.id = payload.id;

            this.callApi({
                type: this.mediaObj.type,
                id: this.postData.news.id,
                mediaId: payload.id,
                method: 'actionAttachMedia'
            }, () => {
                this.mediaObj.show = false;
            })
        },

        getEntity() {

            let data = {
                method: 'actionGet',
                id: this.$route.params.id
            }

            this.callApi({
                method: 'actionGet',
                id: this.$route.params.id
            }, (response) => {
                this.postData = response.data;

                cc(this.postData);
            });
        },
    },

    computed: {
        getBackground() {
            return `background:url(${this.postData.medias.image.background}) no-repeat center/cover`;
        },

        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        }
    },

    created() {
        this.getEntity();
        this.tags = tags;
    },
};
</script>
