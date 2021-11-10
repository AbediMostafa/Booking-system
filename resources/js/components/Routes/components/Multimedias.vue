<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">تنظیمات تازه ها</h3>
        </div>

        <div class="d-form-container">
            <div class="d-form-row d-form justify-start flex-wrap" v-for="(multimedia, key) in multimedias">
                <div class="d-flex-25">
                    <span class="d-form-lable">نوع پست</span>
                    <div class="d-form-input">
                        <multiselect
                            v-model="multimedia.multimedia"
                            label="title"
                            track-by="name"
                            :options="multimediaTypes"
                            :searchable="false"
                            :show-labels="false"
                            @input="changeOption(multimedia)"
                            placeholder="انتخاب کنید ..">
                        </multiselect>
                    </div>

                </div>

                <div class="mr-2 d-flex-75" v-show="multimedia.displayOptions">
                    <span class="d-form-lable">مقادیر پست</span>
                    <div class="between-flex">
                        <div class="d-form-input d-flex-75">
                            <multiselect
                                v-model="multimedia.option"
                                :options="multimedia.multimedia.name ? options[multimedia.multimedia.name]:[]"
                                track-by="id"
                                label="title"
                                :searchable="false"
                                :show-labels="false"
                                placeholder="انتخاب کنید ..">
                            </multiselect>
                        </div>
                        <span class="btn btn-danger btn-sm d-flex-25" @click="deleteMultimedia(key)">حذف</span>
                    </div>

                </div>

            </div>
            <div class="sm-row">
                <div class="add-dynamic-media-holder" @click="addDynamicMultimedia">
                    <b-icon icon="plus" class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                    <span>اضافه کردن مالتیمدیا جدید</span>
                </div>
            </div>


            <div class="d-create-entity-container">
                <div
                    class="d-entity-cta d-cancel-entity low-order"
                    @click="cancelMultimedia"
                >
                    انصراف
                </div>
                <div
                    class="d-entity-cta d-make-entity high-order"
                    @click="updateMultimedia"
                >
                    ثبت
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
import {VueEditor} from "vue2-editor";
import Multiselect from "vue-multiselect";

export default {
    components: {
        MediaModal,
        VueEditor,
        Multiselect
    },
    data() {
        return {
            multimediaTypes: [
                {
                    name: 'movie',
                    title: 'فیلم'
                },
                {
                    name: 'news',
                    title: 'خبر'
                },
                {
                    name: 'post',
                    title: 'آموزش'
                },
            ],
            multimedias: [],
            options: {
                movie: [],
                news: [],
                post: [],
            }
        };
    },
    methods: {
        deleteMultimedia(key){
            this.multimedias.splice(key, 1);
        },

        addDynamicMultimedia() {
            this.multimedias.push({
                multimedia: {
                    name: '',
                    title: ''
                },
                option: {
                    id: '',
                    title: ''
                },
                displayOptions: false
            });
        },

        cancelMultimedia() {

        },
        updateMultimedia() {
            let data = {
                method: 'actionStore',
                multimedias: this.multimedias.map(multimedia => ({
                    multimediaable_id: multimedia.option.id,
                    multimediaable_type: multimedia.multimedia.name,
                }))
                    .filter(multimedia => multimedia.multimediaable_id && multimedia.multimediaable_type)
                .reduce((acc, curr)=>{
                    !acc.some(
                        acu=>acu.multimediaable_id === curr.multimediaable_id && acu.multimediaable_type === curr.multimediaable_type
                    )
                    && acc.push(curr);
                    return acc;
                },[])
            }

            axios.post('/multimedia', data)
        },

        changeOption(multimedia) {
            multimedia.displayOptions = true;
        },

        getMultimediaAndDependencies() {

            let getMultimediaObj = multimedia => ({
                name: multimedia.multimediaable_type,
                title: multimedia.multimediaable_type === 'post' ? 'آموزش'
                    :
                    (multimedia.multimediaable_type === 'news' ? 'خبر' : 'فیلم')
            });

            axios.post('multimedia', {method: 'actionGetMultimediaAndDependencies'}).then(response => {
                this.multimedias = response.data.multimedias.map(multimedia => ({
                    multimedia: getMultimediaObj(multimedia),
                    option: multimedia.multimediaable,
                    displayOptions: true,
                }));
                this.options = response.data.dependencies
            });
        }
    },
    computed: {

        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        },

    },

    created() {
        this.getMultimediaAndDependencies();
    }
}
</script>
