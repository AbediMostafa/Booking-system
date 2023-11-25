<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow">

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
    <script>
        var url = 'https://wati-integration-service.clare.ai/ShopifyWidget/shopifyWidget.js?43458';
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = url;
        var options = {
            "enabled":true,
            "chatButtonSetting":{
                "backgroundColor":"#4dc247",
                "ctaText":"",
                "borderRadius":"25",
                "marginLeft":"0",
                "marginBottom":"50",
                "marginRight":"50",
                "position":"right"
            },
            "brandSetting":{
                "brandName":"Miss Escape",
                "brandSubTitle":"",
                "brandImg":"https://cdn.clare.ai/wati/images/WATI_logo_square_2.png",
                "backgroundColor":"#0a5f54",
                "borderRadius":"25",
                "autoShow":false,
                "phoneNumber":"989123711964"
            }
        };
        s.onload = function() {
            CreateWhatsappChatWidget(options);
        };
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
    </script>


    <script src="{{asset('/js/app.js')}}"></script>
    @yield('scripts')

</body>

</html>
