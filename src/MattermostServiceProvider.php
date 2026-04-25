<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost;

use ConduitUI\Mattermost\Notifications\MattermostBroadcaster;
use Illuminate\Contracts\Broadcasting\Factory as BroadcastFactory;
use Illuminate\Support\ServiceProvider;

class MattermostServiceProvider extends ServiceProvider
{
    #[\Override]
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mattermost.php', 'mattermost');

        $this->app->scoped(MattermostManager::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/mattermost.php' => config_path('mattermost.php'),
            ], 'mattermost-config');
        }

        $this->registerBroadcaster();
    }

    private function registerBroadcaster(): void
    {
        if (! $this->app->bound(BroadcastFactory::class)) {
            return;
        }

        /** @var BroadcastFactory $factory */
        $factory = $this->app->make(BroadcastFactory::class);

        $factory->extend('mattermost', fn ($app, array $config): MattermostBroadcaster => new MattermostBroadcaster(
            $app->make(MattermostManager::class),
            $config['connection'] ?? null,
        ));
    }
}
