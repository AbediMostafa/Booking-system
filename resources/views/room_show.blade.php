@extends('layouts.layout')
@section('content')
<!-- Hiro Section -->
<section class="hiro">
    <div class="container pb-4">
        <div class="header-filter-container" :style="{'--bg': background}">
            <header-part :info="headerInfos"></header-part>
        </div>
    </div>
</section>
@verbatim
<section class="show-room-content">
    <div class="container">
        <div class="show-room-container">
            <div class="rs-other-infos">
                <scores :rates="room.rates"></scores>
                <contact-infos :infos="room.contact_infos"></contact-infos>
            </div>

            <div class="rs-description">
                <h1 class="rs-box-title">توضیحات</h1>
                <description-box :room="room"></description-box>
            </div>
        </div>

        <div class="des-comments-container">
            <h1 class="rs-box-title">نظرات کاربران</h1>
            <comment 
                v-for="(comment, key) in comments" 
                :key="key" 
                :comment = "comment"
                ></comment>
        </div>
    </div>
</section>
@endverbatim


@endsection

@section('scripts')
<script>
    const roomId = {{$id}}
</script>
<script src="{{asset('js/roomShow.js')}}"></script>
@endsection