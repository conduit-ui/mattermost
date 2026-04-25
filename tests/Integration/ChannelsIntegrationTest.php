<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Client\Requests\Channels\CreateChannel;
use ConduitUI\Mattermost\Facades\Mattermost;

describe('Channels integration', function (): void {
    it('resolves the auto-created town-square channel by name', function (): void {
        $teamId = $this->credentials()->teamId;

        $response = Mattermost::channels()->getChannelByName($teamId, 'town-square');

        expect($response->status())->toBe(200);
        expect($response->json('id'))->toBe($this->credentials()->channelId);
        expect($response->json('name'))->toBe('town-square');
    });

    it('lists channels for the integration team for the bot user', function (): void {
        $teamId = $this->credentials()->teamId;
        $botUserId = $this->credentials()->botUserId;

        $response = Mattermost::channels()->getChannelsForTeamForUser($botUserId, $teamId);

        expect($response->status())->toBe(200);

        $channels = $response->json();
        expect($channels)->toBeArray();
        expect($channels)->not->toBeEmpty();
    });

    it('creates a channel and archives it', function (): void {
        $teamId = $this->credentials()->teamId;
        $name = 'integration-'.bin2hex(random_bytes(4));

        // CreateChannel takes no constructor args — body is merged in.
        $request = new CreateChannel;
        $request->body()->merge([
            'team_id' => $teamId,
            'name' => $name,
            'display_name' => 'Integration '.$name,
            'type' => 'O',
        ]);

        $created = Mattermost::send($request);

        expect($created->status())->toBe(201);

        $channelId = $created->json('id');
        expect($channelId)->toBeString();

        // Archive (deleteChannel performs a soft archive in Mattermost).
        $archived = Mattermost::channels()->deleteChannel($channelId);

        expect($archived->status())->toBe(200);
    });
});
