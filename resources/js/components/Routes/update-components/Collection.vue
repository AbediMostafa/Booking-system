<template>
  <div class="d-item-container">
    <div class="d-status-bar flex-end">
      <h3 class="create-media-title">
        ویرایش مجموعه
        {{ postData.collectionName }}
      </h3>
    </div>

    <div class="d-form-container">
      <div class="d-form-row d-form">
        <div class="d-for-group d-flex-25">
          <span class="d-form-lable"> نام مجموعه </span>
          <div class="d-form-input">
            <input
              type="text"
              class="d-search-input"
              v-model="postData.collection.title"
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
          @click="updateEntity"
        >
          بروزرسانی
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
        collectionName: "",
        collection: {
          id: "",
          title: "",
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
      this.$router.push({ path: "/collections" });
    },
    updateEntity() {
      axios
        .post(
          `/admin/collection/update/${this.postData.collection.id}`,
          this.postData.collection
        )
        .then((response) => {
          setTimeout(() => {
            this.$router.push({ path: "/collections" });
          }, 2000);
        });
    },
    removeSelectedMedia(mediaOf) {
      let route = `admin/collection/detach-media/${this.postData.collection.id}`;

      axios.post(route).then((response) => {
        this.postData.media = {
          background: "",
          id: "",
        };
      });
    },

    modalMediaClicked(payload) {
      let media = this.postData.media;
      media.background = payload.path;
      media.id = payload.id;

      let route = `admin/collection/${this.postData.collection.id}/attach-media/${payload.id}`;

      axios.post(route, media).then((response) => {});
      this.mediaObj.show = false;
    },

    getEntity() {
      axios
        .get(`admin/collection/update/${this.$route.params.id}`)
        .then((response) => {
          this.postData = response.data;
        });
    },
  },

  computed: {
    getBackground() {
      return `background:url(${this.postData.media.background}) no-repeat center/cover`;
    },
  },

  created() {
    this.getEntity();
  },
};
</script>