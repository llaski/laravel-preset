<?php

namespace BuiltByLarry\LaravelPreset;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset as BasePreset;
use Illuminate\Support\Arr;

class Preset extends BasePreset
{
    public static function install()
    {
        static::ensureComponentDirectoryExists();
        static::updatePackages();
        static::updateStyles();
        static::updateWebpackConfiguration();
        static::updateJavaScript();
        static::updateTemplates();
        static::removeNodeModules();
        static::updateGitignore();

        static::updateComposerPackages();
    }

    protected static function updatePackageArray(array $packages)
    {
        return array_merge([
            'laravel-mix-purgecss' => '^2.0.0',
            'postcss-nesting' => '^6.0.0',
            'postcss-import' => '^12.0.0',
            'tailwindcss' => '>=0.6.5',
            'moment' => '^2.0.0',
        ], Arr::except($packages, [
            'bootstrap',
            'bootstrap-sass',
            'jquery',
            'popper.js',
        ]));
    }

    protected static function updateWebpackConfiguration()
    {
        copy(__DIR__ . '/stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    protected static function updateStyles()
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(resource_path('sass'));
            $files->delete(public_path('css/app.css'));

            if (!$files->isDirectory($directory = resource_path('css'))) {
                $files->makeDirectory($directory, 0755, true);
            }
        });

        copy(__DIR__ . '/stubs/resources/css/app.css', resource_path('css/app.css'));
    }

    protected static function updateJavaScript()
    {
        tap(new Filesystem, function ($files) {
            $files->delete(public_path('css/app.css'));

            if (!$files->isDirectory($directory = resource_path('js'))) {
                $files->makeDirectory($directory, 0755, true);
            }

            $files->delete(resource_path('js/components/ExampleComponent.vue'));
        });

        copy(__DIR__ . '/stubs/resources/js/app.js', resource_path('js/app.js'));
        copy(__DIR__ . '/stubs/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));
    }

    protected static function updateTemplates()
    {
        tap(new Filesystem, function ($files) {
            $files->delete(resource_path('views/home.blade.php'));
            $files->delete(resource_path('views/welcome.blade.php'));
            $files->copyDirectory(__DIR__ . '/stubs/views', resource_path('views'));
        });
    }

    protected static function updateGitignore()
    {
        copy(__DIR__ . '/stubs/gitignore-stub', base_path('.gitignore'));
    }

    /**
     * Update the "composer.json" file.
     *
     * @param  bool  $dev
     * @return void
     */
    protected static function updateComposerPackages()
    {
        if (!file_exists(base_path('composer.json'))) {
            return;
        }

        $configurationKey = $dev ? 'require-dev' : 'require';

        $packages = json_decode(file_get_contents(base_path('composer.json')), true);

        $packages[$configurationKey] = static::updateComposerPackageArray(
            array_key_exists('require', $packages) ? $packages['require'] : []
        );

        ksort($packages['require']);

        file_put_contents(
            base_path('composer.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );

        $packages = json_decode(file_get_contents(base_path('composer.json')), true);

        $packages['require-dev'] = static::updateComposerDevPackageArray(
            array_key_exists('require-dev', $packages) ? $packages['require-dev'] : []
        );

        ksort($packages['require-dev']);

        file_put_contents(
            base_path('composer.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    protected static function updateComposerPackageArray(array $packages)
    {
        return array_merge([
            'doctrine/dbal' => '^2.6',
        ], Arr::except($packages, [
        ]));
    }

    protected static function updateComposerDevPackageArray(array $packages)
    {
        return array_merge([
            'barryvdh/laravel-debugbar' => '^3.1',
            'codedungeon/phpunit-result-printer' => '~0.14.0',
        ], Arr::except($packages, [
        ]));
    }

}
