<template>
    <div class="d-item-container">
        <div class="d-status-bar flex-end">
            <h3 class="create-media-title">
                عملیات رزرو و تعطیلی
            </h3>
        </div>

        <div class="d-form-container">
            <div class="small-alert">
                    <span>
                        در این مکان می توانید تعطیلی و رزرو را بصورت دستی انجام دهیی
                    </span>
                <b-icon icon="patch-exclamation" class="ml-2"></b-icon>
                <br>
                <span>
                        ابتدا اتاق موردنظر را انتخاب کنید تا تعطیلات و رزروها بر روی تقویم بارگزاری شود
                    </span>
            </div>

            <div class="d-form-row d-form flex-start">
                <div class="d-flex-30 ml-4 select-option mt-6">
                    <span class="d-form-lable">می خواهم : </span>
                    <div class="d-form-input">
                        <multiselect
                            v-model="tmp.option"
                            :options="selectOptions"
                            label="text"
                            track-by="action"
                            :searchable="false"
                            :show-labels="false"
                            @input="changeOption"
                            placeholder="انتخاب کنید ..">
                        </multiselect>
                    </div>
                </div>
            </div>

            <div class="d-form-row d-form flex-start" v-if="is.rooms.visible">
                <!-- rooms -->
                <div class="d-flex-30 ml-4 select-option">
                    <spinner :loading="is.rooms.loading" text="اتاق"></spinner>
                    <div class="d-form-input">
                        <multiselect
                            v-model="postData.room"
                            :options="rooms"
                            :searchable="true"
                            label="name"
                            track-by="id"
                            :show-labels="false"
                            @input="changeRoom"
                            placeholder="انتخاب کنید ..">
                        </multiselect>
                    </div>
                </div>
            </div>

            <!--  calendar-->
            <div class="d-form-row d-form flex-start" v-if="is.calendar.visible">
                <!-- date -->
                <div class="d-flex-30 ml-4">
                    <spinner :loading="is.calendar.loading" text="تقویم"></spinner>
                    <vue-persian-datetime-picker
                        v-model="postData.customReserves"
                        :multiple="current.option === 'doOpen' || current.option === 'doClose'"
                        clearable
                        :highlight="highlight"
                        :disabled="is.calendar.loading"
                        :auto-submit="current.option === 'doReserve' || current.option === 'doCloseHours'"
                        :disable="checkDate"
                        @change="changeDate"
                    >
                    </vue-persian-datetime-picker>
                </div>
            </div>

            <!--  days-->
            <div class="d-form-row d-form flex-start" v-if="is.days.visible">
                <div class="d-flex-30 ml-4 select-option">
                    <spinner :loading="is.days.loading" text="روز"></spinner>
                    <div class="d-form-input">
                        <multiselect
                            v-model="postData.day"
                            :options="days"
                            :searchable="false"
                            :disabled="is.days.loading"
                            :show-labels="false"
                            track-by="id"
                            @input="changeDay"
                            placeholder="انتخاب کنید ..">

                            <template slot="singleLabel" slot-scope="props">
                                <span class="option__title">
                                    {{ props.option.name }}
                                </span>
                            </template>

                            <template slot="option" slot-scope="props">
                                <span class="option__title">
                                    {{ props.option.name }}
                                </span>
                            </template>
                        </multiselect>
                    </div>
                </div>
            </div>


            <div class="short-description mt-8 mb-0 " v-if="currentOptionDescription">
                <img src="/images/icons/blue-grey-check.svg" class="ml-2 header-room-icons">
                <div class="mr-4">
                    {{ currentOptionDescription }}
                </div>
            </div>

            <div class="d-form-row d-form flex-start" v-if="is.hours.visible">
                <!-- hours -->
                <div class="d-flex-30 ml-4 select-option">
                    <spinner :loading="is.hours.loading" text="ساعت"></spinner>
                    <div class="d-form-input">
                        <multiselect
                            v-model="postData.hours"
                            :options="room.hours"
                            :searchable="false"
                            :disabled="is.hours.loading"
                            :show-labels="false"
                            :multiple="current.option === 'doCloseHours'"
                            :taggable="current.option === 'doCloseHours'"
                            :close-on-select="current.option !== 'doCloseHours'"
                            track-by="id"
                            placeholder="انتخاب کنید ..">

                            <template slot="tag" slot-scope="{ option, remove }">

                                <span class="custom__tag" @click="remove(option)">
                                    <span>{{ option.start_time }}</span>
                                    <span class="custom__remove">❌</span>
                                </span>
                            </template>
                            <template slot="singleLabel" slot-scope="props">
                                <span
                                    class="option__title">
                                    {{ props.option.start_time }}
                                </span>
                            </template>

                            <template slot="option" slot-scope="props">
                                <span class="option__title">
                                    {{ props.option.start_time }}
                                </span>

                                <span class="hour-range-price checkout-reserved-option"
                                      v-if="props.option.passedAway">
                                        زمان سپری شده
                                </span>
                                <template v-else>
                                    <span class="hour-range-price checkout-reserved-option"
                                          v-if="props.option.isReserved">
                                        رزرو شده
                                    </span>

                                </template>

                            </template>
                        </multiselect>
                    </div>
                </div>
            </div>

            <div class="d-create-entity-container">
                <div
                    v-if="is.calendar.visible || is.days.visible"
                    class="d-entity-cta d-make-entity high-order"
                    @click="mainAction"
                >
                    ثبت
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import VuePersianDatetimePicker from "vue-persian-datetime-picker";
import spinner from "../../packages/spinner";
import moment from 'moment-jalaali'

