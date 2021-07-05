<template>
  <div class="d-item-container">
    <div class="d-status-bar flex-end">
      <h3 class="create-media-title">
        ویرایش اتاق
        {{ this.postData.room.name }}
      </h3>
    </div>

    <div class="d-form-container">
      <div class="d-form-row d-form">
        <div class="d-for-group d-flex-25">
          <span class="d-form-lable"> نام اتاق </span>
          <div class="d-form-input">
            <input
              type="text"
              class="d-search-input"
              v-model="postData.room.name"
            />
          </div>
        </div>

        <div class="d-for-group d-flex-25">
          <span class="d-form-lable"> زمان بازی (به دقیقه) </span>
          <div class="d-form-input">
            <input
              type="text"
              class="d-search-input"
              v-model="postData.room.game_time"
            />
          </div>
        </div>

        <div class="d-for-group d-flex-25">
          <span class="d-form-lable"> قیمت (به تومان) </span>
          <div class="d-form-input">
            <input
              type="text"
              class="d-search-input"
              v-model="postData.room.price"
            />
          </div>
        </div>

        <div class="d-for-group d-flex-25">
          <span class="d-form-lable"> درجه سختی </span>
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
          <span class="d-form-lable"> حداقل نفرات </span>
          <div class="d-form-input">
            <input
              type="text"
              class="d-search-input"
              v-model="postData.room.min_person"
            />
          </div>
        </div>

        <div class="d-for-group d-flex-25">
          <span class="d-form-lable"> حداکثر نفرات </span>
          <div class="d-form-input">
            <input
              type="text"
              class="d-search-input"
              v-model="postData.room.max_person"
            />
          </div>
        </div>

        <div class="d-for-group d-flex-25">
          <span class="d-form-lable"> تلفن </span>
          <div class="d-form-input">
            <input
              type="text"
              class="d-search-input"
              v-model="postData.room.phone"
            />
          </div>
        </div>

        <div class="d-for-group d-flex-25">
          <span class="d-form-lable"> موبایل </span>
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
          <span class="d-form-lable"> آدرس </span>
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
            placeholder="یک ژانر انتخاب کنید"
            label="text"
            track-by="id"
            :options="genres"
            :multiple="true"
            :taggable="true"
          ></multiselect>
        </div>
        <div class="d-for-group d-flex-25">
          <span class="d-form-lable"> مجموعه </span>
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
          <span class="d-form-lable"> شهر </span>

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
          <span class="d-form-lable"> محله </span>
          <div class="d-form-input">
            <input
              type="text"
              class="d-search-input"
              placeholder="مثلا : سعادت آباد"
              v-model="postData.room.district"
            />
          </div>
        </div>
      </div>

      <div class="d-form-row d-form">
        <div class="mb-4 d-flex-100">
          <span class="d-form-lable"> توضیحات </span>
          <div class="d-form-input">
            <textarea
              type="text"
              class="d-search-input"
              v-model="postData.room.description"
            >
            </textarea>
          </div>
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
              اتاق ویژه
            </div>
            <div
              :class="[
                'd-special-room',
                postData.room.is_new ? 'selected-checked-item' : '',
              ]"
              @click="postData.room.is_new = postData.room.is_new === 0 ? 1 : 0"
            >
              اتاق جدید
            </div>
            <div
              :class="[
                'd-special-room',
                postData.hasDiscount ? 'selected-checked-item' : '',
              ]"
              @click="postData.hasDiscount = !postData.hasDiscount"
            >
              <div>اتاق تخفیف دار:</div>
            </div>
          </div>
        </div>
      </div>

      <div class="d-form-row d-form flex-start" v-if="postData.hasDiscount">
        <div class="d-for-group d-flex-25">
          <span class="d-form-lable"> مقدار تخفیف </span>
          <div class="d-form-input">
            <input
              type="text"
              class="d-search-input"
              placeholder="به درصد"
              v-model="postData.discount.amount"
            />
          </div>
        </div>

        <div class="d-for-group d-flex-25 mr-4">
          <span class="d-form-lable"> زمان شروع تخفیف </span>
          <div class="d-form-input">
            <vue-persian-datetime-picker
              v-model="postData.discount.started_at"
            ></vue-persian-datetime-picker>
          </div>
        </div>

        <div class="d-for-group d-flex-25 mr-4">
          <span class="d-form-lable"> زمان پایان تخفیف </span>
          <div class="d-form-input">
            <vue-persian-datetime-picker
              v-model="postData.discount.ended_at"
            ></vue-persian-datetime-picker>
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
          <span v-else> انتخاب عکس اصلی </span>
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
          <span v-else> انتخاب عکس بنر </span>
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
          <span v-else> انتخاب ویدئوی تیزر </span>
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
        <div class="d-entity-cta d-make-entity high-order" @click="updateRoom">
          بروزرسانی
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import dropdown from "vue-dropdowns";
import vueselect from "v-select2-component";
import Multiselect from "vue-multiselect";
import MediaModal from "../../packages/Media-modal.vue";
import VuePersianDatetimePicker from "vue-persian-datetime-picker";

export default {
  components: {
    dropdown,
    vueselect,
    MediaModal,
    VuePersianDatetimePicker,
    Multiselect
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
          phone: "",
          mobile: "",
          address: "",
          district: "",
          description: "",
          is_special: 0,
          is_new: 0,
          collection_id: "",
          city_id: "",
        },
        genreIds: [],
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
      fileSelectTex: "انتخاب فایل",
      selectedFile: "",
      backgrounds: {
        front: "",
        banner: "",
      },
    };
  },
  methods: {
    cancelCreatingRoom() {
      this.$router.push({ path: "/rooms" });
    },
    updateRoom() {
      this.postData.genreIds = _.map(this.postData.selectedGenres, "id");
      axios
        .post(`/admin/room/update/${this.postData.room.id}`, this.postData)
        .then((response) => {});
    },
    removeSelectedMedia(mediaOf) {
      let media = this.postData.medias[mediaOf],
        route = `admin/room/detach-media/${media.id}`;

      axios.post(route).then((response) => {});
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

      axios.post(route, media).then((response) => {});
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

  created() {
    this.getDependencies();
    this.getRoom();
  },
};
</script>