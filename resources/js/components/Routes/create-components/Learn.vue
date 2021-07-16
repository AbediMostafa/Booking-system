<template>
  <div class="d-item-container">
    <div class="d-status-bar flex-end">
      <h3 class="create-media-title">اضافه کردن آموزش جدید</h3>
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
                'd-special-room', 'mr-4',
                postData.learn.starred ? 'selected-checked-item' : '',
              ]"
              @click="
                postData.learn.starred =
                  postData.learn.starred === 0 ? 1 : 0
              "
            >
              آموزش ستاره دار
            </div>
      </div>

      <div class="d-form-row d-form">
          <vue-editor v-model="postData.learn.description"></vue-editor>
      </div>
      <div class="d-form-row d-form">
        <div
          class="d-each-image-select"
          @click="mediaObj.show = true"
          :style="getBackground"
        >
          <img
            :src="trashIcon"
            v-if="postData.media.background"
            class="shadowed-icon"
            @click.stop="removeSelectedMedia()"
          />
          <span v-else> انتخاب عکس</span>
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
          @click="createEntity"
        >
          ایجاد
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
    VueEditor
  },
  data() {
    return {
      postData: {
        learn: {
          title: "",
          brief: "",
          description: "",
          starred:0
        },
        media: {
          background: "",
          id: "",
        },
      },
      trashIcon: sot.iconPath("trash.svg"),
      mediaObj: {
        show: false,
        type: "image",
      },
    };
  },
  methods: {
    cancelCreatingRoom() {
      this.$router.push({ path: "/learns" });
    },
    createEntity() {
      axios
        .post(`/admin/learn/store`, this.postData)
        .then((response) => {
          setTimeout(() => {
            this.$router.push({ path: "/learns" });
          }, 2000);
        });
    },
    removeSelectedMedia() {
      this.postData.media = {
        background: "",
        id: "",
      };
    },

    modalMediaClicked(payload) {
      this.postData.media.background = payload.path;
      this.postData.media.id = payload.id;

      this.mediaObj.show = false;
    },
  },

  computed: {
    getBackground() {
      return `background:url(${this.postData.media.background}) no-repeat center/cover`;
    },
  },
};
</script>
