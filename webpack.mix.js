const mix = require('laravel-mix');
const path = require('path');

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

mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: path.resolve(__dirname, './node_modules')
            }
        ],
    }
})

mix.sass('resources/sass/app.scss', 'public/css/')
    // Bootstrap, fancybox
    .js('resources/js/app.js', 'public/js/')
    // Js pages
    .copy('resources/js/pages', 'public/js/pages/', false)
    // Chart js
    .copy('node_modules/chart.js/Chart.min.js', 'public/js/', false)
    // Transparency
    .copy('node_modules/transparency/dist/transparency.min.js', 'public/js/', false)
    // Images
    .copy('resources/img', 'public/img', false)
    .copy('node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.css', 'public/css/', false)
    .copy('node_modules/jquery/dist/jquery.min.js', 'public/js/', false);