@extends('layouts.layout')
@section('content')
    <section class="hiro">
        <div class="container pb-4">
            <div class="header-filter-container">
                <header-part :info="headerInfos"></header-part>
            </div>
        </div>
    </section>
    <section class="reserve">
        <div class="container">
            <div class="rs-box-shadow rtl-dir">
                <div class="rsd-image-text-container items-center">
                    <div class="checkout-room-details">
                        <div class="checkout-image-container">
                            <div class="learning-card-image"
                                 :style="`background: url('${room.image}') center center / cover no-repeat;`">
                            </div>
                        </div>

                        <div @click="pay">
                            <p class="checkout-room-infos"> اتاق فرار
                                @{{room.name}}
                            </p>
                            <p class="d-form-lable mb-0">@{{room.address}}</p>
                        </div>

                    </div>

                    <div class="checkout-options">
                        <div class="checkout-each-option">
                                <span class="d-form-lable ml-4 d-flex-4rem">
                                روز
                                    :
                                </span>
                            <div class="checkout-inputs">
                                <vue-persian-datetime-picker
                                    v-model="tmpDay"
                                    clearable
                                    :highlight="highlight"
                                    :disable="checkDate"
                                    auto-submit
                                    format="dddd-jYYYY/jMM/jDD"
                                    display-format="dddd jDD jMMMM jYYYY"
                                    color="#860cab"
                                    @change="change"
                                >
                                </vue-persian-datetime-picker>
                            </div>
                        </div>

                        <div v-if="tmpDay" class="mt-6 checkout-each-option">
                            <span class="d-form-lable ml-4 d-flex-4rem">
                                ساعت
                            :
                            </span>
                            <div class="checkout-inputs">

                                <multiselect
                                    class="vue-select1"
                                    :options="room.arrangedHours"
                                    :searchable="false"
                                    track-by="id"
                                    :show-labels="false"
                                    label="hourRange"
                                    v-model="tmpHour"
                                    @select="hourChanged"
                                    placeholder="انتخاب کنید ..">

                                    <template slot="singleLabel" slot-scope="props">
                                        <span class="option__title">@{{ props.option.hourRange }}</span>
                                        <span class="hour-range-price">@{{ props.option.price }} تومان</span>
                                    </template>
                                    <template slot="option" slot-scope="props">
                                        <span class="option__title">@{{ props.option.hourRange }}</span>
                                        <span class="hour-range-price">@{{ props.option.price }} تومان</span>
                                        {{--                                        v-if="props.option.isReserved"--}}
                                        <span class="hour-range-price checkout-reserved-option"
                                              v-if="props.option.isReserved">
                                                رزرو شده
                                        </span>
                                        <span class="hour-range-price checkout-reserved-option"
                                              v-if="props.option.passedAway">
                                                زمان سپری شده
                                        </span>
                                    </template>
                                </multiselect>
                            </div>
                        </div>

                        <div v-if="tmpDay" class="mt-6 checkout-each-option">
                            <span class="d-form-lable ml-4 d-flex-4rem">
                                تعداد افراد
                             :
                            </span>
                            <div class="checkout-inputs">
                                <vueselect
                                    class="vue-select1"
                                    name="people-count"
                                    :options="room.peopleCount"
                                    v-model="postData.peopleCount"
                                    @select="peopleCountChanged($event)"
                                >
                                </vueselect>
                            </div>
                        </div>
                    </div>

                </div>

                <div
                    class="rsd-image-text-container checkout-with-border-top d-form-lable"
                    v-if="prevFormfilled">

                    <div class="checkout-room-details responsive-ch-r-details">
                        <div>
                            <p class="checkout-room-details-header mt-0">
                                <strong>
                                    جزئیات سفارش :
                                </strong>
                            </p>
                            <div class="checkout-detail-row-container flex-center">
                                <p class="checkout-details-txt-part">تاریخ : </p>
                                <p class="checkout-details-value-part">@{{postData.day}}</p>
                            </div>

                            <div class="checkout-detail-row-container flex-center">
                                <p class="checkout-details-txt-part">ساعت : </p>
                                <p class="checkout-details-value-part">@{{postData.hourRange}}</p>
                            </div>
                            <div class="checkout-detail-row-container flex-center">
                                <p class="checkout-details-txt-part">تعداد نفرات : </p>
                                <p class="checkout-details-value-part">@{{postData.peopleCount}}</p>
                            </div>
                        </div>

                        <div class="checkout-sm-border-top">
                            <div class="checkout-detail-row-container flex-center">
                                <p class="checkout-details-txt-part flex-13">مبلغ کل : </p>
                                <p class="checkout-details-value-part">@{{postData.totalAmount}}
                                    <small>
                                        تومان
                                    </small>
                                </p>
                            </div>

                            <div class="checkout-detail-row-container flex-center">
                                <p class="checkout-details-txt-part flex-13">پیش پرداخت : </p>
                                <p class="checkout-details-value-part">@{{postData.prePayed}}
                                    <small>
                                        تومان
                                    </small>
                                </p>
                            </div>

                            <div class="checkout-detail-row-container flex-center">
                                <p class="checkout-details-txt-part flex-13">مانده پرداخت (درمحل) :</p>
                                <p class="checkout-details-value-part">@{{remainedAmount}}
                                    <small>
                                        تومان
                                    </small>
                                </p>
                            </div>
                        </div>

                        <div class="checkout-sm-border-top">
                            <div class="checkout-detail-row-container flex-center checkout-main-payment">
                                <p class="checkout-details-txt-part flex-13">قابل پرداخت</p>
                                <p class="checkout-details-value-part">@{{postData.prePayed}}
                                    <small>
                                        تومان
                                    </small>
                                </p>
                            </div>
                        </div>

                        <a @click.prevent.stop="pay" class="checkout-cta">پرداخت</a>
                        <a href="" class="checkout-cta ch-cancle-cta mt-4">انصراف</a>

                    </div>

                    <div class="checkout-options responsive-ch-options">
                        <p class="checkout-room-details-header mt-0">
                            <strong>
                                رزرو برای :
                            </strong>
                        </p>
                        <form action="/checkout-process" method="post" ref="checkoutForm">
                            @csrf
                            <input type="hidden" name="data" :value="jsonPostData">

                            <div v-for="(person, key) in postData.reservedPersons">

                                <p v-if="key === 0">اطلاعات شما (اجباری)</p>

                                <div class="flex-center mb-4">
                                    <input
                                        type="text"
                                        :class="['d-search-input checkout-search-input', 'd-flex-65 ml-4', key?'dashed-border':'']"
                                        v-model="person.name"
                                        name="firstUser"
                                        :placeholder="key === 0 ?'نام و نام خانوادگی شما':'نام دیگر اعضا ( اختیاری )'"
                                    />
                                    <div></div>
                                    <input
                                        type="text"
                                        :class="['d-search-input checkout-search-input', 'd-flex-35', key?'dashed-border':'']"
                                        name="optionalUser"
                                        v-model="person.phone"
                                        :placeholder="key === 0 ? 'موبایل شما':'موبایل ( اختیاری )'"
                                    />
                                </div>
                                <p v-if="key === 0" class="mt-8">اطلاعات دیگر اعضا (اختیاری)</p>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        const roomId = {{$roomId}}
            var
        validationData = '{!!Session::get('validationData')  !!}'
        var errorMessage = '{!!Session::get('errorMessage')  !!}'
        var errors = '{!!Session::get('errors')  !!}'

    </script>
    <script src="{{asset('js/checkout.js')}}"></script>
@endsection
