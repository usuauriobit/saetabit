const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
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

mix
  .js("resources/js/app.intranet.js", "public/js")
  .js("resources/js/app.public.js", "public/js")
  .postCss("resources/css/app.css", "public/css", [
    tailwindcss("tailwind.intranet.config.js")
  ])
  .postCss("resources/css/public.css", "public/css", [
    tailwindcss("tailwind.public.config.js")
  ]);

if (mix.inProduction()) {
    mix.version();
}
