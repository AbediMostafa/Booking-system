<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Miss escape</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

</head>

<body>
    <div id="app">
        <!-- Hiro Section -->
        <section class="hiro">
            <video-modal :src="videoSrc" ref="landingVideo"></video-modal>
            <div class="container">
                <Navbar></Navbar>
                <carousel @play-video="playVideo"></carousel>
            </div>
        </section>

        <section class="counts">
            <div class="container">
                <counts></counts>
            </div>
        </section>

        <!-- Special Rooms Section -->
        <section class="special-rooms" :style="background('back1.svg', 'bottom')">
            <div class="container">
                <special-rooms></special-rooms>
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
                <learning></learning>
            </div>
        </section>

        <!-- Collections Section  -->
        <section class="collections">
            <div class="container">
                <collections></collections>
            </div>
        </section>

    </div>

    <script src="{{asset('/js/app.js')}}"></script>
    <script src="{{asset('js/landing.js')}}"></script>
</body>

</html>