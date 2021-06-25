@extends('layouts.layout')
@section('content')
<!-- Hiro Section -->
<section class="hiro">
    <div class="container pb-4">
        <div class="header-filter-container" :style="{'--bg': background}">
            <header-part :info="headerInfos"></header-part>
            <room-show-header-icons :room="room"></room-show-header-icons>
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
                <h1 class="rs-box-title">اتاق های همین مجموعه</h1>
                <div class="rs-box-shadow" v-if="collectionRooms.length">
                    <collection-room v-for="(collectionRoom, key) in collectionRooms" :key="key" :collection-room="collectionRoom"></collection-room>
                </div>
                <no-entity v-else image="no-room.svg" text="این مجموعه همین یک اتاق را دارد!" image-width="50"></no-entity>
            </div>

            <div class="rs-description">
                <h1 class="rs-box-title">توضیحات</h1>
                <description-box :room="room"></description-box>
                <div class="des-comments-title-container">
                    <div :class="['comment-modal-container', displayModal?'visible-modal':'']">
                        <a @click="displayModal=false"><img :src="iconPath('gradiant-cancle.svg')" class="comment-cancle-icon" /></a>
                        <div class="comment-modal">
                            <modal-comment :comment="currentComment"></modal-comment>
                            {{answers}}
                        </div>
                    </div>
                    <h1 class="rs-box-title">نظرات کاربران</h1>
                    <no-entity v-if="comments.length == 0" image="no-comment.svg" text="هنوز نظری راجع به این اتاق ثبت نشده است" image-width="30"></no-entity>
                    <div class="des-comments-container" v-else>
                        <comment v-for="(comment, key) in comments" :key="key" :comment="comment"></comment>
                        <!-- @click.native="commentClicked(comment)" -->
                    </div>
                </div>
            </div>
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