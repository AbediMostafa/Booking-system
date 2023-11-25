@extends('layouts.layout')
@section('content')
<video-modal :src="videoSrc" ref="video"></video-modal>

<!-- Hiro Section -->
<section class="hiro">
    <div class="container pb-4">
        <div class="header-filter-container pb-8" :style="{'--bg': background}">
            <header-part :info="headerInfos"></header-part>
            <play-icon v-if="post.video"
                       size="small" @click.native="playVideo" class="margin-auto mb-4">
            </play-icon>
        </div>
    </div>
</section>
@verbatim
<section class="learning">
    <div class="container">
        <div class="learn-container">
            <div class="l-special-rooms">

                <div class="global-card-container">
                    <complicated-room-card
                        v-for="room in specialRooms"
                        :key="room.id"
                        :room="room"
                        no-readmore="learn"
                        class="l-complicated-room"></complicated-room-card>
                </div>
            </div>
            <div class="l-description">
                <div class="learning-date">
                    {{post.date}}
                </div>
                <h2 class="l-post-title"> {{post.title}}</h2>
                <div class="l-title-icons">
                    <div class="l-user-icon">
                        <span class="l-user-text">{{post.user}}</span>
                        <img :src="iconPath('user.svg')" class="small-icon">

                    </div>
                </div>
                <p class="l-post-description" v-html="post.description"></p>
                <div class="end-flex flex-wrap">
                    <span v-for="(tag, key) in tags" class="rs-room-genre tag-addition">
                        {{tag.name}}
                    </span>
                </div>
            </div>

        </div>
    </div>
</section>
@endverbatim


@endsection

@section('scripts')

<script>
    const id = '{{$id}}'
</script>
<script src="{{asset('js/learning.js')}}"></script>
@endsection
