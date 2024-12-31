const mix = require('laravel-mix');

// Biên dịch Vue và JavaScript
mix.js('resources/js/app.js', 'public/js')
    .vue()  // Dùng để hỗ trợ Vue 3
    .css('resources/css/app.css', 'public/css');  // Dùng để biên dịch file CSS

if (mix.inProduction()) {
    mix.version();
}
