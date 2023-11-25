<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div class="d-status-bar flex-end">
        </div>

        <div class="d-form-container">
            <div class="df-upload-file-container">
                <div class="d-input-input low-order">
                    <div class="dfuf-area" @click="fileAreaClicked">
                        {{ fileSelectTex }}
                    </div>
                </div>

                <input
                    type="file"
                    ref="file-input"
                    id="file-input"
                    @change="fileSelected"
                />
            </div>

            <div class="rs-diagram-and-text end-flex">
                <div class="d-progressbar">
                    <div class="res-diagram-title">
                    </div>
                    <div class="rs-diagram-shape-container">
                        <div class="rs-diagram-dynamic-shape" :style="`width: ${uploadPercentage}%`"></div>
                    </div>
                </div>
            </div>
            <div class="d-create-entity-container">
                <div
                    class="d-entity-cta d-cancel-entity low-order"
                    @click="cancelMakingFile"
                >
                </div>
                <div class="d-entity-cta d-make-entity high-order" @click="makeFile">
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-danger" v-else>
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
            selectedFile: "",
            uploadPercentage: 0,
        };
    },
    methods: {
        uploadFile(url, data) {
            const config = {
                onUploadProgress: (progressEvent) => {
                    this.uploadPercentage = Math.round(
                        (progressEvent.loaded * 100) / progressEvent.total
                    );
                },
            };
            axios.post(url, data, config).then((response) => {
                setTimeout(() => {
                    this.$router.push({path: "/medias"});
                }, 2000);
            });
        },
        cancelMakingFile() {
            this.$router.push({path: "/medias"});
        },
        makeFile() {
            let formData = new FormData();
            formData.append("file", this.selectedFile);

            this.uploadFile("admin/media/upload", formData);
        },
        fileSelected(e) {
            this.fileSelectTex = e.target.files[0].name;
            this.selectedFile = e.target.files[0];
        },
        fileAreaClicked() {
            this.$refs["file-input"].click();
        },
    },

    computed: {
        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        },
    }
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
    flex-wrap: wrap;
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

.high-order {
    order: 1;
}

.low-order {
    order: 2;
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

@media screen and (min-width: 480px) {
    .low-order,
    .high-order {
        order: initial;
    }
}
</style>
