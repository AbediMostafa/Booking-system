const mix = require('laravel-mix');

mix.disableNotifications()

mix.
copyDirectory('resources/fonts', 'public/fonts').
copyDirectory('resources/images', 'public/images').
copyDirectory('resources/videos', 'public/videos').
js('resources/js/app.js', 'public/js/app.js').
js('resources/js/blades/landing.js', 'public/js/landing.js').
js('resources/js/blades/cities.js', 'public/js/cities.js').
js('resources/js/blades/collections.js', 'public/js/collections.js').
js('resources/js/blades/roomSearch.js', 'public/js/roomSearch.js').
js('resources/js/blades/roomShow.js', 'public/js/roomShow.js').
js('resources/js/blades/learnings.js', 'public/js/learnings.js').
js('resources/js/blades/learning.js', 'public/js/learning.js').
vue().
postCss('resources/css/app.css', 'public/css').options({
    processCssUrls: false
});