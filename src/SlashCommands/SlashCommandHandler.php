<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\SlashCommands;

/**
 * Base class for slash command handler classes.
 *
 * Subclass this and implement `handle()` to return a response. The router
 * resolves handlers from the container so constructor DI is available.
 *
 *   class DeployHandler extends SlashCommandHandler {
 *       public function handle(SlashCommand $command): SlashCommandResponse {
 *           return SlashCommandResponse::make('Deploying...')->inChannel();
 *       }
 *   }
 */
abstract class SlashCommandHandler
{
    /**
     * Handle the incoming slash command and return a response.
     */
    abstract public function handle(SlashCommand $command): SlashCommandResponse;
}
