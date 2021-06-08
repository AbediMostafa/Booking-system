<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Miss escape</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>

<body>
    <div id="app">
        
        <!-- Hiro Section -->
        <section class="navbar">
            <div class="container">
                <Navbar></Navbar>
            </div>
        </section>  
        @yield('content')

        <!-- Footer Section -->
        <section class="footer">
            <div class="container">
                <site-footer></site-footer>
            </div>
        </section>
    </div>

    <script src="{{asset('/js/app.js')}}"></script>
    @yield('scripts')

</body>
</html>