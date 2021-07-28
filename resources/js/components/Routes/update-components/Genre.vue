<template>
  <div class="d-item-container">
    <div class="d-status-bar flex-end">
      <h3 class="create-media-title">
        ویرایش ژانر
        {{ postData.genreName }}
      </h3>
    </div>

    <div class="d-form-container">
      <div class="d-form-row d-form">
        <div class="d-for-group d-flex-25">
          <span class="d-form-lable"> نام ژانر </span>
          <div class="d-form-input">
            <input
              type="text"
              class="d-search-input"
              v-model="postData.genre.title"
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
        genreName: "",
        genre: {
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
      this.$router.push({ path: "/genres" });
    },
    updateEntity() {
      axios
        .post(
          `/admin/genre/update/${this.postData.genre.id}`,
          this.postData.genre
        )
        .then((response) => {
          setTimeout(() => {
            this.$router.push({ path: "/genres" });
          }, 2000);
        });
    },
    removeSelectedMedia() {
      let route = `admin/genre/detach-media/${this.postData.genre.id}`;

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

      let route = `admin/genre/${this.postData.genre.id}/attach-media/${payload.id}`;

      axios.post(route, media).then((response) => {});
      this.mediaObj.show = false;
    },

    getEntity() {
      axios
        .get(`admin/genre/update/${this.$route.params.id}`)
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