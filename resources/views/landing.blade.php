@extends('layouts.layout')

@section('content')

    <!-- Hiro Section -->
    <section class="hiro">
        <video-modal :src="videoSrc" ref="landingVideo"></video-modal>
        <div class="container pb-0">
            <carousel @play-video="playVideo" :carousel-data = "allData.carousel"></carousel>
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
    <section class="special-rooms" :style="background('back1.svg', 'bottom')">
        <div class="container">
            <special-rooms :special-room-data="allData.specialRooms"></special-rooms>
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