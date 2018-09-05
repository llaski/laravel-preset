# ⛳️ Larry Laski's Laravel Preset ⛳️

A Laravel preset that scaffolds out new applications the way I like 'em 👊

_Inspired by [Adam Wathan](https://github.com/adamwathan/laravel-preset) among other members of the Laravel community_

### What it includes for the Frontend:

- [Tailwind CSS](https://tailwindcss.com)
- [postcss-nesting](https://github.com/jonathantneal/postcss-nesting) for nested CSS support
- [postcss-import](https://github.com/postcss/postcss-import) for inlining @import rules
- [Purgecss](https://www.purgecss.com/), via [spatie/laravel-mix-purgecss](https://github.com/spatie/laravel-mix-purgecss)
- [Vue.js](https://vuejs.org/)
- [Moment](https://momentjs.com/)
- Removes Bootstrap, jQuery, and Popper.js
- Adds simple JavaScript setup
- Adds simple Tailwind configured CSS setup
- Configuration for Laravel Mix
- Adds compiled assets and those pesky `.DS_Store` files to `.gitignore`
- Replaces the `welcome.blade.php` template with one that extends the main layout and includes a favicon partial

### What it includes for the Backend:

- Adds [doctrine/dbal](https://laravel.com/docs/5.7/migrations#modifying-columns) for migrations 
- Adds [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) for debugging
- Adds [codedungeon/phpunit-result-printer](https://github.com/mikeerickson/phpunit-pretty-result-printer) for nicer console output when running phpunit tests
- Adds [jtant/laravel-env-sync](https://github.com/JulienTant/Laravel-Env-Sync) along with githooks on push and checkout to keep your env file in sync. [Credit to the great article by Caleb Porzio](https://tighten.co/blog/dot-env-files-the-silent-killer)

### Supports:

- Laravel 5.5
- Laravel 5.6
- Laravel 5.7

### Resources

- [Favicon Generator](https://realfavicongenerator.net/)

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

> What's `builtbylarry`? Built By Larry is the name of my consultancy business. Interested? Check out my work at https://larrylaski.com or hit me up at larry.laski@gmail.com.
