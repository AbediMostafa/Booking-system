@extends('layouts.layout')

@section('content')

    <!-- Hiro Section -->
    <section class="hiro">
        <video-modal :src="videoSrc" ref="landingVideo"></video-modal>
        <div class="container pb-0 pt-0">
            <carousel
                @play-video="playVideo"
                :carousel-data="allData.carousel"
                :count-data="allData.entityCounts"
            ></carousel>
        </div>
    </section>

    <!-- Counts section -->
    <section class="counts">
        <counts :count-data="allData.entityCounts"></counts>
    </section>

    <section class="slider">
        <div class="container pb-0">
            <slider></slider>
        </div>
    </section>

    <!-- Special Rooms Section -->
    <section class="special-rooms">
        <div class="container pb-4">
            <special-rooms :special-room-data="allData.specialRooms"></special-rooms>
        </div>
    </section>

    {{-- Landing search--}}
    <section class="landing-search-section" :style="background('back1.svg', 'bottom')">
        <div class="container">
            <landing-search :search-data="allData.search"></landing-search>
        </div>
    </section>

    <!-- Full Video Section -->
    <section class="full-video">
        <div class="container">
            <full-video @play-video="playVideo"></full-video>
        </div>
    </section>

    <!-- Learning Section -->
    <section class="learning" :style="background('rotated-back1.svg', 'top')">
        <div class="container">
            <learning :learning-data="allData.learning"></learning>
        </div>
    </section>

    <!-- Multimedia Section -->
    <section class="learning">
        <div class="container">
            <multimedia :multimedia-data="allData.multimedia"></multimedia>
        </div>
    </section>



    <!-- Collections Section  -->
    <section class="collections">
        <div class="container">
            <collections :collection-data="allData.collection"></collections>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{asset('/js/landing.js')}}"></script>
@endsection
