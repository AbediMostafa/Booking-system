<template>
  <div class="d-item-container">
    <div class="d-status-bar flex-end">
      <h3 class="create-media-title">ایجاد مدیای جدید</h3>
    </div>

    <div class="d-form-container">
      <div class="df-upload-file-container">
        <div class="d-input-input">
          <div class="dfuf-area" @click="fileAreaClicked">
            {{ fileSelectTex }}
          </div>
        </div>

        <div class="dfuf-lable d-input-label">آپلود فایل</div>
        <input
          type="file"
          ref="file-input"
          id="file-input"
          @change="fileSelected"
        />
      </div>
      <div class="df-media-for-container mt-4">
        <div class="d-input-input">
          <dropdown
            :options="mediaFor"
            :selected="object"
            @updateOption="selectOption"
          ></dropdown>
        </div>
        <div class="dfmf-lable d-input-label">مدیا برای</div>
      </div>
      <div class="d-create-entity-container">
        <div class="d-entity-cta d-cancel-entity" @click="cancelMakingFile">
          انصراف
        </div>
        <div class="d-entity-cta d-make-entity" @click="makeFile">ایجاد</div>
      </div>
    </div>
  </div>
</template>

<script>
import dropdown from "vue-dropdowns";
export default {
  components: {
    dropdown,
  },
  data() {
    return {
      mediaFor: [
        { name: "اتاق", value: "room" },
        { name: "شهر", value: "city" },
        { name: "مجموعه", value: "collection" },
        { name: "آموزش", value: "genre" },
        { name: "ژانر", value: "post" },
        { name: "غیره", value: "other" },
      ],
      object: {
        name: "انتخاب کنید",
        value: "",
      },
      fileSelectTex: "انتخاب فایل",
      selectedFile: "",
    };
  },
  methods: {
    uploadFile(url, data) {
      axios.post(url, data).then((response) => {
        console.log(response);
      });
    },
    cancelMakingFile() {},
    makeFile() {

      let formData = new FormData();
      formData.append("file", this.selectedFile);
      formData.append("media_of", this.object.value);

      this.uploadFile("admin/media/upload", formData);
    },
    selectOption(payload) {
      this.object = payload;
    },
    fileSelected(e) {
      this.fileSelectTex = e.target.files[0].name;
      this.selectedFile = e.target.files[0];
    },
    fileAreaClicked() {
      this.$refs["file-input"].click();
    },
  },
};
</script>

<style scoped>
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

.df-upload-file-container {
  display: flex;
  align-items: center;
  justify-content: flex-end;
}
.df-media-for-container {
  display: flex;
  align-items: center;
  justify-content: flex-end;
}

.dfuf-area:hover {
  background: #f1f2f3;
}
.dfuf-area {
  flex: 0 0 10rem;
  border: 1px dashed rgba(0, 0, 0, 0.2);
  padding: 0.6rem 3rem;
  text-align: center;
  border-radius: 0.5rem;
  color: #a6acb1;
  cursor: pointer;
  transition: all 300ms;
}

.d-input-label {
  flex: 0 0 7rem;
}

.d-input-label {
  flex: 0 0 7rem;
}

.btn-group li {
  font-size: 0.9rem;
  color: #aab3b9;
}
.create-media-title {
  margin: 0.5rem;
  color: var(--second-color);
}
</style>