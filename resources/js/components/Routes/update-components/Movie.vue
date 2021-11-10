<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">
                ویرایش فیلم
                {{ postData.movieName }}
            </h3>
        </div>

        <div class="d-form-container">
            <div class="d-form-row d-form d-special-room-container">
                <div class="d-for-group d-flex-30">
                    <span class="d-form-lable"> نام فیلم </span>
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.movie.title"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-70 mr-4">
                    <span class="d-form-lable"> خلاصه </span>
                    <div class="d-form-input">
                        <textarea
                            type="text"
                            class="d-search-input"
                            v-model="postData.movie.brief"
                        >
                        </textarea>
                    </div>
                </div>

                <div class="d-for-group mr-4">
                    <span class="d-form-lable"> ترتیب نمایش </span>
                    <div class="d-form-input">
                        <input
                            type="number"
                            class="d-search-input"
                            v-model="postData.movie.movie_order"
                        />
                    </div>
                </div>

                <div class="d-for-group mr-4">
                    <span class="d-form-lable">تگ</span>
                    <multiselect
                        v-model="postData.selectedTags"
                        placeholder="یک تگ انتخاب کنید"
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
                <vue-editor v-model="postData.movie.description"></vue-editor>
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
                    <span v-else> انتخاب عکس</span>
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
                    <span v-else> انتخاب ویدئو </span>
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
                    انصراف
                </div>
                <div
                    class="d-entity-cta d-make-entity high-order"
                    @click="updateEntity"
                >
                    بروزرسانی
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-danger" v-else>
        شما اجازه دسترسی به این صفحه را ندارید
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
                movieName: "",
                movie: {
                    id: "",
                    title: "",
                    brief: "",
                    description: "",
                    movie_order:""
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
            tags:[],
            mediaObj: {
                show: false,
                type: "image",
            },
        };
    },
    methods: {

        callApi(data, callB = null) {
            axios.post('/movies', data).then(response => {
                callB && callB(response);
            })
        },
        selectMedia(type) {
            this.mediaObj.type = type;
            this.mediaObj.show = true;
        },
        cancelCreatingRoom() {
            this.$router.push({path: "/movies"});
        },
        updateEntity() {
            this.callApi({
                method: 'actionUpdate',
                tagIds:_.map(this.postData.selectedTags, 'id'),
                ...this.postData.movie
            });
        },
        removeSelectedMedia(type) {

            this.callApi({
                type,
                id: this.postData.movie.id,
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
                id: this.postData.movie.id,
                mediaId: payload.id,
                method: 'actionAttachMedia'
            }, () => {
                this.mediaObj.show = false;
            })
        },

        getEntity() {

            this.callApi({
                method: 'actionGet',
                id: this.$route.params.id
            }, (response) => {
                this.postData = response.data;
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
