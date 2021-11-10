<template>
    <div class="d-item-container">
        <div class="d-status-bar">

            <div class="between-flex" v-if="!isNormalUser">
                <router-link to="/create/reserving" class="d-add-item-cta mr-2">
                    <b-icon
                        icon="plus"
                        class="mr-2 text-gray-200"
                        font-scale="2"
                        variant="white"
                    ></b-icon>
                    <span> اضافه کردن رزرو/تعطیلات </span>
                </router-link>
                <a
                    class="d-delete-items-cta flex-center m-0"
                    v-if="selectedReserves.length"
                    @click="deleteReserves"
                >
                    <b-icon
                        class="mr-2 text-gray-200"
                        font-scale="2"
                        variant="white"
                        icon="x"></b-icon>
                    حذف رزروها
                </a>
            </div>

            <div>
                <!-- The modal -->
                <b-modal id="reserve-detail-modal" hide-footer>
                    <b-container>
                        <div class="rtl-dir text-sm chkout-dtil-cntinr">
                            <p class="checkout-room-details-header mt-0">
                                <strong>
                                    جزئیات رزرو :
                                </strong>
                            </p>
                            <div class="checkout-detail-row-container mb-2 flex-center">
                                <p class="checkout-details-txt-part">شماره تراکنش : </p>
                                <p class="checkout-details-value-part">{{ currentReserveDetails.payment.transaction_id
                                    }}</p>
                            </div>
                            <div class="checkout-detail-row-container mb-2 flex-center">
                                <p class="checkout-details-txt-part">مبلغ تراکنش : </p>
                                <p class="checkout-details-value-part">{{ currentReserveDetails.payment.amount }}</p>
                            </div>

                            <div class="checkout-detail-row-container mb-2 flex-center">
                                <p class="checkout-details-txt-part">زمان ثبت رزرو : </p>
                                <p class="checkout-details-value-part checkout-jalalian">{{
                                    currentReserveDetails.jalaliDate }}</p>
                            </div>

                            <template v-if="currentReserveDetails.optional_user.length">

                                <p class="checkout-room-details-header mt-12">
                                    <strong>
                                        دیگر افراد :
                                    </strong>
                                </p>

                                <table class="table user-list-table row-bordered-table">
                                    <thead>
                                    <tr class="row">
                                        <th class="col-6" scope="col">نام</th>
                                        <th class="col-5" scope="col">موبایل</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="(user, key) in currentReserveDetails.optional_user"
                                        class="row align-items-center"
                                        :key="key"
                                    >
                                        <!--user name-->
                                        <td class="col-6 user-lis-td">
                                            {{ user.name }}
                                        </td>
                                        <!--user email-->
                                        <td class="col-5 user-lis-td">
                                            {{ user.email }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </template>
                        </div>
                    </b-container>

                </b-modal>
            </div>
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

                <table class="table user-list-table row-bordered-table">
                    <thead>
                    <tr class="row">
                        <th class="col-1" scope="col"></th>
                        <th class="col-2" scope="col">وضعیت تراکنش</th>
                        <th class="col-2" scope="col">تعداد نفرات</th>
                        <th class="col-2" scope="col">تاریخ رزرو</th>
                        <th class="col-3" scope="col">اتاق</th>
                        <th class="col-2" scope="col">نام</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!---->
                    <tr
                        v-for="(reserve, key) in reserves"
                        class="row align-items-center"
                        :class="selectedReserves.includes(reserve.id) ? 'selected-row-checked-item' : ''"
                        :key="key"
                        @click="rowClicked(reserve)"
                    >
                        <td class="col-1 user-list-action-cl">
                            <b-icon
                                icon="three-dots-vertical"
                                @click.stop="reserveDetailClicked(reserve)"
                                class="dashboard-bootstrap-icon d-icon d-nav-icon">

                            </b-icon>
                        </td>

                        <!--  transaction status-->
                        <td class="col-2 user-lis-td" :style="`color:${getTransactionStatus(reserve).color} `">
                            <b-icon :icon="getTransactionStatus(reserve).icon"></b-icon>
                            {{ getTransactionStatus(reserve).label }}
                        </td>
                        <!-- people count -->
                        <td class="user-lis-td col-2">{{ reserve.people_count ? reserve.people_count : 'رزرو دستی' }}
                        </td>
                        <!--  reservation date-->
                        <td class="user-lis-td col-2">
                            <p class="td-first-bold-title ">{{ reserve.reservation_date }}</p>
                            <p class="td-second-title">{{ reserve.hour.start_time }}</p>
                        </td>
                        <!-- room name-->
                        <td class="user-lis-td col-3">
                            {{ reserve.room.name }}
                        </td>
                        <!-- person name-->

                        <td class="user-lis-td col-2">
                            <p class="td-first-bold-title ">{{ reserve.main_user[0].email }}</p>
                            <p class="td-second-title">{{ reserve.main_user[0].name }}</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="pagination-container">
                    <div
                        class="pagination-btns"
                        v-for="(pagination, key) in paginations"
                        :key="key"
                        @click="getReserveAndHolidays(pagination.url)"
                        :class="[pagination.active ? 'active-pagination' : '']"
                    >
                        {{ pagination.label }}
                    </div>
                </div>

            </div>

        </div>

    </div>
</template>

<script>

export default {
    data() {
        return {
            reserveOrHoliday: 'holiday',
            itemKey: '',
            reserves: [],
            selectedReserves: [],
            currentReserveDetails: {
                payment: {
                    transaction_id: '',
                    amount: '',
                    jalaliDate: '',
                },
                optional_user: []
            },
            transactionStatus: {
                processing: {
                    icon: 'clock-history',
                    color: '#d3d619',
                    label: 'در حال پردازش'
                },
                success: {
                    icon: 'check2',
                    color: 'green',
                    label: 'موفق'
                },
                failed: {
                    icon: 'x',
                    color: 'red',
                    label: 'ناموفق'
                },
                manual: {
                    icon: '-',
                    color: 'blue',
                    label: 'رزرو دستی'
                },
            },
            paginations: [],
        };
    },
    watch: {
        itemKey(val) {
            this.getReserveAndHolidays();
        }
    },

    methods: {
        deleteReserves() {
            let ids = JSON.stringify(this.selectedReserves);

            swalDelete(() => {
                axios.delete(`reservation/${ids}`).then(response => {
                    this.selectedReserves = [];
                    this.getReserveAndHolidays()
                })
            });
        },
        rowClicked(reserve) {
            if (this.selectedReserves.includes(reserve.id)) {
                this.selectedReserves = _.without(this.selectedReserves, reserve.id);
            } else {
                this.selectedReserves.push(reserve.id);
            }

            cc(this.selectedReserves);
        },
        reserveDetailClicked(reserve) {
            this.currentReserveDetails.payment = reserve.payment;
            this.currentReserveDetails.optional_user = reserve.optional_user;
            this.currentReserveDetails.jalaliDate = reserve.jalaliDate;

            this.$bvModal.show('reserve-detail-modal')
        },
        getTransactionStatus(reserve) {
            return {
                label: reserve.payment ? this.transactionStatus[reserve.payment.status].label : '',
                icon: reserve.payment ? this.transactionStatus[reserve.payment.status].icon : '',
                color: reserve.payment ? this.transactionStatus[reserve.payment.status].color : '',
            }
        },

        reserveOrHolidayClicked(type) {
            this.reserveOrHoliday = type;
        },

        getReserveAndHolidays(url = 'reservation/get') {
            axios.post(url, {key: this.itemKey}).then(response => {
                this.reserves = response.data.data;
                this.paginations = response.data.links;
            });
        }
    },

    computed: {
        isNormalUser() {
            return user.type === 'user';
        },
    },

    created() {
        this.getReserveAndHolidays();
    },
};
</script>
