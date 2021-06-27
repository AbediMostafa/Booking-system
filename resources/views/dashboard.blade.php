<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Miss escape</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>

<body class="backgrounded-body">
    <div id="app">
        <section class="dashboard">
            <div class="container">
                <div class="dashboard-container">
                    <router-view></router-view>
                    <navbar></navbar>
                </div>

            </div>
        </section>

        @yield('content')

    </div>

    <script src="{{asset('/js/dashboard.js')}}"></script>
    @yield('scripts')

</body>

</html>