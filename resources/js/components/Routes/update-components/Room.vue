<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">
                {{ this.postData.room.name }}
            </h3>
        </div>

        <div class="d-form-container">
            <div class="d-form-row d-form">
                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.room.name"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.room.game_time"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.room.price"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <vueselect
                            class="vue-select1"
                            name="hardness"
                            :options="hardness"
                            v-model="postData.room.hardness"
                        >
                        </vueselect>
                    </div>
                </div>
            </div>

            <div class="d-form-row d-form">
                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.room.min_person"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.room.max_person"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.room.phone"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.room.mobile"
                        />
                    </div>
                </div>
            </div>

            <div class="d-form-row d-form">
                <div class="d-flex-100">
                    <div class="d-form-input">
            <textarea
                type="text"
                class="d-search-input"
                v-model="postData.room.address"
            >
            </textarea>
                    </div>
                </div>
            </div>
            <div class="d-form-row d-form">
                <div class="d-for-group d-flex-25">
                    <multiselect
                        v-model="postData.selectedGenres"
                        label="text"
                        track-by="id"
                        :options="genres"
                        :show-labels="false"
                        :close-on-select="false"
                        :multiple="true"
                        :taggable="true"
                    ></multiselect>
                </div>
                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <vueselect
                            name="select1"
                            :options="collections"
                            :searchable="true"
                            v-model="postData.room.collection_id"
                        >
                        </vueselect>
                    </div>
                </div>

                <div class="d-for-group d-flex-25">

                    <vueselect
                        class="vue-select1"
                        name="select1"
                        :options="cities"
                        :searchable="true"
                        v-model="postData.room.city_id"
                    >
                    </vueselect>
                </div>

                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.room.district"
                        />
                    </div>
                </div>
            </div>

            <div class="d-form-row d-form">
                <div class="px-1 col-12 col-lg-3 col-md-6">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.room.min_age"
                        />
                    </div>
                </div>
                <div class="px-1 col-12 col-lg-3 col-md-6">
                    <multiselect
                        v-model="postData.hour_type"
                        :options="hourTypes"
                        :searchable="false"
                        label="text"
                        track-by="id"
                        :close-on-select="true"
                        placeholder="">
                    </multiselect>
                </div>
                <div class="px-1 col-12 col-lg-3 col-md-6">
                    <multiselect
                        v-model="postData.holiday_type"
                        :options="holidayTypes"
                        label="text"
                        track-by="id"
                        :searchable="false"
                        :close-on-select="true"
                    </multiselect>
                </div>
                <div class="px-1 col-12 col-lg-3 col-md-6">
                    <input
                        type="text"
                        class="d-search-input"
                        v-model="postData.room.ticket_count"
                    />
                </div>


            </div>


            <div class="d-form-row d-form">
                <div class="mb-4 d-flex-100">
                    <div class="d-form-input">
            <textarea
                type="text"
                rows="7"
                class="d-search-input"
                v-model="postData.room.description"
            >
            </textarea>
                    </div>
                </div>
            </div>

            <div class="d-form-row d-form">
                <div class="mb-4 d-flex-100">
                    <div class="d-form-input">
            <textarea
                type="text"
                class="d-search-input"
                rows="3"
                v-model="postData.room.short_description"
            >
            </textarea>
                    </div>
                </div>
            </div>

            <div class="d-form-row d-form">
                <div class="mb-4 d-flex-100">
                    <div class="short-description mr-6">
                        <img src="/images/icons/blue-grey-check.svg" class="ml-2 header-room-icons">
                        <span>
                  </span>
                    </div>
                    <iframe width="100%" class="height-30"
                            :src="`https://map.ir/lat/${postData.room.lat}/lng/${postData.room.lon}/z/14`"></iframe>
                </div>
            </div>

            <div class="d-form-row d-form">
                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.room.lat"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.room.lon"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.room.room_order"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-25">
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
                <div class="d-flex-100">
                    <div class="d-special-room-container">
                        <div
                            :class="[
                'd-special-room',
                postData.room.is_special ? 'selected-checked-item' : '',
              ]"
                            @click="
                postData.room.is_special =
                  postData.room.is_special === 0 ? 1 : 0
              "
                        >
                        </div>
                        <div
                            :class="[
                'd-special-room',
                postData.room.is_new ? 'selected-checked-item' : '',
              ]"
                            @click="postData.room.is_new = postData.room.is_new === 0 ? 1 : 0"
                        >
                        </div>
                        <div
                            :class="[
                'd-special-room',
                postData.hasDiscount ? 'selected-checked-item' : '',
              ]"
                            @click="postData.hasDiscount = !postData.hasDiscount"
                        >
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-form-row d-form flex-start" v-if="postData.hasDiscount">
                <div class="d-for-group d-flex-25">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.discount.amount"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-25 mr-4">
                    <div class="d-form-input">
                    </div>
                </div>

                <div class="d-for-group d-flex-25 mr-4">
                    <div class="d-form-input">
                    </div>
                </div>
            </div>

            <div class="d-form-row d-form">
                <div
                    class="d-each-image-select"
                    @click="selectMedia('front', 'image')"
                    :style="getBackground(postData.medias.front.background)"
                >
                    <img
                        :src="trashIcon"
                        v-if="postData.medias.front.background"
                        class="shadowed-icon"
                        @click.stop="removeSelectedMedia('front')"
                    />
                </div>
                <div
                    class="d-each-image-select"
                    @click="selectMedia('banner', 'image')"
                    :style="getBackground(postData.medias.banner.background)"
                >
                    <img
                        :src="trashIcon"
                        class="shadowed-icon"
                        v-if="postData.medias.banner.background"
                        @click.stop="removeSelectedMedia('banner')"
                    />
                </div>
                <div class="d-each-image-select" @click="selectMedia('video', 'video')">
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
                <div class="d-entity-cta d-make-entity high-order" @click="updateRoom">
                     update
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-danger" v-else>

    </div>

