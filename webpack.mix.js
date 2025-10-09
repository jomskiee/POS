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
   .js('resources/js/inventory.js', 'public/js')
   .js('resources/js/qr-code.js', 'public/js')
   .js('resources/js/qr-scanner.js', 'public/js')
   .js('resources/js/qr-backend-handler.js', 'public/js')
   .js('resources/js/print-receipt.js', 'public/js')
   .js('resources/js/sales-qr-scanner.js', 'public/js')
   .js('resources/js/sales-form.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css')
   .postCss('resources/css/admin.css', 'public/css')
   .postCss('resources/css/filter-layout.css', 'public/css');

if (mix.inProduction()) {
   mix.version();
}
