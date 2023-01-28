<?php

namespace App\Providers;

use Encodia\Health\Checks\EnvVars;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Facades\Health;

class HealthServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot(): void
    {
        Health::checks([
            CacheCheck::new(),
            DatabaseCheck::new(),
            DebugModeCheck::new()->expectedToBe((bool)app()->environment('local')),
            EnvVars::new()
                ->requireVars([
                    'STATAMIC_LICENSE_KEY',
                    'CP_ROUTE',
                ])
                ->requireVarsForEnvironment('production', [
                    'BUGSNAG_API_KEY',
                ]),
        ]);
    }
}
