<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

</head>

<body>
    <div id="app">
        <section class="hiro">
            <div class="container">
                <Navbar></Navbar>
                <carousel></carousel>
            </div>
        </section>

        <section class="special-rooms">
            <div class="container">
                <special-rooms></special-rooms>
            </div>
        </section>

        <section class="full-video">
            <div class="container">
                <full-video></full-video>
            </div>
        </section>

        <section class="learning">
            <div class="container">
                <learning></learning>
            </div>
        </section>

        <section class="collections">
            <div class="container">
                <collections></collections>
            </div>
        </section>
    </div>

    <script src="{{asset('/js/app.js')}}">
    </script>
</body>

</html>