const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. We're using Tailwind CSS and Alpine.js
 | for the POS system interface.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/user.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css');

if (mix.inProduction()) {
   mix.version();
}
