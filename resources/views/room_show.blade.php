@extends('layouts.layout')
@section('content')
    <!-- Hiro Section -->
    <video-modal :src="videoSrc" ref="landingVideo"></video-modal>
    @verbatim
        <section class="hiro">
            <div class="container pb-4">
                <div class="rs-header-container" :style="{'--bg': background}">

                    <div class="rs-header-subcontainer">
                        <div class="rs-rating-container">
                            <div class="rs-rating-img-container">
                                <img :src="ratingIcon">
                            </div>
                            <p class="text-xsm mb-2">
                                <span>{{room.rates?room.rates.rate_average.toFixed(1):''}}</span>

                            </p>


                            <score-stars :score="room.rates? room.rates.total:'0'"
                                         class="justify-center"></score-stars>

                            <p class="text-xsm leading-6 color-purple-blue">
                                {{room.rates? room.rates.rateDescription:''}}
                            </p>

                            <a class="rsd-cta" @click="sendComment">
                                <img :src="iconPath('white-pencil.svg')" class="card-right-arrow"/>
                            </a>

                        </div>

                        <div class="text-right order1 rs-title-text">

                            <div class="end-flex mt-8 mb-2 flex-wrap">
                                <span class="rs-min-age">
                                   {{room.min_age}}  +
                                </span>
                                <h1 class="tex-xxxlg m-0">
                                    {{room.name}}
                                </h1>
                            </div>

                            <div class="end-flex flex-wrap">
                                <span v-for="(genre, key) in room.genres" class="rs-room-genre">
                                    {{genre}}
                                </span>
                            </div>
                            <p class="text-xsm leading-6 mt-6 rtl-dir">{{room.description}}</p>

                            <div class="rsd-cta-collection-container">

                                <div class="rsd-collection">
                                    <div class="rsd-collection-name">
                                        {{ room.collection ? room.collection.name : "" }}
                                    </div>
                                    <div
                                        class="rsd-collection-image"
                                        :style="imageAsBackground(collectionImg)"
                                    ></div>
                                </div>

                                <a class="rsd-cta" @click="reserveRoom" v-if="room.reservable">
                                    <img :src="iconPath('white-pencil.svg')" class="card-right-arrow"/>
                                </a>
                                <play-icon v-if="room.teaser"
                                           size="small" @click.native="playVideo" class="play-icon">
                                </play-icon>
                            </div>


                        </div>
                    </div>

                    <room-show-header-icons :room="room"></room-show-header-icons>
                </div>
            </div>
        </section>
        <section class="show-room-content">
            <div class="container">

                <description-box :room="room"></description-box>
                <div class="show-room-container">
                    <div class="rs-other-infos">
                        <scores :rates="room.rates"></scores>
                        <div class="rs-box-shadow" v-if="collectionRooms.length">

                            <collection-room v-for="(collectionRoom, key) in collectionRooms" :key="key"
                                             :collection-room="collectionRoom"></collection-room>
                        </div>
                    </div>

                    <div class="rs-description">
                        <div class="des-comments-title-container">
                            <div :class="['comment-modal-container', displayModal?'visible-modal':'']">
                                <a @click="displayModal=false"><img :src="iconPath('gradiant-cancle.svg')"
                                                                    class="comment-cancle-icon"/></a>
                                <div class="comment-modal">
                                    <modal-comment :comment="currentComment"></modal-comment>
                                </div>
                            </div>
                            <div class="des-comments-container" v-else>
                                <comment
                                    v-for="(comment, key) in comments"
                                    :key="key"
                                    :comment="comment"
                                    @click.native="commentClicked(comment)"
                                >
                                </comment>
                                <!--  -->
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
            var
        refId = '{{Session::get('refId')}}'
        var reserveStatus = '{{Session::get('reserveStatus')}}'
        var msg = '{{Session::get('msg')}}'
        var paymentCallback = '{{Session::get('paymentCallback')}}'
    </script>
    <script src="{{asset('js/roomShow.js')}}"></script>
@endsection
