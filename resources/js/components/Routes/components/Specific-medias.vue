<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">مدیاهای خاص</h3>
        </div>
        <div class="d-form-container">
            <!--            <div class="sm-row">-->
            <!--                <div-->
            <!--                    class="d-each-image-select sm-image-placeholder"-->
            <!--                    @click="selectStaticMedia('first_page_video', 'video')"-->
            <!--                >-->
            <!--                    <div v-if="postData.staticMedias.first_page_video.background">-->
            <!--                        <img-->
            <!--                            :src="trashIcon"-->
            <!--                            class="shadowed-icon"-->
            <!--                            @click.stop="removeSelectedStaticMedia('first_page_video')"-->
            <!--                        />-->
            <!--                        <video-->
            <!--                            controls-->
            <!--                            style="height: 12rem"-->
            <!--                            :key="postData.staticMedias.first_page_video.background"-->
            <!--                        >-->
            <!--                            <source-->
            <!--                                :src="postData.staticMedias.first_page_video.background"-->
            <!--                                type="video/mp4"-->
            <!--                            />-->
            <!--                            <source-->
            <!--                                :src="postData.staticMedias.first_page_video.background"-->
            <!--                                type="video/ogg"-->
            <!--                            />-->
            <!--                            Your browser does not support the video tag.-->
            <!--                        </video>-->
            <!--                    </div>-->

            <!--                    <span v-else> ویدئوی صفحه اول </span>-->
            <!--                </div>-->
            <!--                <div class="sm-lable">ویدئوی صفحه اول</div>-->
            <!--            </div>-->
            <div class="sm-row">
                <div
                    class="d-each-image-select sm-image-placeholder"
                    @click="selectStaticMedia('first_page_full_image', 'image')"
                    :style="
            getBackground(
              postData.staticMedias.first_page_full_image.background
            )
          "
                >
                    <img
                        :src="trashIcon"
                        v-if="postData.staticMedias.first_page_full_image.background"
                        class="shadowed-icon"
                        @click.stop="removeSelectedStaticMedia('first_page_full_image')"
                    />
                    <span v-else> عکس تمام صفحه </span>
                </div>
                <div class="sm-lable">عکس تمام صفحه</div>
            </div>
            <div class="sm-row">
                <div
                    class="d-each-image-select sm-image-placeholder"
                    @click="selectStaticMedia('first_page_full_video', 'video')"
                >
                    <div v-if="postData.staticMedias.first_page_full_video.background">
                        <img
                            :src="trashIcon"
                            class="shadowed-icon"
                            @click.stop="removeSelectedStaticMedia('first_page_full_video')"
                        />
                        <video
                            controls
                            style="height: 12rem"
                            :key="postData.staticMedias.first_page_full_video.background"
                        >
                            <source
                                :src="postData.staticMedias.first_page_full_video.background"
                                type="video/mp4"
                            />
                            <source
                                :src="postData.staticMedias.first_page_full_video.background"
                                type="video/ogg"
                            />
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <span v-else> ویدئوی تمام صفحه </span>
                </div>
                <div class="sm-lable">ویدئوی تمام صفحه</div>
            </div>

            <!--  Main slider-->
            <hr>
            <h3 class="mb-4">اسلایدر اصلی</h3>
            <div
                class="sm-row"
                v-for="(dynamicMedia, key) in postData.heroSlider"
                :key="key"
            >
                <div
                    class="d-entity-cta d-make-entity high-order"
                    @click="createDynamicMedia(key, 'hero_slider')"
                >
                    ایجاد
                </div>

                <div class="width-10">
                    <span class="d-form-lable"> اتاق </span>
                    <div class="d-form-input">
                        <vueselect
                            name="select1"
                            :options="rooms"
                            :searchable="true"
                            v-model="dynamicMedia.roomId"
                        >
                        </vueselect>
                    </div>
                </div>
                <div
                    class="d-each-image-select sm-image-placeholder"
                    @click="selectDynamicMedia(key, 'image','hero_slider')"
                    :style="getBackground(dynamicMedia.background)"
                >
                    <img
                        :src="trashIcon"
                        class="shadowed-icon"
                        @click.stop="removeDynamicMedia(key, 'hero_slider')"
                    />
                    <span
                        v-if="!getBackground(dynamicMedia.background)"
                    >
                      عکس اسلایدر
                    </span>
                </div>
                <div class="sm-lable">عکس اسلایدر</div>
            </div>

            <div class="sm-row">
                <div class="add-dynamic-media-holder" @click="addDynamicMedia('hero_slider')">
                    <img :src="iconPath('grey-add.svg')" class="small-icon mr-2"/>
                    <span>اضافه کردن اسلایدر جدید</span>
                </div>
            </div>

            <!--  Our suggestion slider -->
            <hr>
            <h3 class="mb-4">اسلایدر پیشنهاد ما</h3>
            <div
                class="sm-row"
                v-for="(dynamicMedia, key) in postData.ourSuggestionSlider"
                :key="key"
            >
                <div
                    class="d-entity-cta d-make-entity high-order"
                    @click="createDynamicMedia(key, 'banner_slider')"
                >
                    ایجاد
                </div>

                <div class="width-10">
                    <span class="d-form-lable"> اتاق </span>
                    <div class="d-form-input">
                        <vueselect
                            name="select1"
                            :options="rooms"
                            :searchable="true"
                            v-model="dynamicMedia.roomId"
                        >
                        </vueselect>
                    </div>
                </div>
                <div
                    class="d-each-image-select sm-image-placeholder"
                    @click="selectDynamicMedia(key, 'image', 'banner_slider')"
                    :style="getBackground(dynamicMedia.background)"
                >
                    <img
                        :src="trashIcon"
                        class="shadowed-icon"
                        @click.stop="removeDynamicMedia(key, 'banner_slider')"
                    />
                    <span
                        v-if="!getBackground(dynamicMedia.background)"
                    >
                      عکس اسلایدر
                    </span>
                </div>
                <div class="sm-lable">عکس اسلایدر</div>
            </div>

            <div class="sm-row">
                <div class="add-dynamic-media-holder" @click="addDynamicMedia('banner_slider')">
                    <img :src="iconPath('grey-add.svg')" class="small-icon mr-2"/>
                    <span>اضافه کردن اسلایدر جدید</span>
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
            </div>
        </div>
    </div>

    <div class="alert alert-danger" v-else>
        شما اجازه دسترسی به این صفحه را ندارید
    </div>
