let mix = require('laravel-mix');
var tailwindcss = require('tailwindcss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
// pc
// mix.js('resources/assets/js/app.js', 'public/js');
// mobile
mix.js('resources/assets/js/mobile.js', 'public/js')
        .extract(['vue']);

// If you want to use SASS for preprocessing
    // mix.sass('resources/assets/sass/app.scss', 'public/css')
    // .options({
    //     processCssUrls: false,
    //     postCss: [ tailwindcss('tailwind.js') ],
    // });
