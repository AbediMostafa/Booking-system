<template>
  <div class="d-item-container">
    <div class="d-status-bar flex-end">
      <h3 class="create-media-title">ایجاد اتاق جدید</h3>
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
            <dropdown
              :options="hardness"
              :selected="object"
              @updateOption="selectOption"
            ></dropdown>
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
        <div class="d-for-group d-flex-25">
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
        <div class="d-for-group d-flex-100">
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
        <div class="d-for-group d-flex-100">
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
        <div class="d-entity-cta d-make-entity high-order" @click="createRoom">
          ایجاد
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import dropdown from "vue-dropdowns";
import vueselect from "v-select2-component";
import MediaModal from "../../packages/Media-modal.vue";
import VuePersianDatetimePicker from "vue-persian-datetime-picker";

export default {
  components: {
    dropdown,
    vueselect,
    MediaModal,
    VuePersianDatetimePicker,
  },
  data() {
    return {
      postData: {
        room: {
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
        hasDiscount: false,
        discount: {
          amount: "",
          started_at: "",
          ended_at: "",
        },
        medias: {
          banner: {},
          front: {},
          video: {},
        },
      },
      trashIcon: sot.iconPath("trash.svg"),
      hardness: [
        { name: "1" },
        { name: "2" },
        { name: "3" },
        { name: "4" },
        { name: "5" },
      ],
      mediaObj: {
        show: false,
        type: "",
        place: "",
      },
      collections: [],
      cities: [],
      object: {
        name: "انتخاب کنید",
      },
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
      this.$router.push({path:'/rooms'})
    },
    createRoom() {
      axios.post("/admin/room/store", this.postData).then((response) => {
        setTimeout(() => {
          this.$router.push({path:'/rooms'})
        }, 2000);
      });
    },
    removeSelectedMedia(mediaOf) {
      this.postData.medias[mediaOf] = {};
    },
    getBackground(background) {
      if (!background) {
        return;
      }

      return `background:url(${background}) no-repeat center/cover`;
    },
    modalMediaClicked(payload) {
      this.$set(
        this.postData.medias[this.mediaObj.place],
        "background",
        payload.path
      );
      this.$set(this.postData.medias[this.mediaObj.place], "id", payload.id);
      this.$set(
        this.postData.medias[this.mediaObj.place],
        "type",
        this.mediaObj.type
      );
      this.$set(
        this.postData.medias[this.mediaObj.place],
        "place",
        this.mediaObj.place
      );
      this.mediaObj.show = false;
    },
    selectMedia(place, type) {
      this.mediaObj.place = place;
      this.mediaObj.type = type;
      this.mediaObj.show = true;
    },
    selectOption(payload) {
      this.object = payload;
      this.postData.room.hardness = payload.name;
    },
  },

  computed: {
    bannerBack() {
      return this.backgrounds.front
        ? `background:url(${this.backgrounds.front}) no-repeat center/cover`
        : "";
    },
  },

  created() {
    axios.post("admin/room/dependencies").then((response) => {
      this.collections = response.data.collections;
      this.cities = response.data.cities;
    });
  },
};
</script>

<style scoped>
.flex-start{
  justify-content: flex-start!important;
}

.flex-end {
  justify-content: flex-end;
}
.d-form-container {
  padding: 1.5rem;
  text-align: right;
  font-size: 0.9rem;
  color: var(--second-color);
  margin: 2rem 0;
}
#file-input {
  display: none;
}

.df-media-for-container {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  flex-wrap: wrap;
}

.btn-group {
  margin: 0;
}

.high-order {
  order: 1;
}

.low-order {
  order: 2;
}

.d-input-label {
  flex: 0 0 7rem;
}

.create-media-title {
  margin: 0.5rem;
  color: var(--second-color);
}

.d-form-row {
  margin-bottom: 2rem;
}

.d-form {
  display: flex;
  align-items: center;
  justify-content: space-between;
  direction: rtl;
  flex-wrap: wrap;
}

.d-search-input::placeholder {
  color: #a7b0b9;
  font-size: 0.8rem;
  font-weight: normal;
}

.d-search-input {
  border: 1px solid #dcdee1;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  width: 100%;
  text-align: right;
}

.d-flex-24 {
  flex: 0 0 24%;
}
.d-flex-50 {
  flex: 0 0 calc(50% - 1rem);
}

.d-flex-25 {
  flex: 0 0 calc(25% - 1rem);
}

.d-flex-75 {
  flex: 0 0 calc(75% - 1rem);
}

.d-flex-100 {
  flex: 0 0 100%;
}

.d-form-lable,
.dropdown-toggle {
  color: #666c71;
  font-size: 0.8rem;
}

.d-each-image-select:hover {
  background: #f4f4f4;
}

.d-each-image-select {
  flex: 0 0 calc(33% - 0.7rem);
  height: 12rem;
  border: 1px dashed #9398a0;
  font-size: 0.8rem;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #666c71;
  border-radius: 0.5rem;
  cursor: pointer;
  transition: all 300ms;
  position: relative;
}

.d-special-room-container {
  display: flex;
  align-items: center;
  justify-content: flex-start;
}

.d-special-room {
  padding: 1rem 2rem;
  border: 1px dotted #9398a0;
  border-radius: 0.5rem;
  flex: 0 0 10rem;
  text-align: center;
  margin: 0 0 0.5rem 0.5rem;
  cursor: pointer;
}

@media screen and (min-width: 480px) {
  .low-order,
  .high-order {
    order: initial;
  }
}
</style>