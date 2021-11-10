<template>
    <div class="d-item-container" v-if="userHasAccessToCreate">
        <div>
            <!-- The modal -->
            <b-modal id="tag-modal" hide-footer>
                <b-container>
                    <div class="rtl-dir text-sm chkout-dtil-cntinr">
                        <p class="checkout-room-details-header mt-0">
                            <strong>
                                {{ action === 'add' ? 'تگ جدید' : 'ویرایش تگ' }}
                            </strong>
                        </p>

                        <div class="mt-8">

                            <b-form>
                                <b-form-input
                                    class="mb-2 mr-sm-2 mb-sm-0"
                                    v-model="tag.name"
                                    required
                                ></b-form-input>

                                <b-button variant="success" @click="mainAction" class="btn-sm mt-4">
                                    <span>
                                        {{ action === 'add' ? 'ثبت' : 'بروزرسانی' }}
                                    </span>
                                </b-button>
                            </b-form>
                        </div>

                    </div>
                </b-container>

            </b-modal>
        </div>
        <div class="d-status-bar">
            <a href="#" @click="beforeAdd" class="d-add-item-cta">
                <img :src="iconPath('white-add.svg')" class="small-icon mr-2"/>
                <span> اضافه کردن تگ جدید </span>
            </a>
            <div class="search-container">
                <img :src="iconPath('search1.svg')" class="search-icon"/>
                <input
                    type="text"
                    class="d-search-input pr-10"
                    v-model="itemKey"
                    placeholder="جستجو بر روی همه تگ ها"
                />
            </div>
        </div>
        <div class="d-second-status-bar">

            <div class="d-delete-items-cta" v-if="selectedEntities.length" @click="deleteEntities">
                حذف تگ های انتخاب شده
            </div>
        </div>

        <div class="d-cards-container">

            <tag-card
                v-for="(entity, key) in entities"
                :key="key"
                :card="entity"
                :has-edit="true"
                @beforeEdit="beforeEdit"
                :class="[
                          selectedEntities.includes(entity.id) ? 'selected-checked-item' : '',
                        ]"
                @click.native="cardClicked(entity)"
            ></tag-card>
        </div>

        <div class="pagination-container">
            <div
                class="pagination-btns"
                v-for="(pagination, key) in paginations"
                :key="key"
                @click="getEntities(pagination.url)"
                :class="[pagination.active ? 'active-pagination' : '']"
            >
                {{ pagination.label }}
            </div>
        </div>
    </div>

    <div class="alert alert-danger" v-else>
        شما اجازه دسترسی به این صفحه را ندارید
    </div>
</template>

<script>
import TagCard from '../../cards/Tag-card.vue'

export default {
    components:{
        TagCard
    },
    data() {
        return {
            action: 'add',
            tag: {
                id: '',
                name: ''
            },
            paginations: {},
            entities: [],
            selectedEntities: [],
            itemKey: "",
        };
    },
    methods: {

        beforeAdd() {
            this.action = 'add';
            this.$bvModal.show("tag-modal");
        },

        beforeEdit(entity){
            this.action = 'edit';
            this.tag = entity;
            this.$bvModal.show("tag-modal");
        },

        mainAction() {
            this.callApi({
                method: this.action === 'add'?'actionAdd' : 'actionUpdate',
                tag:this.tag
            });
        },

        callApi(data){
            axios.post('/tags', data).then(() => {
                this.getEntities();
                this.$bvModal.hide("tag-modal")
                this.tag = {
                    id: '',
                    name: ''
                }
            })
        },

        deleteEntities() {
            let data = {
                method: 'actionDelete',
                tags: this.selectedEntities
            }
            axios.post('/tags', data).then(response => {
                this.getEntities();
                this.selectedEntities = [];
            });
        },

        cardClicked(entity) {
            if (this.selectedEntities.includes(entity.id)) {
                this.selectedEntities = _.without(this.selectedEntities, entity.id);
            } else {
                this.selectedEntities.push(entity.id);
            }
        },
        getEntities(url = '/tags') {

            let data = {
                search: this.itemKey,
                method: 'actionIndex'
            }

            axios.post(url, data).then((response) => {
                this.entities = response.data.data;
                this.paginations = response.data.links;
            });
        },

        iconPath(icon) {
            return sot.iconPath(icon);
        },
    },

    computed: {
        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        }
    },

    watch: {
        itemKey(value) {
            this.getEntities();
        },
    },

    created() {
        this.getEntities();
    },
};
</script>
