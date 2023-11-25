<template>
    <div class="d-item-container">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">
                {{ $route.params.email }}
            </h3>
        </div>

        <div class="d-form-container" v-if="true">

            <div class="d-form-row d-form flex-start">
                <!-- full name -->
                <div class="d-for-group d-flex-25 ml-4">
                    <span class="d-form-lable">
                    </span>
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.name"
                        />
                    </div>
                </div>

                <!-- username -->
                <div class="d-for-group d-flex-25" v-if="!isNormalUser">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.email"
                        />
                    </div>
                </div>
            </div>

            <div class="d-form-row d-form flex-start" v-if="!isNormalUser">
                <!-- phone-->
                <div class="d-for-group d-flex-25 ml-4">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.phone"
                        />
                    </div>
                </div>

                <!-- score-->
                <div class="d-for-group d-flex-25 ml-4" v-if="postData.role.name = 'user'">
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.score"
                        />
                    </div>
                </div>
            </div>
            <div class="d-form-row d-form flex-start" v-if="!isNormalUser">
                <!-- password-->
                <div class="d-for-group d-flex-25 ml-4">
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
                    <div class="d-form-input">
                        <input
                            type="password"
                            class="d-search-input"
                            v-model="postData.repeatPassword"
                        />
                    </div>
                </div>
            </div>
            <div class="d-form-row d-form flex-start" v-if="!isNormalUser">
                <!-- authentication-->
                <div class="d-for-group d-flex-25 ml-4" v-if="showRole">
                    <div class="d-form-input">
                        <multiselect
                            v-model="postData.role"
                            :options="roles"
                            :searchable="false"
                            :selectLabel="''"
                            :close-on-select="true"
                            @input="onChange">
                        </multiselect>

                    </div>
                </div>

                <!-- rooms-->
                <div class="d-for-group d-flex-25" v-if="showRooms">
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
                            :close-on-select="false"
                            :disabled="roomDisabled"

                            placeholder="">
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
                    @click="updateEntity"
                >
                </div>
            </div>
        </div>
        <div v-else>
            <div class="alert alert-danger">
            </div>
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
            rooms: [],
            roles: [],
            errors: [],
            selectedRooms: [],
            showRooms: false,
            showRole: false,
            roomDisabled: false,
            postData: {
                name: '',
                email: '',
                phone: '',
                password: '',
                repeatPassword: '',
                role: '',
                score:0,
                rooms: []
            },
        };
    },
    watch: {
        $route(to, from) {
            this.getUserAndRolesAndRooms();
        }
    },
    methods: {
        onChange(option) {
            this.postData.rooms = [];
            this.showRooms = option.name === 'room_owner';
        },
        validate() {

            if (this.isNormalUser || this.postData.role.name === 'user') return;

            let data = this.postData;
            this.errors = [];

            !data.email && this.errors.push();

            data.password !== data.repeatPassword && this.errors.push()

            return this.errors.length;
        },

        updateEntity() {
            if (this.validate()) return;
            this.postData.rooms = this.selectedRooms.map(selectedRoom => selectedRoom.id);
            axios.put(`users/${this.$route.params.id}`, this.postData)
        },
        checkRoleVisibility() {
            if (
                (user.type === 'admin' && this.postData.role.name !== 'admin')
                || (user.type === 'manger' && this.postData.role.name !== 'manger')
            ) {
                this.showRole = true;
            }
        },

        checkRoomVisibility() {
            if (user.type !== 'room_owner' && this.postData.role.name === 'room_owner') {
                this.showRooms = true;
            }
        },
        getUserAndRolesAndRooms() {
            axios.post(`user-roles/${this.$route.params.id}`).then((response) => {
                this.roles = response.data.roles;
                this.rooms = response.data.rooms
                this.postData.id = response.data.updatingUser.id;
                this.postData.email = response.data.updatingUser.email;
                this.postData.phone = response.data.updatingUser.phone;
                this.postData.name = response.data.updatingUser.name;
                this.postData.role = response.data.updatingUser.role;
                this.postData.score = response.data.updatingUser.score;
                this.selectedRooms = response.data.updatingUser.rooms;
                this.checkRoleVisibility();
                this.checkRoomVisibility();
            });
        },
    },

    computed: {
        userHasAccessToEdit() {
            return user.id == this.$route.params.id || user.type === 'admin' || user.type === 'manager';
        },
        isNormalUser() {
            return user.type === 'user';
        },
    },

    created() {
        this.getUserAndRolesAndRooms();
    },
};
</script>
