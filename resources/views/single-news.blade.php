@extends('layouts.layout')
@section('content')
    <video-modal :src="videoSrc" ref="video"></video-modal>

    <!-- Hiro Section -->
    <section class="hiro">
        <div class="container pb-4">
            <div class="header-filter-container pb-8" :style="{'--bg': background}">
                <header-part :info="headerInfos"></header-part>
                <play-icon v-if="news.video"
                           size="small" @click.native="playVideo" class="margin-auto mb-4">
                </play-icon>
            </div>
        </div>
    </section>
    @verbatim
        <section class="learning">
            <div class="container">
                <div class="learn-container flex-end text-right">
                    <div>
                        <div class="learning-date">
                            {{news.date}}
                        </div>
                        <h2 class="l-post-title"> {{news.title}}</h2>
                        <div class="l-title-icons">
                            <div class="l-user-icon">
                                <span class="l-user-text">{{news.user}}</span>
                                <img :src="iconPath('user.svg')" class="small-icon">

                            </div>
                        </div>
                        <p class="l-post-description" v-html="news.description"></p>
                        <div class="end-flex flex-wrap">
                            <span v-for="(tag, key) in news.tags" class="rs-room-genre tag-addition">
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
    <script src="{{asset('js/single-news.js')}}"></script>
@endsection
