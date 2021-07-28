<template>
  <div class="d-item-container">
    <div class="d-status-bar flex-end">
      <h3 class="create-media-title">مدیریت متغیرهای سایت</h3>
    </div>

    <div class="d-form-container">
      <div class="sv-form-row">
        <div
          class="sv-form-group d-each-image-select"
          @click="selectMedia('first_page_header_title_1', 'image')"
          :style="getBackground('first_page_header_title_1')"
        >
          <img
            :src="trashIcon"
            class="shadowed-icon"
            v-if="withMediaVarImages.first_page_header_title_1"
            @click.stop="removeSelectedMedia('first_page_header_title_1')"
          />
          <span class="d-form-lable" v-else> اولین عکس صفحه اول</span>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable"> اولین متن صفحه اول</span>
          <textarea
            class="d-search-input"
            v-model="postData.first_page_header_text_1"
          >
          </textarea>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">اولین تیتر صفحه اول </span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.first_page_header_title_1"
          />
        </div>
      </div>

      <div class="sv-form-row">
        <div
          class="sv-form-group d-each-image-select"
          @click="selectMedia('first_page_header_title_2', 'image')"
          :style="getBackground('first_page_header_title_2')"
        >
          <img
            :src="trashIcon"
            class="shadowed-icon"
            v-if="withMediaVarImages.first_page_header_title_2"
            @click.stop="removeSelectedMedia('first_page_header_title_2')"
          />
          <span class="d-form-lable" v-else> دومین عکس صفحه اول</span>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable"> دومین متن صفحه اول</span>
          <textarea
            class="d-search-input"
            v-model="postData.first_page_header_text_2"
          >
          </textarea>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">دومین تیتر صفحه اول </span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.first_page_header_title_2"
          />
        </div>
      </div>

      <div class="sv-form-row">
        <div
          class="sv-form-group d-each-image-select"
          @click="selectMedia('first_page_header_title_3', 'image')"
          :style="getBackground('first_page_header_title_3')"
        >
          <img
            :src="trashIcon"
            class="shadowed-icon"
            v-if="withMediaVarImages.first_page_header_title_3"
            @click.stop="removeSelectedMedia('first_page_header_title_3')"
          />
          <span class="d-form-lable" v-else> سومین عکس صفحه اول</span>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable"> سومین متن صفحه اول</span>
          <textarea
            class="d-search-input"
            v-model="postData.first_page_header_text_3"
          >
          </textarea>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">سومین تیتر صفحه اول </span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.first_page_header_title_3"
          />
        </div>
      </div>

      <!-- Entity var counts and cta text -->
      <div class="sv-form-row">
        <div class="sv-form-group">
          <span class="d-form-lable">متن تعداد شهر </span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.city_count_text"
          />
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">متن تعداد مجموعه </span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.collection_count_text"
          />
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">متن تعداد اتاق</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.escape_room_count_text"
          />
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">متن دکمه اول سایت </span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.first_page_header_button_text"
          />
        </div>
      </div>

      <!-- Special rooms title and text -->
      <div class="sv-form-row">
        <div class="sv-form-group">
          <span class="d-form-lable">متن اتاق های ویژه </span>
          <textarea
            class="d-search-input"
            v-model="postData.special_rooms_text"
          >
          </textarea>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">تیتر اتاق های ویژه</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.special_rooms_title"
          />
        </div>
      </div>

      <!-- spacial rooms navs  -->
      <div class="sv-form-row">
        <div class="sv-form-group">
          <span class="d-form-lable"> متن اتاق های تخفیف دار</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.special_rooms_nav_discount"
          />
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">متن اتاق های تازه</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.special_rooms_nav_new"
          />
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">متن اتاق های ویژه</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.special_rooms_nav_special"
          />
        </div>
      </div>

      <!-- first page learning part -->
      <div class="sv-form-row">
        <div class="sv-form-group">
          <span class="d-form-lable">متن بخش آموزش صفحه اول </span>
          <textarea
            class="d-search-input"
            v-model="postData.first_page_learning_text"
          >
          </textarea>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">دکمه بخش آموزش صفحه اول</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.first_page_learning_button_text"
          />
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">تیتر بخش آموزش صفحه اول</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.first_page_learning_title"
          />
        </div>
      </div>

      <!-- first page collection part -->
      <div class="sv-form-row">
        <div class="sv-form-group">
          <span class="d-form-lable">متن بخش همراهان صفحه اول </span>
          <textarea
            class="d-search-input"
            v-model="postData.first_page_collection_text"
          >
          </textarea>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">دکمه بخش همراهان صفحه اول</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.first_page_collection_button_text"
          />
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">تیتر بخش همراهان صفحه اول</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.first_page_collection_title"
          />
        </div>
      </div>

      <!-- cities page -->
      <div class="sv-form-row">
        <div
          class="sv-form-group d-each-image-select"
          @click="selectMedia('city_page_title', 'image')"
          :style="getBackground('city_page_title')"
        >
          <img
            :src="trashIcon"
            class="shadowed-icon"
            v-if="withMediaVarImages.city_page_title"
            @click.stop="removeSelectedMedia('city_page_title')"
          />
          <span class="d-form-lable" v-else> عکس بنر صفحه شهرها</span>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable"> متن بنر صفحه شهرها</span>
          <textarea class="d-search-input" v-model="postData.city_page_text">
          </textarea>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">تیتر بنر صفحه شهرها</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.city_page_title"
          />
        </div>
      </div>

      <!-- collections page -->
      <div class="sv-form-row">
        <div
          class="sv-form-group d-each-image-select"
          @click="selectMedia('collection_page_title', 'image')"
          :style="getBackground('collection_page_title')"
        >
          <img
            :src="trashIcon"
            class="shadowed-icon"
            v-if="withMediaVarImages.collection_page_title"
            @click.stop="removeSelectedMedia('collection_page_title')"
          />
          <span class="d-form-lable" v-else> عکس بنر صفحه مجموعه ها</span>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable"> متن بنر صفحه مجموعه ها</span>
          <textarea
            class="d-search-input"
            v-model="postData.collection_page_text"
          >
          </textarea>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">تیتر بنر صفحه مجموعه ها</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.collection_page_title"
          />
        </div>
      </div>

      <!-- genres page -->
      <div class="sv-form-row">
        <div
          class="sv-form-group d-each-image-select"
          @click="selectMedia('genre_page_title', 'image')"
          :style="getBackground('genre_page_title')"
        >
          <img
            :src="trashIcon"
            class="shadowed-icon"
            v-if="withMediaVarImages.genre_page_title"
            @click.stop="removeSelectedMedia('genre_page_title')"
          />
          <span class="d-form-lable" v-else> عکس بنر صفحه ژانرها</span>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable"> متن بنر صفحه ژانرها</span>
          <textarea class="d-search-input" v-model="postData.genre_page_text">
          </textarea>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">تیتر بنر صفحه ژانرها</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.genre_page_title"
          />
        </div>
      </div>

      <!-- learning page -->
      <div class="sv-form-row">
        <div
          class="sv-form-group d-each-image-select"
          @click="selectMedia('learning_page_title', 'image')"
          :style="getBackground('learning_page_title')"
        >
          <img
            :src="trashIcon"
            class="shadowed-icon"
            v-if="withMediaVarImages.learning_page_title"
            @click.stop="removeSelectedMedia('learning_page_title')"
          />
          <span class="d-form-lable" v-else> عکس بنر صفحه آموزش ها</span>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable"> متن بنر صفحه آموزش ها</span>
          <textarea
            class="d-search-input"
            v-model="postData.learning_page_text"
          >
          </textarea>
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">تیتر بنر صفحه آموزش ها</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.learning_page_title"
          />
        </div>
      </div>

      <!-- about us -->
      <div class="sv-form-row">
        <div class="sv-form-group">
          <span class="d-form-lable">متن صفحه داستان ما</span>
          <vue-editor v-model="postData.our_story_text"></vue-editor>
        </div>
      </div>

       <!-- contact us -->
      <div class="sv-form-row">
        <div class="sv-form-group">
          <span class="d-form-lable">متن صفحه تماس با ما</span>
          <vue-editor v-model="postData.contact_us"></vue-editor>
        </div>
      </div>

      <!-- rating titles -->
      <div class="sv-form-row">
        <div class="sv-form-group">
          <span class="d-form-lable">عنوان پنجم امتیازدهی</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.rate_mysteriness"
          />
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">عنوان چهارم امتیازدهی</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.rate_creativeness"
          />
        </div>
        <div class="sv-form-group">
          <span class="d-form-lable">عنوان سوم امتیازدهی</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.rate_hobbiness"
          />
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">عنوان دوم امتیازدهی</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.rate_room_decoration"
          />
        </div>

        <div class="sv-form-group">
          <span class="d-form-lable">عنوان اول امتیازدهی</span>
          <input
            type="text"
            class="d-search-input"
            v-model="postData.rate_scariness"
          />
        </div>
      </div>

      <media-modal
        :media-obj="mediaObj"
        @modalMediaClicked="modalMediaClicked"
      ></media-modal>

      <div class="d-create-entity-container">
        <div class="d-entity-cta d-make-entity high-order" @click="updateVars">
          بروزرسانی
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MediaModal from "../../packages/Media-modal.vue";
import { VueEditor } from "vue2-editor";

