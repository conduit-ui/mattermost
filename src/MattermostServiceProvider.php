<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost;

use ConduitUI\Mattermost\Filament\Stats\MattermostStats;
use ConduitUI\Mattermost\Notifications\MattermostBroadcaster;
use Filament\Panel;
use Illuminate\Contracts\Broadcasting\Factory as BroadcastFactory;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\ServiceProvider;

class MattermostServiceProvider extends ServiceProvider
{
    #[\Override]
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mattermost.php', 'mattermost');

        $this->app->scoped(MattermostManager::class);

        $this->app->singleton(MattermostStats::class, fn ($app): MattermostStats => new MattermostStats(
            $app->make(CacheRepository::class),
            (string) ($app['config']->get('mattermost.default') ?? 'default'),
        ));
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/mattermost.php' => config_path('mattermost.php'),
            ], 'mattermost-config');
        }

        $this->registerBroadcaster();
        $this->bootFilamentPanel();
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

    /**
     * Register Filament views when Filament is installed in the host application.
     *
     * The check is intentionally narrow — `class_exists(\Filament\Panel::class)`
     * — so the package never hard-depends on Filament. When Filament is
     * absent, this method short-circuits and the panel pages remain inert.
     */
    private function bootFilamentPanel(): void
    {
        if (! class_exists(Panel::class)) {
            return;
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mattermost');
    }
}