</template>

<script>
import vueselect from "v-select2-component";
import MediaModal from "../../packages/Media-modal.vue";

export default {
    components: {
        vueselect,
        MediaModal,
    },
    data() {
        return {
            postData: {
                staticMedias: {
                    first_page_video: {
                        id: "",
                        background: "",
                        sm_id: "",
                    },
                    first_page_full_image: {
                        id: "",
                        background: "",
                        sm_id: "",
                    },
                    first_page_full_video: {
                        id: "",
                        background: "",
                        sm_id: "",
                    },
                },

                ourSuggestionSlider: [],
                heroSlider: [],
            },
            selectedMedia: {
                type: "static",
                key: "",
            },
            rooms: [],
            trashIcon: sot.iconPath("trash.svg"),
            mediaObj: {
                show: false,
                type: "",
            },
        };
    },
    methods: {
        cancelCreatingRoom() {
            this.$router.push({path: "/rooms"});
        },
        lunchModal(type) {
            this.mediaObj.type = type;
            this.mediaObj.show = true;
        },
        selectStaticMedia(media, type) {
            this.selectedMedia.type = "static";
            this.selectedMedia.key = media;
            this.lunchModal(type);
        },
        selectDynamicMedia(key, type, place) {
            this.selectedMedia.type = `dynamic_${place}`;
            this.selectedMedia.key = key;
            this.lunchModal(type);
        },
        modalMediaClicked(payload) {
            let sm = "";
            if (this.selectedMedia.type === "static") {
                sm = this.postData.staticMedias[this.selectedMedia.key];
                let route = `admin/specific-medias/${sm.sm_id}/attach-media/${payload.id}`;
                axios
                    .post(route, {type: this.mediaObj.type})
                    .then((response) => {
                    });
            } else {
                sm = this.selectedMedia.type === 'dynamic_hero_slider' ?
                    this.postData.heroSlider[this.selectedMedia.key] :
                    this.postData.ourSuggestionSlider[this.selectedMedia.key];
            }

            sm.id = payload.id;
            sm.background = payload.path;
            this.mediaObj.show = false;
        },
        createDynamicMedia(key, place) {

            let sm = place === 'hero_slider' ?
                this.postData.heroSlider[key] :
                this.postData.ourSuggestionSlider[key],

                route = sm.sm_id ?
                    `admin/specific-medias/${sm.sm_id}/attach-dynamic-media/${sm.id}` :
                    `admin/specific-medias/attach-media/${sm.id}`;

            let data = {
                roomId: sm.roomId,
                place
            }

            axios
                .post(route, data)
                .then((response) => {
                    sm.sm_id = response.data.sm_id;
                });
        },
        removeDynamicMedia(key, place) {
            let sm = place === 'hero_slider' ?
                this.postData.heroSlider :
                this.postData.ourSuggestionSlider,
            smId = sm[key].sm_id;

            smId && axios.post(`/admin/specific-medias/detach-dynamic-media/${smId}`)

            sm.splice(key, 1);
        },
        removeSelectedStaticMedia(type) {
            axios
                .post(
                    `/admin/specific-medias/detach-static-media/${this.postData.staticMedias[type].sm_id}`
                )
                .then((response) => {
                    this.postData.staticMedias[type].id = "";
                    this.postData.staticMedias[type].background = "";
                });
        },
        addDynamicMedia(place) {
            let slider = place === 'banner_slider' ?
                this.postData.ourSuggestionSlider :
                this.postData.heroSlider;

            this.$set(slider, slider.length,
                {
                    id: "",
                    background: "",
                    sm_id: '',
                    roomId: ''
                });
        },
        iconPath(icon) {
            return sot.iconPath(icon);
        },
        getBackground(background) {
            if (!background) {
                return;
            }

            return `background:url(${background}) no-repeat center/cover`;
        },
        getMedias() {
            axios.post("/admin/specific-medias/get-medias").then((response) => {
                this.postData = response.data.data;
            });
        },
        getRooms() {
            axios.post("/admin/room/room-dependency").then((response) => {
                this.rooms = response.data;
            });
        }
    },

    computed: {
        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        }
    },

    created() {
        this.getMedias();
        this.getRooms();
    },
};
</script>

<style scoped>

.width-10 {
    width: 10rem;
    margin-right: 1rem;
    margin-bottom: .5rem;
}

.sm-lable {
    text-align: right;
    font-size: 0.9rem;
    color: var(--second-color);
    font-weight: NORMAL;
    flex: 0 0 10rem;
}

.sm-image-placeholder {
    flex: 0 0 15rem !important;
}
</style>
