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
}
