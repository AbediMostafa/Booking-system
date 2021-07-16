<template>
  <div class="d-item-container">
    <div class="d-status-bar flex-end">
      <h3 class="create-media-title">اضافه کردن شهر جدید</h3>
    </div>

    <div class="d-form-container">
      <div class="d-form-row d-form">
        <div class="d-for-group d-flex-25">
          <span class="d-form-lable"> نام شهر </span>
          <div class="d-form-input">
            <input
              type="text"
              class="d-search-input"
              v-model="postData.city.name"
            />
          </div>
        </div>
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

export default {
  components: {
    MediaModal,
  },
  data() {
    return {
      postData: {
        city: {
          name: "",
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
      this.$router.push({ path: "/cities" });
    },
    createEntity() {
      axios
        .post(`/admin/city/store`, this.postData)
        .then((response) => {
          setTimeout(() => {
            this.$router.push({ path: "/cities" });
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
