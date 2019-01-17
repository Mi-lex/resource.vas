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

mix.sass('resources/sass/app.scss', 'public/css/');

// Bootstrap, jquery, fancybox, chart.js
mix.js('resources/js/app.js', 'public/js/');

mix.copy('resources/img', 'public/img', false);