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
        static::updateGithooks();
        static::updateGitConfig();

        static::setUpModelsFolder();
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

        $packages = json_decode(file_get_contents(base_path('composer.json')), true);

        $packages['require'] = static::updateComposerPackageArray(
            array_key_exists('require', $packages) ? $packages['require'] : []
        );

        ksort($packages['require']);

        $packages['require-dev'] = static::updateComposerDevPackageArray(
            array_key_exists('require-dev', $packages) ? $packages['require-dev'] : []
        );

        ksort($packages['require-dev']);

        $packages['scripts'] = static::updateComposerScriptsArray(
            array_key_exists('scripts', $packages) ? $packages['scripts'] : []
        );

        file_put_contents(
            base_path('composer.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    protected static function updateComposerPackageArray(array $packages)
    {
        return array_merge([
            'doctrine/dbal' => '~2.8',
            'jtant/laravel-env-sync' => '~1.3',
        ], Arr::except($packages, [
        ]));
    }

    protected static function updateComposerDevPackageArray(array $packages)
    {
        return array_merge([
            'barryvdh/laravel-debugbar' => '~3.2',
            'codedungeon/phpunit-result-printer' => '~0.19',
        ], Arr::except($packages, [
        ]));
    }

    protected static function updateComposerScriptsArray(array $scripts)
    {
        return array_merge($scripts, [
            'post-install-cmd' => [
                "@php artisan env:check",
            ],
        ]);
    }

    protected static function updateGithooks()
    {
        tap(new Filesystem, function ($files) {
            if (!$files->isDirectory($directory = base_path('githooks'))) {
                $files->makeDirectory($directory, 0755, true);
            }

            $files->copy(__DIR__ . '/stubs/githooks/post-checkout', base_path('githooks/post-checkout'));
            $files->copy(__DIR__ . '/stubs/githooks/pre-push', base_path('githooks/pre-push'));

            $files->chmod(base_path('githooks/post-checkout'), 0777);
            $files->chmod(base_path('githooks/pre-push'), 0777);
        });

    }

    protected static function updateGitConfig()
    {
        tap(new Filesystem, function ($files) {
            //Make sure git is setup
            if (!$files->isFile(base_path('.git/config'))) {
                return;
            }

            shell_exec('git config core.hooksPath githooks');
        });
    }

    protected static function setUpModelsFolder()
    {
        tap(new Filesystem, function ($files) {
            if (!$files->isDirectory($directory = app_path('Models'))) {
                $files->makeDirectory($directory, 0755, true);

            }

            if (!$files->isFile(app_path('Models/User.php')) && $files->isFile($file = app_path('User.php'))) {
                $files->move($file, app_path('Models/User.php'));

                $contents = $files->get(app_path('Models/User.php'));
                $contents = str_replace('namespace App;', 'namespace App\Models;', $contents);
                $files->put(app_path('Models/User.php'), $contents);

                //Update all references to App\User within your app directory
                collect(self::globRecursive(app_path('*.php')))->each(function ($file) use ($files) {
                    $contents = $files->get($file);
                    $contents = str_replace('App\User', 'App\Models\User', $contents);
                    $files->put($file, $contents);
                });

                //Update all references to App\User within your config directory
                collect(self::globRecursive(config_path('*.php')))->each(function ($file) use ($files) {
                    $contents = $files->get($file);
                    $contents = str_replace('App\User', 'App\Models\User', $contents);
                    $files->put($file, $contents);
                });
            }
        });
    }

    private static function globRecursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);

        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, self::globRecursive($dir . '/' . basename($pattern), $flags));
        }

        return $files;
    }

}
