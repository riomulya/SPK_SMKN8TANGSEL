let mix = require('laravel-mix');

mix
  .js('src/app.js', 'dist')
  .postCss('src/app.css', 'public/css', [require('tailwindcss')]);

const path = require('path');

module.exports = {
  entry: './resources/js/app.js',
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'public/js'),
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: ['style-loader', 'css-loader'],
      },
    ],
  },
};
