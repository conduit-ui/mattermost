<?php

declare(strict_types=1);

use ConduitUI\Mattermost\SlashCommands\SlashCommand;
use ConduitUI\Mattermost\SlashCommands\SlashCommandResponse;
use ConduitUI\Mattermost\SlashCommands\SlashCommandRouter;
use ConduitUI\Mattermost\Testing\MattermostFixtures;

describe('SlashCommandController', function (): void {
    it('routes a webhook POST to the registered handler and returns JSON', function (): void {
        /** @var SlashCommandRouter $router */
        $router = app(SlashCommandRouter::class);
        $router->register('/deploy', fn (SlashCommand $cmd): SlashCommandResponse => SlashCommandResponse::make('Deployed!')->inChannel());

        $payload = MattermostFixtures::fakeSlashCommand('/deploy', 'production');

        $response = $this->post('mattermost/slash-command', $payload);

        $response->assertOk();
        $response->assertJson([
            'response_type' => 'in_channel',
            'text' => 'Deployed!',
        ]);
    });

    it('returns an ephemeral "unknown command" response for unregistered commands', function (): void {
        $payload = MattermostFixtures::fakeSlashCommand('/unknown');

        $response = $this->post('mattermost/slash-command', $payload);

        $response->assertOk();
        $response->assertJson([
            'response_type' => 'ephemeral',
            'text' => 'Unknown command: /unknown',
        ]);
    });

    it('passes query arguments through to the handler', function (): void {
        /** @var SlashCommandRouter $router */
        $router = app(SlashCommandRouter::class);
        $router->register('/echo', fn (SlashCommand $cmd): SlashCommandResponse => SlashCommandResponse::make($cmd->text()));

        $payload = MattermostFixtures::fakeSlashCommand('/echo', 'hello world');

        $response = $this->post('mattermost/slash-command', $payload);

        $response->assertOk();
        $response->assertJson(['text' => 'hello world']);
    });
});
