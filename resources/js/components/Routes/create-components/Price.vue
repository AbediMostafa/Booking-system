<template>
    <div class="d-item-container">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">
                قیمت جدید
            </h3>
        </div>

        <div class="d-form-container" v-if="userHasAccessToCreate">

            <div class="d-form-row d-form flex-start">
                <!-- rooms -->
                <div class="mb-4 d-flex-30 ml-4">
                    <span class="d-form-lable">اتاق</span>
                    <div class="d-form-input">
                        <multiselect
                            v-model="postData.room"
                            :options="rooms"
                            label="name"
                            track-by="id"
                            :taggable="true"
                            :selectLabel="''"
                            placeholder="انتخاب کنید ..">
                        </multiselect>

                    </div>

                </div>

                <!-- days -->
                <div class="mb-4 d-flex-30 ml-4">
                    <span class="d-form-lable">روز</span>
                    <div class="d-form-input">
                        <multiselect
                            v-model="postData.day"
                            :options="days"
                            label="name"
                            track-by="id"
                            :selectLabel="''"
                            placeholder="انتخاب کنید ..">
                        </multiselect>

                    </div>

                </div>
            </div>

            <div class="d-form-row d-form flex-start">
                <!-- hours -->
                <div class="mb-4 d-flex-30 ml-4">
                    <span class="d-form-lable">ساعت ها</span>
                    <div class="d-form-input">
                        <multiselect
                            v-model="postData.hour"
                            :options="hours"
                            :selectLabel="''"
                            label="name"
                            track-by="id"
                            placeholder="انتخاب کنید ..">
                        </multiselect>
                    </div>
                </div>

                <!-- price -->
                <div class="mb-4 d-flex-30 ml-4">
                    <span class="d-form-lable">قیمت</span>
                    <div class="d-form-input">
                        <input
                            type="text"
                            class="d-search-input"
                            v-model="postData.price"
                        />
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
                    @click="addPrice"
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
            errors: [],
            rooms: [],
            days: [],
            hours: [],
            tmpHours: [],
            customPrices: [],
            roomPrice: '',
            postData: {
                room: '',
                day: '',
                hour: '',
                price: '',
            },
        };
    },
    methods: {

        customTimeLabel(option) {
            return option.start_time
        },

        resetPostData() {
            this.postData = {
                room: '',
                day: '',
                hour: '',
                price: '',
            };
        },

        addPrice() {

            let data = {
                'room_id': this.postData.room.id,
                'day_id': this.postData.day.id,
                'hour_id': this.postData.hour.id,
                'price': this.postData.price,
            }

            axios.post(`custom-prices`, data).then(response => this.resetPostData());
        },
        getRooms() {
            axios.get("custom-prices/create").then((response) => {
                this.rooms = response.data.rooms;
            });
        },

        getDays(id) {

            axios.get(`custom-prices/${id}`).then(response => {
                this.days = response.data.days.map(day => ({
                        id: day.id,
                        name: day.name,
                        $isDisabled: response.data.holidayDays.some(holidayDay => holidayDay.id === day.id)
                    })
                );

                this.tmpHours = response.data.hours;
                this.customPrices = response.data.customPrices;
                this.roomPrice = response.data.roomPrice;
            })
        },

        getHours(day) {
            this.hours = this.tmpHours.map(hour => {
                let matchedPrice = this.customPrices.filter(customPrice =>
                    customPrice.day_id === day.id && customPrice.hour_id === hour.id
                    ),
                    price = matchedPrice.length ? matchedPrice[0].price : this.roomPrice;

                return {
                    id: hour.id,
                    name: `${hour.start_time} (${price} تومان)`
                }
            });
        }
    },

    computed: {
        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        }
    },

    watch: {
        'postData.room'(room) {
            room && this.getDays(room.id);
        },

        'postData.day'(day) {
            day && this.getHours(day);
        }
    },

    created() {
        this.getRooms();
    },
};
</script>
