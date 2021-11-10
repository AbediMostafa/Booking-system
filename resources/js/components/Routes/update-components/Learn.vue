<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">
                ویرایش آموزش
                {{ postData.learnName }}
            </h3>
        </div>

        <div class="d-form-container">
            <div class="d-form-row d-form d-special-room-container">
                <div class="d-for-group d-flex-30">
                    <span class="d-form-lable"> نام آموزش </span>
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.learn.title"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-70 mr-4">
                    <span class="d-form-lable"> خلاصه </span>
                    <div class="d-form-input">
            <textarea
                type="text"
                class="d-search-input"
                v-model="postData.learn.brief"
            >
            </textarea>
                    </div>
                </div>

                <div
                    :class="[
            'd-special-room',
            'mr-4',
            postData.learn.starred ? 'selected-checked-item' : '',
          ]"
                    @click="postData.learn.starred = postData.learn.starred === 0 ? 1 : 0"
                >
                    آموزش ستاره دار
                </div>
            </div>
            <div class="d-form-row d-form">
                <div class="d-for-group d-flex-25">
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
                <vue-editor v-model="postData.learn.description"></vue-editor>
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
                learnName: "",
                learn: {
                    id: "",
                    title: "",
                    brief: "",
                    description: "",
                    starred: 0,
                    tagIds:[],
                },
                selectedTags:[],
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
            mediaObj: {
                show: false,
                type: "image",
            },
        };
    },
    methods: {
        selectMedia(type){
            this.mediaObj.type = type;
            this.mediaObj.show = true;
        },
        cancelCreatingRoom() {
            this.$router.push({path: "/learns"});
        },
        updateEntity() {
            this.postData.learn.tagIds = _.map(this.postData.selectedTags, 'id');

            axios
                .post(
                    `/admin/learn/update/${this.postData.learn.id}`,
                    this.postData.learn
                );
        },
        removeSelectedMedia(type) {
            let route = `admin/learn/detach-media/${this.postData.learn.id}`;

            axios.post(route, {type}).then((response) => {
                this.postData.medias[type] = {
                    background: "",
                    id: "",
                };
            });
        },

        modalMediaClicked(payload) {
            let media = this.postData.medias[this.mediaObj.type];
            media.background = payload.path;
            media.id = payload.id;

            let route = `admin/learn/${this.postData.learn.id}/attach-media/${payload.id}`;

            axios.post(route, {type:this.mediaObj.type}).then((response) => {
            });
            this.mediaObj.show = false;
        },

        getEntity() {
            axios
                .get(`admin/learn/update/${this.$route.params.id}`)
                .then((response) => {
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
