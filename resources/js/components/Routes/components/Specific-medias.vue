<template>
  <div class="d-item-container">
    <div class="d-status-bar flex-end">
      <h3 class="create-media-title">مدیاهای خاص</h3>
    </div>
    <div class="d-form-container">
      <div class="sm-row">
        <div
          class="d-each-image-select sm-image-placeholder"
          @click="selectStaticMedia('first_page_video', 'video')"
        >
          <div v-if="postData.staticMedias.first_page_video.background">
            <img
              :src="trashIcon"
              class="shadowed-icon"
              @click.stop="removeSelectedStaticMedia('first_page_video')"
            />
            <video
              controls
              style="height: 12rem"
              :key="postData.staticMedias.first_page_video.background"
            >
              <source
                :src="postData.staticMedias.first_page_video.background"
                type="video/mp4"
              />
              <source
                :src="postData.staticMedias.first_page_video.background"
                type="video/ogg"
              />
              Your browser does not support the video tag.
            </video>
          </div>

          <span v-else> ویدئوی صفحه اول </span>
        </div>
        <div class="sm-lable">ویدئوی صفحه اول</div>
      </div>
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

      <div
        class="sm-row"
        v-for="(dynamicMedia, key) in postData.dynamicMedias"
        :key="key"
      >
        <div
          class="d-each-image-select sm-image-placeholder"
          @click="selectDynamicMedia(key, 'image')"
          :style="getBackground(postData.dynamicMedias[key].background)"
        >
          <img
            :src="trashIcon"
            class="shadowed-icon"
            @click.stop="removeDynamicMedia(key)"
          />
          <span
            v-if="!getBackground(postData.dynamicMedias[key].background)"
          >
            عکس اسلایدر
          </span>
        </div>
        <div class="sm-lable">عکس اسلایدر</div>
      </div>

      <div class="sm-row">
        <div class="add-dynamic-media-holder" @click="addDynamicMedia">
          <img :src="iconPath('grey-add.svg')" class="small-icon mr-2" />
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
</template>

<script>
import dropdown from "vue-dropdowns";
import Multiselect from "vue-multiselect";
import vueselect from "v-select2-component";
import MediaModal from "../../packages/Media-modal.vue";
import VuePersianDatetimePicker from "vue-persian-datetime-picker";

export default {
  components: {
    dropdown,
    vueselect,
    MediaModal,
    VuePersianDatetimePicker,
    Multiselect,
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

        dynamicMedias: [],
      },
      selectedMedia: {
        type: "static",
        key: "",
      },

      trashIcon: sot.iconPath("trash.svg"),
      mediaObj: {
        show: false,
        type: "",
      },
    };
  },
  methods: {
    cancelCreatingRoom() {
      this.$router.push({ path: "/rooms" });
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
    selectDynamicMedia(key, type) {
      this.selectedMedia.type = "dynamic";
      this.selectedMedia.key = key;
      this.lunchModal(type);
    },

    modalMediaClicked(payload) {
      let sm = "";
      if (this.selectedMedia.type === "static") {
        sm = this.postData.staticMedias[this.selectedMedia.key];
        axios
          .post(`admin/specific-medias/${sm.sm_id}/attach-media/${payload.id}`)
          .then((response) => {});
      } else {
        sm = this.postData.dynamicMedias[this.selectedMedia.key];
        axios
          .post(`admin/specific-medias/attach-media/${payload.id}`)
          .then((response) => {
            sm.sm_id = response.data.sm_id;
          });
      }

      sm.id = payload.id;
      sm.background = payload.path;
      this.mediaObj.show = false;
    },

    removeDynamicMedia(key) {
      let sm_id = this.postData.dynamicMedias[key].sm_id;
         axios
            .post(`/admin/specific-medias/detach-dynamic-media/${sm_id}`)
            .then((response) => {});

      this.postData.dynamicMedias.splice(key, 1);
    },
    removeSelectedStaticMedia(type) {
      axios
        .post(
          `/admin/specific-medias/detach-static-media/${this.postData.staticMedias[type].id}`
        )
        .then((response) => {
          this.postData.staticMedias[type].id = "";
          this.postData.staticMedias[type].background = "";
        });
    },
    addDynamicMedia() {
      this.$set(
        this.postData.dynamicMedias,
        this.postData.dynamicMedias.length,
        {
          id: "",
          background: "",
          sm_id:'',
        }
      );
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
  },

  created() {
    this.getMedias();
  },
};
</script>

<style scoped>
.sm-row {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  margin-bottom: 2rem;
  flex-wrap: wrap;
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

.add-dynamic-media-holder:hover {
  background: #e2e8f0;
}

.add-dynamic-media-holder {
  width: 15rem;
  height: 4rem;
  align-items: center;
  justify-content: center;
  display: flex;
  border: 1px dashed #9398a0;
  border-radius: 0.5rem;
  font-size: 0.8rem;
  color: #9daac5;
  cursor: pointer;
  transition: all 300ms;
}
</style>
