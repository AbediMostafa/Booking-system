@extends('layouts.layout')
@section('content')
<section class="hiro">
    <div class="container pb-4">
        <div class="header-filter-container">
            <header-part :info="headerInfos"></header-part>
        </div>
    </div>
</section>

<section class="login">
    <div class="li_container" v-if="sendPhoneNumberStep">
        <div class="li_form_group">
            <span class="li_label">نام کابری</span>
            <div class="li_input">
                <input type="text" v-model="username" class="d-search-input p-4">
            </div>
        </div>

        <div class="li_form_group">
            <span class="li_label">شماره تلفن همراه</span>
            <div class="li_input">
                <input type="text" v-model="phoneNumber" class="d-search-input p-4">
            </div>
        </div>
        <a class="li_login_btn" @click="sendConfirmCode">ارسال کد فعالسازی</a>
    </div>

    <div class="li_container" v-if="sendConfirmCodeStep">
        <div class="li_form_group">
            <span class="li_label">کد فعالسازی
            </span>
            <div class="li_input">
                <input type="text" v-model="confirmCode" class="d-search-input p-4">
            </div>
        </div>
        <a class="li_login_btn" @click="submitConfirmCode">ثبت</a>
    </div>
</section>
@endsection
@section('scripts')
<script>
    const backUrl = '{{$backUrl}}'
</script>
<script src="{{asset('js/phoneCheck.js')}}"></script>
@endsection
