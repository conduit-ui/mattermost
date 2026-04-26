<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\SlashCommands;

use Closure;
use Illuminate\Contracts\Container\Container;

/**
 * Route-style registration and dispatch for Mattermost slash commands.
 *
 * Register handlers using `register()` with either a handler class or a closure:
 *
 *   $router->register('/deploy', DeployHandler::class);
 *   $router->register('/status', fn (SlashCommand $cmd) => SlashCommandResponse::make('OK'));
 *
 * The router resolves class-based handlers from the container so DI works.
 */
class SlashCommandRouter
{
    /** @var array<string, class-string<SlashCommandHandler>|Closure(SlashCommand): SlashCommandResponse> */
    private array $handlers = [];

    public function __construct(
        private readonly Container $container,
    ) {}

    /**
     * Register a handler for a slash command trigger.
     *
     * The command should include the leading slash (e.g. "/deploy"). If omitted,
     * it will be prepended automatically.
     *
     * @param  class-string<SlashCommandHandler>|Closure(SlashCommand): SlashCommandResponse  $handler
     */
    public function register(string $command, string|Closure $handler): self
    {
        $command = $this->normalizeCommand($command);
        $this->handlers[$command] = $handler;

        return $this;
    }

    /**
     * Dispatch an incoming slash command payload to its registered handler.
     *
     * Returns null if no handler matches the command.
     */
    public function dispatch(SlashCommand $command): ?SlashCommandResponse
    {
        $trigger = $this->normalizeCommand($command->command());

        $handler = $this->handlers[$trigger] ?? null;

        if ($handler === null) {
            return null;
        }

        if ($handler instanceof Closure) {
            return $handler($command);
        }

        /** @var SlashCommandHandler $instance */
        $instance = $this->container->make($handler);

        return $instance->handle($command);
    }

    /**
     * Check whether a handler is registered for a given command trigger.
     */
    public function hasHandler(string $command): bool
    {
        return isset($this->handlers[$this->normalizeCommand($command)]);
    }

    /**
     * @return array<string, class-string<SlashCommandHandler>|Closure(SlashCommand): SlashCommandResponse>
     */
    public function handlers(): array
    {
        return $this->handlers;
    }

    private function normalizeCommand(string $command): string
    {
        return str_starts_with($command, '/') ? $command : '/'.$command;
    }
}
