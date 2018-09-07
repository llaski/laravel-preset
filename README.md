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
- Replaces the `welcome.blade.php` template with `home.blade.php` that extends a main layout and includes a favicon partial. Also updates the routes `web.php` file to use the `home` view.

### What it includes for the Backend:

- Adds [doctrine/dbal](https://laravel.com/docs/5.7/migrations#modifying-columns) for migrations 
- Adds [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) for debugging
- Adds [codedungeon/phpunit-result-printer](https://github.com/mikeerickson/phpunit-pretty-result-printer) for nicer console output when running phpunit tests
- Adds [jtant/laravel-env-sync](https://github.com/JulienTant/Laravel-Env-Sync) along with githooks for pre-push and post-checkout to keep your env file in sync. [Credit to the great article by Caleb Porzio](https://tighten.co/blog/dot-env-files-the-silent-killer)
- Sets up a `Models` folder within your `app` directory and moves the default `User.php` class there (also updates all references from `App\User` to `App\Models\User`)
- Adds some testing helpers & speed improvements
    + Adds `assertContains`, `assertNotContains` and `assertEquals` assertion methods for Eloquent Collections
    + Adds `weh` method - short for `withoutExceptionHandling` directly on `TestCase`
    + Sets rounds for bcrypt driver to 2 instead of the default of 10 to speed up tests
- asda


### Supports:

- Laravel 5.5
- Laravel 5.6
- Laravel 5.7

### Resources

- [Favicon Generator](https://realfavicongenerator.net/)

## Installation

This package will add githooks to your setup, so ideally you would have already setup git for this project. If not, you'll have to run the following command to set the path to your githooks folder:

```
git config core.hooksPath githooks
```

_Also note this command will need to be run for any other developers working on the project._ 

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
