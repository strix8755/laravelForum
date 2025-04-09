const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/forum.js', 'public/js')
   .js('resources/js/comment-management.js', 'public/js')
   .js('resources/js/toast.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
   ])
   .postCss('resources/css/toast.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
   ]);

if (mix.inProduction()) {
    mix.version();
}