export default {
    components: {
        Multiselect,
        VuePersianDatetimePicker,
        spinner
    },
    data() {
        return {
            rooms: [],
            days: [],
            tmp: {
                option: '',
                hours: []
            },
            is: {
                calendar: {
                    visible: false,
                    loading: false,
                },
                rooms: {
                    visible: false,
                    loading: false,
                },
                days: {
                    visible: false,
                    loading: false,
                },
                hours: {
                    visible: false,
                    loading: false,
                }
            },
            current: {
                room: '',
                option: '',
            },
            calendar: {
                disableStatus: '',
                highlight: ''
            },
            showCalendar: true,
            showHours: false,
            currentRoom: '',
            room: {
                customReserves: [],
                ordinaryReserves: [],
                hours: [],
                reservations: [],
                closedHours: [],
            },
            postData: {
                room: '',
                hours: '',
                customReserves: [],
                actionType: '',
                day: '',
            },
        };
    },
    methods: {
        changeOption(option) {
            this[this.postData.actionType = this.current.option = option.action]();
            this.do(['rooms']).show();
            this.do(['calendar', 'hours', 'days']).hide();
            this.resetValues();
        },
        do(entities) {
            let actionOnEntity = (actionOnEntity) => {
                entities.forEach(entity => actionOnEntity(this.is[entity]));
            }

            return {
                hide: () => actionOnEntity(entity => entity.visible = false),
                show: () => actionOnEntity(entity => entity.visible = true),
                load: () => actionOnEntity(entity => entity.loading = true),
                unLoad: () => actionOnEntity(entity => entity.loading = false),
            }
        },
        doReserve() {

            //~~ disable calendar days
            this.calendar.disableStatus = (formatted, dateMoment) => {

                if (this.passedAway(dateMoment)) return true;
                if (this.hasOrdinaryHoliday(dateMoment.day()) && this.hasCustomHoliday(formatted)) return false;

                return this.hasOrdinaryHoliday(dateMoment.day())
                    || this.hasCustomHoliday(formatted)
                    || this.hasFullyReserved(formatted);
            }

            //~~ calendar highlight
            this.calendar.highlight = (formatted, dateMoment) =>
                this.calendarHighlightAttribute(formatted, dateMoment);
        },
        doOpen() {
            this.calendar.disableStatus = (formatted, dateMoment) => {
                if (this.passedAway(dateMoment) || this.hasFullyReserved(formatted)) return true;
                if (this.hasOrdinaryHoliday(dateMoment.day()) && this.hasCustomHoliday(formatted)) return true;

                return !(this.hasCustomHoliday(formatted) || this.hasOrdinaryHoliday(dateMoment.day()))
            }

            //~~ calendar highlight
            this.calendar.highlight = (formatted, dateMoment) => {
            };
        },
        doClose() {
            this.calendar.disableStatus = (formatted, dateMoment) => {

                if (this.passedAway(dateMoment) || this.hasReservedBefore(formatted)) return true;

                if (this.hasCustomHoliday(formatted) && this.hasOrdinaryHoliday(dateMoment.day())) return false;

                return this.hasOrdinaryHoliday(dateMoment.day())
                    || this.hasCustomHoliday(formatted)

            }

            //~~ calendar highlight
            this.calendar.highlight = (formatted, dateMoment) => ({
                class: this.hasReservedBefore(formatted) ? 'extra-holiday' : '',
                title: this.hasFullyReserved(formatted) ? 'رزرو کامل' : (this.hasReservedBefore(formatted) ? 'روز دارای رزرو' : '')
            });
        },
        doCloseHours() {
            this.doReserve();
        },
        passedAway(dateMoment) {
            return dateMoment.diff(moment(), 'hours') < -12;
        },
        changeDate(e) {
            if (this.current.option !== 'doReserve') {
                this.postData.customReserves = e.map(momentObject => momentObject.format('jYYYY/jMM/jDD'));
                return;
            }

            this.do(['hours']).show();

            this.postData.customReserves = e.format('jYYYY/jMM/jDD');
            let selectedDayName = e.format('dddd'),
                untilDay = e.format('YYYY-MM-DD');

            this.room.hours = this.tmp.hours.filter(hour =>
                !this.room.closedHours.some(closedHour =>
                    closedHour.day.number === e.day() &&
                    closedHour.hour.id === hour.id
                )
            ).map(hour => {

                //~~ selected sans by full date and hour
                let selectedSans = moment(`${untilDay} ${hour.start_time}`);

                let hourObject = {
                    id: hour.id,
                    start_time: hour.start_time,
                    end_time: hour.end_time,
                };

                if (selectedSans.diff(moment(), 'minutes') < backSansPassedTime) {
                    hourObject.$isDisabled = true;
                    hourObject.passedAway = true;
                }

                //~~ if selected sans is successfully reserved
                this.room.reservations.filter(reservation =>

                    reservation.reservation_date === this.postData.customReserves
                    && reservation.hour_id === hour.id
                    && (reservation.payment.status === "success" || reservation.payment.status === "manual")
                ).map(reservation => {
                    hourObject.$isDisabled = true;
                    hourObject.isReserved = true;
                })


                return hourObject;
            });
        },
        calendarHighlightAttribute(formatted, dateMoment) {
            let attributes = {};

            if (this.hasFullyReserved(formatted)) {
                attributes['class'] = 'extra-holiday';
                attributes['title'] = 'رزرو کامل';

            } else if (this.hasReservedBefore(formatted)) {
                attributes['class'] = 'extra-holiday';
                attributes['title'] = 'روز دارای رزرو';

            } else if (this.hasOrdinaryHoliday(dateMoment.day()) && this.hasCustomHoliday(formatted)) {

            } else if (this.hasOrdinaryHoliday(dateMoment.day())) {
                attributes['title'] = 'تعطیلات عادی اتاق'
            } else if (this.hasCustomHoliday(formatted)) {
                attributes['title'] = 'تعطیلات خارج از عرف اتاق'
            }

            return attributes;
        },
        changeRoom(room) {
            this.do(['calendar', 'hours', 'rooms', 'days']).load();
            this.postData.customReserves = '';
            this.postData.hours = '';

            axios.get(`reservation/${room.id}`).then(response => {
                this.room = response.data;
                this.tmp.hours = response.data.hours;

                let nexStep = this.current.option === 'doCloseHours' ? 'days' : 'calendar';

                this.do([nexStep]).show();
                this.do(['calendar', 'hours', 'rooms', 'days']).unLoad();
            })
        },
        changeDay(day) {
            this.do(['hours']).show();
            this.postData.hours = this
                .room
                .closedHours
                .filter(closedHour => closedHour.day_id === day.id)
                .map(closedHour => closedHour.hour)
        },
        mainAction() {
            axios.post('reservation', this.postData).then(() => {
                this.resetValues();
            })
        },
        highlight(formatted, dateMoment, checkingFor) {
            return this.calendar.highlight(formatted, dateMoment);
        },
        hasFullyReserved(day) {

            return this.room.hours.reduce((acc, hour) => {
                return acc && this.room.reservations.some(reservation => {

                        return reservation.reservation_date === day
                            && reservation.hour_id === hour.id
                            && (reservation.payment ? reservation.payment.status === "success" : false);
                    }
                )
            }, true);
        },

        hasReservedBefore(day) {
            return this.room.reservations.some(reserve => {
                return reserve.reservation_date === day
                    && (reserve.payment.status === 'success' || reserve.payment.status === 'manual')
            });
        },
        hasOrdinaryHoliday(day) {
            return this.room.ordinaryReserves.some(holidayDay => holidayDay.number == day);
        },
        hasCustomHoliday(day) {
            return this.room.customReserves.some(customReserve => customReserve.date == day);
        },

        checkDate(formatted, dateMoment, checkingFor) {
            return this.calendar.disableStatus(formatted, dateMoment);
        },

        resetValues() {
            this.postData.room = '';
            this.postData.customReserves = [];
            this.postData.hours = [];
            this.postData.day = '';
        },

        reserveOrHolidayClicked(type) {
            this.postData.reserveOrHoliday = type;
            this.resetValues()
        },
        getInitialEntities() {
            axios.get('reservation').then(response => {
                this.rooms = response.data.rooms;
                this.days = response.data.days;
            });
        }
    },

    computed: {
        currentOptionDescription() {
            let selectedOption = this.selectOptions.filter(selectOption =>
                selectOption.action === this.current.option
            );
            return selectedOption[0] ? selectedOption[0].description : '';
        },
        selectOptions() {

            let options = [
                {
                    action: 'doReserve',
                    text: 'بصورت دستی رزرو کنم',
                    description: 'در صفحه کاربر این ساعت ها با عنوان رزرو شده نمایش داده می شوند'
                },
                {
                    action: 'doOpen',
                    text: 'چند روز تعطیل را باز کنم',
                    description: 'روزهای تعطیل شده در صفحه کاربر غیرفعال می شوند'
                },
                {
                    action: 'doClose',
                    text: 'چند روز باز را تعطیل کنم',
                    description: 'روزهای باز شده در صفحه کاربر قابل رزرو کردن هستند'
                },
            ];

            user.isManager() && options.push({
                action: 'doCloseHours',
                text: 'چند سانس را ببندم',
                description: 'سانس های بسته شده در لیست ساعت های کاربر سایت نشان داده نمی شوند.'
            });

            return options
        }
    },

    created() {

        user.isManager = function () {
            return this.type === 'admin' || this.type === 'manager'
        }

        this.getInitialEntities()
    }
};
</script>
