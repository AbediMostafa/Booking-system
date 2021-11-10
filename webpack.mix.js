const mix = require('laravel-mix');

mix.disableNotifications()

mix.
copyDirectory('resources/fonts', 'public/fonts').
copyDirectory('resources/images', 'public/images').
js('resources/js/app.js', 'public/js/app.js').
js('resources/js/blades/landing.js', 'public/js/landing.js').
js('resources/js/blades/cities.js', 'public/js/cities.js').
js('resources/js/blades/collections.js', 'public/js/collections.js').
js('resources/js/blades/roomSearch.js', 'public/js/roomSearch.js').
js('resources/js/blades/roomShow.js', 'public/js/roomShow.js').
js('resources/js/blades/learnings.js', 'public/js/learnings.js').
js('resources/js/blades/learning.js', 'public/js/learning.js').
js('resources/js/blades/dashboard.js', 'public/js/dashboard.js').
js('resources/js/blades/login.js', 'public/js/login.js').
js('resources/js/blades/contactUs.js', 'public/js/contactUs.js').
js('resources/js/blades/aboutUs.js', 'public/js/aboutUs.js').
js('resources/js/blades/insertComment.js', 'public/js/insertComment.js').
js('resources/js/blades/phoneCheck.js', 'public/js/phoneCheck.js').
js('resources/js/blades/checkout.js', 'public/js/checkout.js').
js('resources/js/blades/specialRooms.js', 'public/js/specialRooms.js').
js('resources/js/blades/movies.js', 'public/js/movies.js').
js('resources/js/blades/news.js', 'public/js/news.js').
js('resources/js/blades/movie.js', 'public/js/movie.js').
js('resources/js/blades/single-news.js', 'public/js/single-news.js').
vue().
postCss('resources/css/app.css', 'public/css').options({
    processCssUrls: false
});

