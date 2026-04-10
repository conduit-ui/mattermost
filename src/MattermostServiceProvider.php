<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost;

use Illuminate\Support\ServiceProvider;

class MattermostServiceProvider extends ServiceProvider
{
    #[\Override]
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mattermost.php', 'mattermost');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/mattermost.php' => config_path('mattermost.php'),
            ], 'mattermost-config');
        }
    }
}
