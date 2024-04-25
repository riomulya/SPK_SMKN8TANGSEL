let mix = require('laravel-mix');

mix
  .js('src/app.js', 'dist')
  .postCss('src/app.css', 'public/css', [require('tailwindcss')]);
