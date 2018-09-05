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
            $command->info('Please run "./node_modules/.bin/tailwind init tailwind.js && npm install && npm run dev" to compile your fresh scaffolding.');
        });
    }
}
