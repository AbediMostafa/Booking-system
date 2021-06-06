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
            <div class="container pb-4">
                <Navbar></Navbar>
                <header-part :info="headerInfos"></header-part>
            </div>
        </section>
        
        <section class="special-rooms">
            <div class="container">
                <cities></cities>
            </div>
        </section>
        
        <!-- Footer Section -->
        <section class="footer">
            <div class="container">
                <site-footer></site-footer>
            </div>
        </section>
    </div>

    <script src="{{asset('/js/app.js')}}"></script>
    <script src="{{asset('js/cities.js')}}"></script>
</body>

</html>