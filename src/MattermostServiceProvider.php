<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost;

use ConduitUI\Mattermost\Bot\Router as BotRouter;
use ConduitUI\Mattermost\Filament\Stats\MattermostStats;
use ConduitUI\Mattermost\Notifications\MattermostBroadcaster;
use ConduitUI\Mattermost\SlashCommands\SlashCommandController;
use ConduitUI\Mattermost\SlashCommands\SlashCommandRouter;
use Filament\Panel;
use Illuminate\Contracts\Broadcasting\Factory as BroadcastFactory;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MattermostServiceProvider extends ServiceProvider
{
    #[\Override]
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mattermost.php', 'mattermost');

        $this->app->scoped(MattermostManager::class, fn (Container $container): MattermostManager => new MattermostManager($container));

        $this->app->singleton(BotRouter::class, fn (Container $container): BotRouter => new BotRouter($container));

        $this->app->singleton(SlashCommandRouter::class, fn (Container $container): SlashCommandRouter => new SlashCommandRouter($container));

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
        $this->bootBotRouter();
        $this->bootSlashCommandRoute();
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

    private function bootBotRouter(): void
    {
        /** @var BotRouter $router */
        $router = $this->app->make(BotRouter::class);

        $configured = config('mattermost.bot.middleware', []);

        if (is_array($configured)) {
            $middleware = array_values(array_filter(
                $configured,
                static fn ($value): bool => is_string($value) && $value !== '',
            ));

            $router->setGlobalMiddleware($middleware);
        }
    }

    private function bootSlashCommandRoute(): void
    {
        $uri = config('mattermost.slash_commands.route', 'mattermost/slash-command');

        if (! is_string($uri) || $uri === '') {
            return;
        }

        $middleware = config('mattermost.slash_commands.middleware', []);
        $middleware = is_array($middleware) ? $middleware : [];

        Route::post($uri, SlashCommandController::class)
            ->middleware($middleware)
            ->name('mattermost.slash-command');
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
