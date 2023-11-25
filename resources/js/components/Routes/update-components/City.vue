<template>
  <div class="d-item-container" v-if="userHasAccessToCreate">
    <div class="d-status-bar flex-end">
      <h3 class="create-media-title">
        {{ postData.cityName }}
      </h3>
    </div>

    <div class="d-form-container">
      <div class="d-form-row d-form">
        <div class="d-for-group d-flex-25">
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
        </div>
        <div
          class="d-entity-cta d-make-entity high-order"
          @click="updateEntity"
        >
        </div>
      </div>
    </div>
  </div>

    <div class="alert alert-danger" v-else>
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
        cityName: "",
        city: {
          id: "",
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
    updateEntity() {
      axios
        .post(`/admin/city/update/${this.postData.city.id}`, this.postData.city)
        .then((response) => {
          setTimeout(() => {
            this.$router.push({ path: "/cities" });
          }, 2000);
        });
    },
    removeSelectedMedia(mediaOf) {
      let route = `admin/city/detach-media/${this.postData.city.id}`;

      axios.post(route, {mediaType:'front'}).then((response) => {
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

      let route = `admin/city/${this.postData.city.id}/attach-media/${payload.id}`;

      axios.post(route, media).then((response) => {});
      this.mediaObj.show = false;
    },

    getEntity() {
      axios
        .get(`admin/city/update/${this.$route.params.id}`)
        .then((response) => {
          this.postData = response.data;
        });
    },
  },

  computed: {
    getBackground() {
      return `background:url(${this.postData.media.background}) no-repeat center/cover`;
    },

      userHasAccessToCreate() {
          return user.type === 'admin' || user.type === 'manager';
      }
  },

  created() {
    this.getEntity();
  },
};
</script>
