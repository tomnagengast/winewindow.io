const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .vue()
    .postCss("resources/css/app.css", "public/css", [
        require("postcss-import"),
        require("tailwindcss"),
    ])
    .browserSync({
        proxy: "localhost",
        open: false,
        notify: false,
    })
    // .extract() // uncomment vendor.js and manifest.js in app.blade.php
    .sourceMaps(true, "source-map")
    .webpackConfig(require("./webpack.config"))
    .version();

mix.options({
    vue: {
        compilerOptions: {
            isCustomElement: tag => tag === 'trix-editor'
        }
    }
})
