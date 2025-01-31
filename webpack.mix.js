const mix = require('laravel-mix');
require('dotenv').config();

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/chat.scss', 'public/css')
    .sass('resources/sass/site.scss', 'public/css')
    .alias({
        '@': 'resources/components'
    });

if (mix.inProduction()) {
    mix.version();
}