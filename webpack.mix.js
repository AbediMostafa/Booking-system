const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.disableNotifications()

mix.
copyDirectory('resources/fonts', 'public/fonts').
copyDirectory('resources/images', 'public/images').
copyDirectory('resources/videos', 'public/videos').
js('resources/js/app.js', 'public/js/app.js').
js('resources/js/blades/landing.js', 'public/js/landing.js').
js('resources/js/blades/cities.js', 'public/js/cities.js').
js('resources/js/blades/collections.js', 'public/js/collections.js').
vue().
postCss('resources/css/app.css', 'public/css').options({
    processCssUrls: false
});