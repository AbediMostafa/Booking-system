<template>
    <div class="d-item-container" v-if="true">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">تنظیمات رزرو</h3>
        </div>

        <div>
            <!-- The modal -->
            <b-modal id="reserve-detail-modal" hide-footer>
                <b-container>
                    <div class="rtl-dir text-sm chkout-dtil-cntinr">
                        <p class="checkout-room-details-header mt-0">
                            <strong>
                                بروزرسانی
                                {{ update.name }}
                            </strong>
                        </p>

                        <div class="mt-8">
                            <b-form class="flex-start">
                                <b-form-input
                                    id="inline-form-input-name"
                                    class="mb-2 mr-sm-2 mb-sm-0 mw-12 fs-"
                                    placeholder="نام جدید"
                                    v-model="update.value"
                                    required
                                ></b-form-input>

                                <b-button variant="success" @click="updateType" class="mr-4 btn-sm">
                                    <span>بروزرسانی</span>
                                </b-button>
                            </b-form>
                        </div>

                    </div>
                </b-container>

            </b-modal>
        </div>

        <div class="d-form-container">
            <h1 class="fs-5 mb-5"> انواع تعطیلات</h1>
            <div class="accordion" role="tablist">
                <b-card no-body class="mb-1" v-for="(holiday, key) in holidays" :key="key">
                    <b-card-header header-tag="header" class="p-1" role="tab">

                        <b-list-group-item class="d-flex justify-content-between align-items-center text-muted"
                                           v-b-toggle="`accordion-${key}`">
                            <small>
                                {{ holiday.name }}

                            </small>

                            <div>
                                <b-icon icon="pencil-square" variant="success" class="ml-2"
                                        @click="updateEntity('holiday', holiday)"></b-icon>
                                <b-icon icon="trash" variant="danger" @click="deleteHoliday(holiday.id)"></b-icon>
                            </div>

                        </b-list-group-item>
                    </b-card-header>
                    <b-collapse :id="`accordion-${key}`" visible accordion="my-accordion" role="tabpanel">
                        <b-card-body>
                            <div class="flex-start flex-wrap">

                                <button
                                    v-for="(day, key) in holiday.days"
                                    type="button"
                                    :key="key"
                                    :class="['btn btn-sm ml-2 mt-2', day.active ? 'btn-primary' : 'btn-outline-primary']"
                                    @click="day.active = !day.active "
                                >
                                    {{ day.name }}
                                </button>
                            </div>

                            <a @click="addHolidayDays(holiday.id,holiday.days)" class="btn btn-success mt-2 text-white">ثبت</a>

                        </b-card-body>
                    </b-collapse>
                </b-card>


                <div class="mt-8">
                    <b-form class="flex-start">
                        <b-form-input
                            id="inline-form-input-name"
                            class="mb-2 mr-sm-2 mb-sm-0 mw-12 fs-"
                            placeholder="تعطیلات جدید"
                            v-model="newHoliday"
                            required
                        ></b-form-input>

                        <b-button variant="success" @click="addHoliday" class="mr-4 btn-sm">
                            <span>تعطیلات جدید</span>
                            <b-icon icon="plus" font-scale="1"></b-icon>
                        </b-button>
                    </b-form>
                </div>
            </div>

            <hr class="my-5">

            <h1 class="fs-5 mb-5">ساعات روز</h1>
            <div class="accordion" role="tablist">
                <b-card no-body class="mb-1" v-for="(hourType, key) in hourTypes" :key="key">
                    <b-card-header header-tag="header" class="p-1" role="tab">

                        <b-list-group-item class="d-flex justify-content-between align-items-center text-muted"
                                           v-b-toggle="`accordion-${key}`">
                            <small>
                                {{ hourType.name }}

                            </small>

                            <div>
                                <b-icon icon="pencil-square" variant="success" class="ml-2"
                                        @click="updateEntity('hourType', hourType)"></b-icon>
                                <b-icon icon="trash" variant="danger"
                                        @click="deleteHoliday(hourType.id)"></b-icon>
                            </div>
                        </b-list-group-item>
                    </b-card-header>
                    <b-collapse :id="`accordion-${key}`" visible accordion="my-accordion" role="tabpanel">
                        <b-card-body>
                            <div class="flex-start flex-wrap">

                                <button
                                    v-for="(hour, key) in hourType.hours"
                                    type="button"
                                    :key="key"
                                    :class="['btn btn-sm ml-2 mt-2', hour.active ? 'btn-primary' : 'btn-outline-primary']"
                                    @click="hour.active = !hour.active "
                                >
                                    {{ hour.start_time}}
                                </button>
                            </div>

                            <a @click="addHourTypeHours(hourType.id,hourType.hours)"
                               class="btn btn-success mt-2 text-white">ثبت</a>

                        </b-card-body>
                    </b-collapse>
                </b-card>


                <div class="mt-8">
                    <b-form class="flex-start">
                        <b-form-input
                            id="inline-form-input-name"
                            class="mb-2 mr-sm-2 mb-sm-0 mw-12 fs-"
                            placeholder="ساعات روز جدید"
                            v-model="newHourType"
                            required
                        ></b-form-input>

                        <b-button variant="success" @click="addHourType" class="mr-4 btn-sm">
                            <span>ثبت</span>
                            <b-icon icon="plus" font-scale="1"></b-icon>
                        </b-button>
                    </b-form>
                </div>
            </div>

            <hr class="my-5">

            <b-row class="justify-content-end">
                <div class="col-md-6">
                    <h1 class="fs-5 mb-5">تعریف ساعت ها</h1>
                    <div class="row justify-content-end my-2">
                        <date-picker
                            v-model="timeDefinition.start"
                            type="time"
                            class="col-auto"
                        />
                        <span class="col-auto">
                            زمان شروع سانس
                        </span>
                    </div>

