<template>
    <div class="d-item-container">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">
                کاربر جدید
            </h3>
        </div>

        <div class="d-form-container" v-if="true">
            <div class="d-form-row d-form flex-start">
                <!-- full name-->
                <div class="d-for-group d-flex-25 ml-4">
                    <span class="d-form-lable">نام و نام خانوادگی</span>
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.name"
                        />
                    </div>
                </div>

                <!-- username-->
                <div class="d-for-group d-flex-25">
                    <span class="d-form-lable">نام کاربری</span>
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.email"
                        />
                    </div>
                </div>
            </div>

            <div class="d-form-row d-form flex-start">
                <!-- phone-->
                <div class="d-for-group d-flex-25 ml-4">
                    <span class="d-form-lable">موبایل</span>
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.phone"
                        />
                    </div>
                </div>
            </div>

            <div class="d-form-row d-form flex-start">
                <!-- password-->
                <div class="d-for-group d-flex-25 ml-4">
                    <span class="d-form-lable">پسوورد</span>
                    <div class="d-form-input">
                        <input
                            type="password"
                            class="d-search-input"
                            v-model="postData.password"
                        />
                    </div>
                </div>

                <!-- password repeat-->
                <div class="d-for-group d-flex-25">
                    <span class="d-form-lable">تکرار پسوورد</span>
                    <div class="d-form-input">
                        <input
                            type="password"
                            class="d-search-input"
                            v-model="postData.repeatPassword"
                        />
                    </div>
                </div>
            </div>

            <div class="d-form-row d-form flex-start">
                <!-- authentication-->
                <div class="d-for-group d-flex-25 ml-4">
                    <span class="d-form-lable">سطح دسترسی</span>
                    <div class="d-form-input">
                        <multiselect
                            v-model="postData.role"
                            :options="roles"
                            :searchable="false"
                            label="persian_name"
                            :selectLabel="''"
                            :close-on-select="false"
                            @input="onChange"
                            placeholder="انتخاب کنید ..">
                        </multiselect>

                    </div>
                </div>

                <!-- rooms-->
                <div class="d-for-group d-flex-25" v-if="roomOwnerRoleSelected">
                    <span class="d-form-lable">همه اتاق ها</span>
                    <div class="d-form-input">
                        <multiselect
                            v-model="selectedRooms"
                            :options="rooms"
                            :searchable="true"
                            label="name"
                            track-by="id"
                            :multiple="true"
                            :taggable="true"
                            :selectLabel="''"
                            placeholder="انتخاب کنید ..">
                        </multiselect>

                    </div>
                </div>

            </div>

            <div class="d-form-row d-form alert alert-danger" v-if="errors.length">
                <ul class="m-0">
                    <li v-for="(error, key) in errors" :key="key">
                        {{ error }}
                    </li>
                </ul>
            </div>

            <div class="d-create-entity-container">
                <div
                    class="d-entity-cta d-make-entity high-order"
                    @click="addUser"
                >
                    ایجاد
                </div>
            </div>
        </div>

        <div class="alert alert-danger" v-else>
            شما اجازه دسترسی به این صفحه را ندارید
        </div>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
    components: {
        Multiselect
    },
    data() {
        return {
            user: {},
            errors: [],
            roles: [],
            rooms: [],
            selectedRooms: [],
            roomOwnerRoleSelected: false,
            postData: {
                name: '',
                email: '',
                phone:'',
                role: '',
                rooms: [],
                password: '',
                repeatPassword: '',
            },
        };
    },
    methods: {
        onChange(option) {
            this.postData.rooms = [];
            this.roomOwnerRoleSelected = option.name === 'room_owner';
        },
        validate() {

            let data = this.postData;
            this.errors = [];

            !data.email && this.errors.push('نام کاربری ضروری است');
            !data.phone && this.errors.push('تلفن همراه ضروری است');
            !data.password && this.errors.push('گذرواژه ضروری است');
            !data.repeatPassword && this.errors.push('تکرار گذرواژه ضروری است');

            data.password !== data.repeatPassword && this.errors.push('گذرواژه و تکرار آن یکی نیستند')

            return this.errors.length;
        },

        addUser() {
            if (this.validate()) return;
            this.postData.rooms = this.selectedRooms.map(selectedRoom => selectedRoom.id);

            axios.post(`users`, this.postData)
        },
        getUserAndRolesAndRooms() {
            axios.post("user-roles").then((response) => {
                this.user = response.data.user;
                this.roles = response.data.roles;
                this.rooms = response.data.rooms
            });
        }
    },

    computed: {
        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        }
    },

    created() {
        this.getUserAndRolesAndRooms();
    },
};
</script>
