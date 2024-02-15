const mix = require('laravel-mix');
const webpack = require('webpack');

mix.webpackConfig ({
    plugins: [
        new webpack.DefinePlugin({
            __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false
        }),
    ],
})

mix.js('resources/js/short_links-app.js', 'public/js')
    .vue({
        version: 3,
        options: {
            compilerOptions: {
                isCustomElement: (tag) => [
                    'x-field',
                    'x-messages',
                    'x-description',
                ].includes(tag),
            }
        }
    }).postCss('resources/css/app.css', 'public/css', []);
