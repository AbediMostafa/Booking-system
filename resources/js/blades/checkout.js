import HeaderPart from '../components/packages/Header-part.vue';
import vueselect from "v-select2-component";
import Multiselect from "vue-multiselect";
import moment from 'moment-jalaali'


const vue = new Vue({
    el: '#app',
    components: {
        HeaderPart,
        vueselect,
        Multiselect
    },

    data: {
        headerInfos: {
            imageSrc: sot.absImgPath('carousel/2.jpg'),
        },
        tmpDay: '',
        tmpHour: '',

        room: {
            customReserves: [],
            ordinaryReserves: [],
            hours: [],
            arrangedHours: [],
            reservations: [],
            peopleCount: [],
            customPrice: [],
            name: '',
            image: '',
            address: '',
            price: '',
            days: [],
            ticketCount: '',
        },

        postData: {
            day: '',
            hour: '',
            peopleCount: '',
            price: '',
            hourRange: '',
            reservedPersons: [],
            prePayed: '',
            roomId,
            totalAmount: '',
        }
    },

    methods: {

        change(e) {

            this.tmpHour = ''
            this.postData.day = e.format('jYYYY/jMM/jDD');
            let selectedDayName = e.format('dddd'),
                untilDay = e.format('YYYY-MM-DD');

            this.room.arrangedHours = this.room.hours.filter(hour =>
                !this.room.closedHours.some(closedHour =>
                    closedHour.day.number === e.day() &&
                    closedHour.hour.id === hour.id
                )
            ).map(hour => {

                //~~ selected sans by full date and hour
                let selectedSans = moment(`${untilDay} ${hour.start_time}`);

                let hourObject = {
                    id: hour.id,
                    price: this.room.price,
                    hourRange: hour.start_time
                };

                if (selectedSans.diff(moment(), 'minutes') < 30) {
                    hourObject.$isDisabled = true;
                    hourObject.passedAway = true;
                }

                this.room.customPrice.filter(customPrice => {
                        return customPrice.day.name === selectedDayName && customPrice.hour.id === hour.id
                    }
                ).map(customPrice => {
                    hourObject.price = customPrice.price;
                });

                //~~ if selected sans is successfully reserved
                this.room.reservations.filter(reservation =>

                    reservation.reservation_date === this.postData.day
                    && reservation.hour_id === hour.id
                    && (reservation.payment.status === "success" || reservation.payment.status === "manual")
                ).map(reservation => {
                    hourObject.$isDisabled = true;
                    hourObject.isReserved = true;
                })

                return hourObject;
            });

            this.addPersons();
        },
        pay() {
            this.$refs.checkoutForm.submit();
        },
        addPersons() {
            if (this.prevFormfilled) {
                this.postData.reservedPersons = _.range(this.postData.peopleCount).map(() => ({
                    name: '',
                    phone: ''
                }));

                this.postData.totalAmount = this.postData.price * this.postData.peopleCount;
                let prePayed = this.room.ticketCount * this.postData.price;

                this.postData.prePayed = prePayed >= this.postData.totalAmount ? this.postData.totalAmount : prePayed;
            }
        },
        hourChanged({id, price, hourRange}) {

            this.postData.hour = id;
            this.postData.price = price;
            this.postData.hourRange = hourRange;

            this.addPersons();
        },
        peopleCountChanged(count) {
            this.postData.peopleCount = count.id;
            this.addPersons();
        },
        getRoomDetails() {
            axios.get(`/checkout-process/${roomId}`).then(response => {
                this.room = response.data;
                this.room.arrangedHours = this.room.hours.map(
                    hour => ({
                        id: hour.id,
                        price: this.room.price,
                        hourRange: hour.start_time
                    })
                )
            });
        },
        highlight(formatted, dateMoment, checkingFor) {
            let formattedDay = formatted.split('-')[1],
                attributes = {};

            if (this.hasFullyReserved(formattedDay)) {
                attributes['class'] = 'extra-holiday';
            }

            return attributes;
        },
        checkDate(formatted, dateMoment, checkingFor) {
            let formattedDay = formatted.split('-')[1];

            if (this.passedAway(dateMoment)) {
                return true;
            }

            if (this.hasOrdinaryHoliday(dateMoment.day())
                && this.hasCustomHoliday(formattedDay)
            ) {
                return false;
            }

            //~~ if we have holidays
            return this.hasOrdinaryHoliday(dateMoment.day())
                //~~ or we hove custom holiday
                || this.hasCustomHoliday(formattedDay)
                //~~ or day have fully reserved
                || this.hasFullyReserved(formattedDay)
                //~~ or day passed away
                || this.passedAway(dateMoment)
        },

        passedAway(dateMoment) {
            return dateMoment.diff(moment(), 'hours') < -12;
        },
        hasFullyReserved(day) {
            return this.room.hours.reduce((acc, hour) => {
                return acc && this.room.reservations.some(reservation => {

                        return reservation.reservation_date === day
                            && reservation.hour_id === hour.id
                            && (reservation.payment.status === "success" || reservation.payment.status === "manual")
                    }
                )
            }, true);
        },
        hasReservedBefore(day) {
            return this.room.reservations.some(reserve => reserve.reservation_date == day);
        },
        hasOrdinaryHoliday(day) {
            return this.room.ordinaryReserves.some(holidayDay => holidayDay.number == day);
        },
        hasCustomHoliday(day) {
            return this.room.customReserves.some(customReserve => customReserve.date == day);
        },
        repopulateOldValues() {

            let validationObject = JSON.parse(validationData);

            this.postData = validationObject.postData;
            this.tmpDay = validationObject.tmpDay;
            this.tmpHour = validationObject.tmpHour;
        },
    },

    computed: {
        imagePath() {
            return this.room.image ? this.room.image : sot
        },

        remainedAmount() {
            return this.postData.totalAmount - this.postData.prePayed;
        },

        prevFormfilled() {
            return this.postData.day && this.postData.hour && this.postData.peopleCount;
        },

        jsonPostData() {
            let data = {
                postData: this.postData,
                tmpDay: this.tmpDay,
                tmpHour: this.tmpHour,
            }

            return JSON.stringify(data);
        }
    },

    created() {

        errors.length && displayErrors(JSON.parse(errors), value => value[0])
        errorMessage && displayErrors([errorMessage], value => value)
        validationData && this.repopulateOldValues();

        this.getRoomDetails();
    }
});
