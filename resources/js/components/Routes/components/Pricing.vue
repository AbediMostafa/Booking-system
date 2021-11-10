<template>
    <div class="d-item-container" v-if="true">
        <div class="d-status-bar">
            <router-link to="/create/price" class="d-add-item-cta">
                <b-icon
                    icon="plus"
                    class="mr-2 text-gray-200"
                    font-scale="2"
                    variant="white"
                ></b-icon>
                <span> اضافه کردن قیمت جدید </span>
            </router-link>
            <div class="search-container">
                <b-icon
                    icon="search"
                    class="search-icon top-5"
                    font-scale="2"
                    variant="secondary"
                ></b-icon>
                <input
                    type="text"
                    class="d-search-input pr-10"
                    v-model="itemKey"
                    placeholder="جستجو بر روی اتاق ها"
                />
            </div>
        </div>

        <div>
            <div class="d-form-container">
                <table class="table table-hover user-list-table">
                    <thead>
                    <tr class="row">
                        <th class="col-1" scope="col">عملیات</th>
                        <th scope="col" class="col-2">قیمت</th>
                        <th scope="col" class="col-3">ساعت</th>
                        <th scope="col" class="col-3">روز</th>
                        <th scope="col" class="col-3">اتاق</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(customPrice, key) in CustomPrices" class="row">
                        <td class="col-1 user-list-action-cl">
                            <b-icon
                                @click="deletePrice(customPrice)"
                                icon="trash"
                                class="dashboard-bootstrap-icon d-icon d-nav-icon"></b-icon>
                        </td>
                        <td class="user-lis-td col-2">
                            <span class="ml-2">
                                {{ customPrice.price }}
                            </span>
                        </td>
                        <td class="user-lis-td col-3">{{ customPrice.hour?customPrice.hour.start_time:'' }}
                        </td>
                        <td class="user-lis-td col-3">{{ customPrice.day?customPrice.day.name:'' }}</td>
                        <td class="user-lis-td col-3">{{ customPrice.room? customPrice.room.name:'' }}</td>

                    </tr>
                    </tbody>
                </table>
                <div class="pagination-container">
                    <div
                        class="pagination-btns"
                        v-for="(pagination, key) in paginations"
                        :key="key"
                        @click="getPrices(pagination.url)"
                        :class="[pagination.active ? 'active-pagination' : '']"
                    >
                        {{ pagination.label }}
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="alert alert-danger" v-else>
        شما اجازه دسترسی به این صفحه را ندارید
    </div>
</template>

<script>
export default {
    data() {
        return {
            CustomPrices: {},
            paginations: {},
            currentUrl: "",
            itemKey: '',
            search: {
                price: '',
                hour: '',
                day: '',
                room: '',
            }
        };
    },
    watch: {
        itemKey(val) {
            this.getPrices('custom-prices/search');
        }
    },
    methods: {

        deletePrice(customPrice) {
            swalDelete(() =>
                axios
                    .delete(`custom-prices/${customPrice.id}`)
                    .then(response => {
                        this.getPrices(this.currentUrl);
                    })
            )
        },
        getPrices(url) {
            this.currentUrl = url
            axios.post(url, {room: this.itemKey}).then((response) => {
                this.CustomPrices = response.data.data;
                this.paginations = response.data.links;
            });
        },
    },

    computed: {
        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        }
    },

    created() {
        this.getPrices("custom-prices/search");
    },
};
</script>