</template>

<script>
import dropdown from "vue-dropdowns";
import vueselect from "v-select2-component";
import Multiselect from "vue-multiselect";
import MediaModal from "../../packages/Media-modal.vue";
import moment from 'moment-jalaali';

export default {
    components: {
        dropdown,
        vueselect,
        MediaModal,
        Multiselect,
    },
    data() {
        return {
            postData: {
                room: {
                    id: "",
                    name: "",
                    game_time: "",
                    price: "",
                    hardness: "",
                    min_person: "",
                    max_person: "",
                    min_age: "",
                    lat: "",
                    lon: "",
                    room_order: "",
                    phone: "",
                    mobile: "",
                    address: "",
                    district: "",
                    description: "",
                    short_description: "",
                    is_special: 0,
                    is_new: 0,
                    collection_id: "",
                    city_id: "",
                    hour_type_id: "",
                    holiday_type_id: "",
                    ticket_count:'',
                },
                hour_type: {},
                holiday_type: {},

                genreIds: [],
                tagIds:[],
                selectedTags:[],
                selectedGenres: [],
                hasDiscount: false,
                discount: {
                    amount: "",
                    started_at: "",
                    ended_at: "",
                },
                medias: {
                    banner: {
                        background: "",
                        id: "",
                        place: "",
                        type: "",
                    },
                    front: {
                        background: "",
                        id: "",
                        place: "",
                        type: "",
                    },
                    video: {
                        background: "",
                        id: "",
                        place: "",
                        type: "",
                    },
                },
            },
            hardness: [1, 2, 3, 4, 5],
            trashIcon: sot.iconPath("trash.svg"),
            mediaObj: {
                show: false,
                type: "",
                place: "",
            },
            collections: [],
            cities: [],
            genres: [],
            tags:[],
            hourTypes: [],
            holidayTypes: [],
            selectedFile: "",
            backgrounds: {
                front: "",
                banner: "",
            },
        };
    },
    methods: {


        cancelCreatingRoom() {
            this.$router.push({path: "/rooms"});
        },
        updateRoom() {

            this.postData.genreIds = _.map(this.postData.selectedGenres, "id");
            this.postData.tagIds = _.map(this.postData.selectedTags, "id");


            //~~ (*) holiday_type_id is an object like {name:foo, id:1} and we need id only
            this.postData.room.holiday_type_id = this.postData.holiday_type.id
            //~~ (*)
            this.postData.room.hour_type_id = this.postData.hour_type.id

            cc(this.postData);

            axios
                .post(`/admin/room/update/${this.postData.room.id}`, this.postData)
                .then((response) => {
                });
        },
        removeSelectedMedia(mediaOf) {
            let route = `admin/room/detach-media/${this.postData.room.id}`;

            axios.post(route, {type: mediaOf}).then((response) => {
            });
            this.postData.medias[mediaOf] = {
                background: "",
                id: "",
                place: "",
                type: "",
            };
        },
        getBackground(background) {
            if (!background) {
                return;
            }

            return `background:url(${background}) no-repeat center/cover`;
        },
        modalMediaClicked(payload) {
            let media = this.postData.medias[this.mediaObj.place];
            media.background = payload.path;
            media.id = payload.id;
            media.type = this.mediaObj.type;
            media.place = this.mediaObj.place;

            let route = `admin/room/${this.postData.room.id}/attach-media/${payload.id}`;

            axios.post(route, media).then((response) => {
            });
            this.mediaObj.show = false;
        },
        selectMedia(place, type) {
            this.mediaObj.place = place;
            this.mediaObj.type = type;
            this.mediaObj.show = true;
        },

        getDependencies() {
            axios.post("admin/room/dependencies").then((response) => {
                this.collections = response.data.collections;
                this.cities = response.data.cities;
                this.genres = response.data.genres;
                this.hourTypes = response.data.hourTypes;
                this.holidayTypes = response.data.holidayTypes;
                this.tags = tags;
            });
        },

        getRoom() {
            axios
                .get(`admin/room/update/${this.$route.params.id}`)
                .then((response) => {
                    this.postData = response.data.data;
                });
        },
    },
    computed:{
        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        }
    },

    created() {
        this.getDependencies();
        this.getRoom();
    },

};
</script>

<style src="bootstrap/dist/css/bootstrap.css">

</style>
