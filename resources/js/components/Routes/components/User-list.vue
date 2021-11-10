<template>
    <div class="d-item-container">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">
                لیست کاربران
            </h3>
        </div>

        <div class="d-form-container" v-if="userHasAccessToCreate">
            <table class="table table-hover user-list-table">
                <thead>
                <tr class="row">
                    <th class="col-1" scope="col">عملیات</th>
                    <th scope="col" class="col-6">سطح دسترسی</th>
                    <th scope="col" class="col-3">نام</th>
                    <th scope="col" class="col-2">نام کاربری</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(currentUser, key) in users" :class="['row', isUserRow(currentUser)?'table-success':'']">
                    <td class="col-1 user-list-action-cl">
                        <template v-if="isAdmin(currentUser)">
                            <b-icon
                                icon="pencil-square"
                                class="dashboard-bootstrap-icon d-icon d-nav-icon"
                                @click="updateUser(currentUser)"
                            ></b-icon>
                            <b-icon
                                v-if="cantDeleteItself(currentUser)"
                                @click="deleteUser(currentUser)"
                                icon="trash"
                                class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                        </template>
                    </td>
                    <td class="user-lis-td col-6">
                        <span class="d-media-of" v-for="(room, key) in currentUser.rooms" :key="key">
                            {{ room.name }}
                        </span>
                        <span class="ml-2">
                            {{ currentUser.role.persian_name }}
                        </span>
                    </td>
                    <td class="user-lis-td col-3">{{ currentUser.name }}</td>
                    <td class="user-lis-td col-2">{{ currentUser.email }}</td>

                </tr>
                </tbody>
            </table>
            <div class="pagination-container">
                <div
                    class="pagination-btns"
                    v-for="(pagination, key) in paginations"
                    :key="key"
                    @click="getUserAndUsers(pagination.url)"
                    :class="[pagination.active ? 'active-pagination' : '']"
                >
                    {{ pagination.label }}
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
            users: [],
            paginations: []
        };
    },
    methods: {
        isUserRow(currentUser){
          return currentUser.id === user.id;
        },

        updateUser(currentUser) {
            this.$router.push({
                name: 'editProfile',
                params: {
                    id: currentUser.id,
                    email: currentUser.email,
                    name: currentUser.name
                }
            });
        },

        swalDelete(afterConfirmCallback, text = '') {
            Swal.fire({
                title: "آیا از حذف اطمینان دارید",
                text: text,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "خیر",
                confirmButtonText: "بله، پاکش کن",
            }).then(result => result.isConfirmed && afterConfirmCallback());
        },

        deleteUser(currentUser) {
            this.swalDelete(() => {
                axios.delete(`users/${currentUser.id}`).then(response =>
                    this.getUserAndUsers("user-users")
                );
            })
        },
        cantDeleteItself(currentUser) {
            return currentUser.role.name !== 'admin' && currentUser.email !== this.user.email;
        },
        getUserAndUsers(url) {
            axios.post(url).then((response) => {
                this.user = response.data.user;
                this.users = response.data.users.data;
                this.paginations = response.data.users.links
            });
        },
        isAdmin(currentUser) {
            return !(currentUser.role.name === 'admin' && this.user.type !== 'admin');
        }
    },

    computed: {
        userHasAccessToCreate() {
            return this.user.type === 'admin' || this.user.type === 'manager';
        },
    },

    created() {
        this.getUserAndUsers("user-users");
    },
};
</script>
