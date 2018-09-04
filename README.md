# ⛳️ Larry Laski's Laravel Frontend Preset ⛳️

A Laravel preset that scaffolds out new applications the way I like 'em 👊

_Inspired by Adam Wathan among other members of the Laravel community_

What it includes:

Currently Nothing...

What is will include:
- [Tailwind CSS](https://tailwindcss.com)
- [postcss-nesting](https://github.com/jonathantneal/postcss-nesting) for nested CSS support
- [Purgecss](https://www.purgecss.com/), via [spatie/laravel-mix-purgecss](https://github.com/spatie/laravel-mix-purgecss)
- [Vue.js](https://vuejs.org/)
- Removes Bootstrap and jQuery
- Adds compiled assets to `.gitignore`
- Adds a simple Tailwind-tuned default layout template
- Replaces the `welcome.blade.php` template with one that extends the main layout
- And More!
-
## Installation

This package isn't on Packagist (yet), so to get started, add it as a repository to your `composer.json` file:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/llaski/laravel-preset"
    }
]
```

Next, run this command to add the preset to your project:

```
composer require llaski/laravel-preset --dev
```

Finally, apply the scaffolding by running:

```
php artisan preset builtbylarry
```

> What's `builtbylarry`? Built By Larry is the name of my consultancy business. Interested? Check my work out at https://larrylaski.com or hit me up at larry.laski@gmail.com
>
![Alt text](https://raw.githubusercontent.com/llaski/larrylaski/master/public/img/logo/icon.svg)
<img src="https://raw.githubusercontent.com/llaski/larrylaski/master/public/img/logo/icon.svg">
