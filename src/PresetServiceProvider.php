<?php

namespace BuiltByLarry\LaravelPreset;

use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Support\ServiceProvider;

class PresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        PresetCommand::macro('builtbylarry', function ($command) {
            Preset::install();

            $command->info('BuiltByLarry scaffolding installed successfully.');
            $command->info('Please run "npm install && ./node_modules/.bin/tailwind init tailwind.js && npm run dev && composer update" to compile your fresh scaffolding.');
        });
    }
}