export default {
  components: {
    MediaModal,
    VueEditor,
  },
  data() {
    return {
      postData: {
        first_page_header_title_1: "",
        first_page_header_text_1: "",
        first_page_header_title_2: "",
        first_page_header_text_2: "",
        first_page_header_title_3: "",
        first_page_header_text_3: "",
        first_page_header_button_text: "",
        special_rooms_title: "",
        special_rooms_text: "",
        special_rooms_nav_special: "",
        special_rooms_nav_new: "",
        special_rooms_nav_discount: "",
        first_page_learning_title: "",
        first_page_learning_text: "",
        first_page_learning_button_text: "",
        first_page_collection_title: "",
        first_page_collection_text: "",
        first_page_collection_button_text: "",
        escape_room_count_text: "",
        collection_count_text: "",
        city_count_text: "",
        city_page_title: "",
        city_page_text: "",
        collection_page_title: "",
        collection_page_text: "",
        genre_page_title: "",
        genre_page_text: "",
        learning_page_title: "",
        learning_page_text: "",
        our_story_text: "",
        contact_us:'',
        rate_scariness: "",
        rate_room_decoration: "",
        rate_hobbiness: "",
        rate_creativeness: "",
        rate_mysteriness: "",
      },

      withMediaVarIds: {
        first_page_header_title_1: "",
        first_page_header_title_2: "",
        first_page_header_title_3: "",
        city_page_title: "",
        learning_page_title: "",
        collection_page_title: "",
        genre_page_title: "",
      },
      withMediaVarImages: {
        first_page_header_title_1: "",
        first_page_header_title_2: "",
        first_page_header_title_3: "",
        city_page_title: "",
        learning_page_title: "",
        collection_page_title: "",
        genre_page_title: "",
      },

      attachMediaInfos: {
        mediaId: "",
        id: "",
        name: "",
      },

      trashIcon: sot.iconPath("trash.svg"),
      mediaObj: {
        show: false,
        type: "",
      },
    };
  },
  methods: {
    updateVars() {
      axios.post("/site-vars/upate", this.postData).then((response) => {
      });
    },
    removeSelectedMedia(siteVar) {
      let id = this.withMediaVarIds[siteVar];

      axios.post(`/site-vars/${id}/detach-media`).then((response) => {
        this.withMediaVarImages[siteVar] = "";
      });
    },
    getBackground(background) {
      let back = this.withMediaVarImages[background];

      return `background:url(${back}) no-repeat center/cover`;
    },
    modalMediaClicked(payload) {
      this.attachMediaInfos.mediaId = payload.id;
      this.withMediaVarImages[this.attachMediaInfos.name] = payload.path;
      this.mediaObj.show = false;

      let url = `/site-vars/${this.attachMediaInfos.id}/attach-media/${this.attachMediaInfos.mediaId}`;
      axios.post(url).then((response) => {});
    },

    selectMedia(siteVar, type) {
      let varId = this.withMediaVarIds[siteVar];

      this.attachMediaInfos.id = varId;
      this.attachMediaInfos.name = siteVar;

      this.mediaObj.type = type;
      this.mediaObj.show = true;
    },
  },

  created() {
    axios.post("/site-vars").then((response) => {
      this.postData = response.data.data.postData;
      this.withMediaVarIds = response.data.data.withMediaVarIds;
      this.withMediaVarImages = response.data.data.withMediaVarImages;
    });
  },
};
</script>

<style scoped>
.sv-form-row {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  flex-wrap: wrap;
  margin-bottom: 2rem;
}

.sv-form-group {
  margin-left: 0.5rem;
  margin-bottom: 1rem;
  flex: 1 1 auto;
}
.d-form-lable {
  display: block;
}
</style>
