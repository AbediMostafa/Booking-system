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
            <div class="li_input">
                <input type="text" v-model="username" class="d-search-input p-4">
            </div>
        </div>

        <div class="li_form_group">
            <div class="li_input">
                <input type="text" v-model="phoneNumber" class="d-search-input p-4">
            </div>
        </div>
    </div>

    <div class="li_container" v-if="sendConfirmCodeStep">
        <div class="li_form_group">
            </span>
            <div class="li_input">
                <input type="text" v-model="confirmCode" class="d-search-input p-4">
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    const backUrl = '{{$backUrl}}'
</script>
<script src="{{asset('js/phoneCheck.js')}}"></script>
@endsection
