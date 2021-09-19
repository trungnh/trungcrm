const mix = require('laravel-mix');
const config = require('./webpack.config');

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
mix.webpackConfig(config);

// Admin
mix.js('resources/js/admin.js', 'public/js/')
    .sass('resources/sass/admin/admin.scss', 'public/css/admin').options({processCssUrls: false});

// Libs
mix.copy('node_modules/vue/dist/vue.min.js', 'public/lib/vue')
    .copy('node_modules/vuex/dist/vuex.min.js', 'public/lib/vuex')
