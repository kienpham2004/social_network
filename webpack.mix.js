const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
mix.styles(['resources/css/login.css',], 'public/css/all.css')
    .styles('resources/css/time_line.css', 'public/css/time_line.css')
    .styles('resources/css/navbar.css', 'public/css/navbar.css')
    .styles('resources/css/profile.css', 'public/css/profile.css')
    .styles('resources/css/show_post.css', 'public/css/show_post.css')
    .styles('resources/css/view_user.css', 'public/css/view_user.css');
mix.js('resources/js/profile.js', 'public/js/profile.js')
    .js('resources/js/search.js', 'public/js/search.js')
    .js('resources/js/comment.js', 'public/js/comment.js')
    .js('resources/js/like_post.js', 'public/js/like_post.js')
    .js('resources/js/show_post.js', 'public/js/show_post.js')
    .js('resources/js/paginate.js', 'public/js/paginate.js')
    .js('resources/js/admin-block.js', 'public/js/admin-block.js')
    .js('resources/js/follow.js', 'public/js/follow.js');