<!--                    <div class="row justify-content-end my-2">-->
<!--                        <date-picker-->
<!--                            v-model="timeDefinition.end"-->
<!--                            type="time"-->
<!--                            class="col-auto"-->
<!--                        />-->
<!--                        <span class="col-auto">-->
<!--                                زمان پایان-->
<!--                            </span>-->
<!--                    </div>-->

                    <a href="#" class="btn btn-primary" @click="submitNewTimeRange">ثبت زمان</a>
                </div>
                <div class=" flex flex-end flex-wrap mt-4">
                    <div
                        v-for="(hour, key) in hours"
                        :key="key"
                        class="hour-types"
                    >
                        <span dir="rtl" class="mr-2">
                            {{ hour.start_time}}
                        </span>
                        <img src="images/icons/trash.svg" @click.stop="deleteHour(hour.id)" class="hour-types-icon">
                    </div>
                </div>
            </b-row>

        </div>
    </div>

    <div class="alert alert-danger" v-else>
        شما اجازه دسترسی به این صفحه را ندارید
    </div>

</template>

<script>
import datePicker from "vue-persian-datetime-picker";

export default {
    components: {
        datePicker,
    },
    data() {
        return {
            holidays: [],
            days: [],
            hourTypes: [],
            hours: [],
            newHoliday: '',
            newHourType: '',
            timeDefinition: {
                start: '',
                end: ''
            },

            update: {
                type: '',
                name: '',
                value: '',
                id: ''
            },
        };
    },
    methods: {

        updateEntity(type, object) {
            this.update.id = object.id;
            this.update.name = object.name;
            this.update.type = type;
            this.update.value = '';
            this.$bvModal.show('reserve-detail-modal');
        },

        updateType() {

            let data = this.update;

            axios.post('hour-types/update', data).then(response => {
                this.update.type === 'holiday' ? this.getHolidays() : this.getHourTypes();
                this.$bvModal.hide('reserve-detail-modal');
            });
        },

        addHourType() {
            axios.post('hour-types', {name: this.newHourType}).then(response => this.getHourTypes())
        },
        addHourTypeHours(hourTypeId, hourTypeHours) {

            let hourIds = hourTypeHours
                .filter(hour => hour.active)
                .map(hour => hour.id);

            axios.put(`hour-types/${hourTypeId}`, {hourIds})
        },

        deleteHour(id) {
            this.swalDelete(() => {
                this.swalDelete(() => {
                    axios.delete(`hours/${id}`).then(response => this.getHourTypes())
                }, 'مطمئن هستید؟')
            }, 'با پاک کردن این ساعت، تمام رزروهایی که در این ساعت انجام شده اند پاک خواهند شد. از ادامه روند اطمینان  دارید؟')
        },

        submitNewTimeRange() {

            axios.post('hours', {
                start_time: this.timeDefinition.start,
                end_time: this.timeDefinition.end,
            }).then(response => {
                this.getHourTypes();
            })
        },

        addHolidayDays(holidayId, holidayDays) {

            let days = holidayDays
                .filter(holidayDay => holidayDay.active)

            axios.post(`add-holiday-day/${holidayId}`, {days})
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

        deleteHoliday(holidayId) {
            this.swalDelete(() => {
                axios.post(`delete-holiday/${holidayId}`).then(reseponse => {
                    this.getHolidays();
                });
            })
        },
        iconPath(icon) {
            return sot.iconPath(icon);
        },

        addHoliday() {
            axios.post('add-holiday', {name: this.newHoliday}).then(response => {
                this.$set(
                    this.holidays,
                    this.holidays.length,
                    {
                        id: response.data.holidayId,
                        name: this.newHoliday,
                        days: this.days.map(
                            day => ({
                                active: false,
                                name: day.name,
                                id: day.id
                            })
                        )
                    }
                );
            });
        },

        getHolidays() {
            axios.post('holiday-days').then(response => {
                this.days = response.data.days;

                this.holidays = response.data.holidayTypes.map(
                    holidayType => ({
                        name: holidayType.name,
                        id: holidayType.id,

                        days: response.data.days.map(
                            day => ({
                                name: day.name,
                                id: day.id,
                                active: holidayType.days.some(
                                    holidayDay => holidayDay.name == day.name
                                )
                            })
                        )
                    })
                );
            });
        },

        getHourTypes() {
            axios.get('hour-types').then(response => {
                this.hours = response.data.hours;
                this.hourTypes = response.data.hourTypes.map(
                    hourType => ({
                        name: hourType.name,
                        id: hourType.id,

                        hours: response.data.hours.map(
                            hour => ({
                                id: hour.id,
                                start_time: hour.start_time,
                                end_time: hour.end_time,
                                active: hourType.hours.some(
                                    hourTypeHour => hourTypeHour.id == hour.id
                                )
                            })
                        )
                    })
                );
            });
        }
    },

    computed: {
        userHasAccessToCreate() {
            return user.type === 'admin' || user.type === 'manager';
        }
    },
    created() {
        this.getHolidays();
        this.getHourTypes();
    }
};
</script>

<style scoped>
.d-form-container {
    padding: 1.5rem;
    text-align: right;
    font-size: 0.9rem;
    color: var(--second-color);
    margin: 2rem 0;
}

.btn-group li {
    font-size: 0.9rem;
    color: #aab3b9;
}

.create-media-title {
    margin: 0.5rem;
    color: var(--second-color);
}

</style>
