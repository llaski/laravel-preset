const mix = require('laravel-mix')
const path = require('path')
require('laravel-mix-purgecss')

mix
    .js('resources/js/app.js', 'public/js')

    .postCss('resources/css/app.css', 'public/css')

    .options({
        postCss: [
            require('postcss-import')(),
            require('tailwindcss')('./tailwind.js'),
            require('postcss-nesting')(),
        ]
    })

    .webpackConfig({
        resolve: {
            modules: [
                path.resolve('./resources/js'),
                'node_modules'
            ]
        },
    })
    
    .sourceMaps()

    .purgeCss()

if (mix.inProduction()) {
    mix.version()
}