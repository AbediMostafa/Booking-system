<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">اضافه کردن مجموعه جدید</h3>
        </div>

        <div class="d-form-container">
            <div class="d-form-row d-form flex-start">
                <div class="d-for-group d-flex-25">
                    <span class="d-form-lable"> نام مجموعه </span>
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.collection.name"
                        />
                    </div>
                </div>

                <div class="d-for-group d-flex-25 mr-4">
                    <span class="d-form-lable">ترتیب</span>
                    <div class="d-form-input">
                        <input
                            type="number"
                            class="d-search-input"
                            v-model="postData.collection.order"
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

    <div class="alert alert-danger" v-else>
        شما اجازه دسترسی به این صفحه را ندارید
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
                collection: {
                    name: "",
                    order: 0
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
            this.$router.push({path: "/collections"});
        },
        createEntity() {
            axios
                .post(`/admin/collection/store`, this.postData)
                .then((response) => {
                    // setTimeout(() => {
                    //     this.$router.push({path: "/collections"});
                    // }, 2000);
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
        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        },
    },
};
</script>
