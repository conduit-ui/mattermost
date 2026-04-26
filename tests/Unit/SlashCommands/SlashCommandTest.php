<?php

declare(strict_types=1);

use ConduitUI\Mattermost\SlashCommands\SlashCommand;
use ConduitUI\Mattermost\Testing\MattermostFixtures;

describe('SlashCommand', function (): void {
    it('parses the command trigger from a payload', function (): void {
        $command = SlashCommand::fromPayload(MattermostFixtures::fakeSlashCommand('/deploy'));

        expect($command->command())->toBe('/deploy');
    });

    it('parses user and channel fields', function (): void {
        $payload = MattermostFixtures::fakeSlashCommand('/deploy', userId: 'user-1', channelId: 'chan-1');
        $command = SlashCommand::fromPayload($payload);

        expect($command->userId())->toBe('user-1')
            ->and($command->channelId())->toBe('chan-1')
            ->and($command->userName())->toBe('testuser')
            ->and($command->channelName())->toBe('town-square')
            ->and($command->teamId())->not->toBeEmpty();
    });

    it('parses the raw text after the command trigger', function (): void {
        $command = SlashCommand::fromPayload(MattermostFixtures::fakeSlashCommand('/deploy', 'production --force'));

        expect($command->text())->toBe('production --force');
    });

    it('splits text into whitespace-separated args', function (): void {
        $command = SlashCommand::fromPayload(MattermostFixtures::fakeSlashCommand('/deploy', 'production us-east-1 --force'));

        expect($command->args())->toBe(['production', 'us-east-1', '--force']);
    });

    it('returns an empty args list when text is empty', function (): void {
        $command = SlashCommand::fromPayload(MattermostFixtures::fakeSlashCommand('/status'));

        expect($command->args())->toBe([]);
    });

    it('retrieves a single arg by index', function (): void {
        $command = SlashCommand::fromPayload(MattermostFixtures::fakeSlashCommand('/deploy', 'production us-east-1'));

        expect($command->arg(0))->toBe('production')
            ->and($command->arg(1))->toBe('us-east-1')
            ->and($command->arg(2))->toBeNull()
            ->and($command->arg(2, 'default'))->toBe('default');
    });

    it('exposes the token and trigger ID', function (): void {
        $command = SlashCommand::fromPayload(MattermostFixtures::fakeSlashCommand('/deploy'));

        expect($command->token())->toBe('slash-command-token')
            ->and($command->triggerId())->not->toBeEmpty();
    });

    it('exposes the response URL', function (): void {
        $command = SlashCommand::fromPayload(MattermostFixtures::fakeSlashCommand('/deploy'));

        expect($command->responseUrl())->toStartWith('https://');
    });

    it('returns the raw payload via toArray', function (): void {
        $payload = MattermostFixtures::fakeSlashCommand('/deploy', 'prod');
        $command = SlashCommand::fromPayload($payload);

        expect($command->toArray())->toBe($payload);
    });

    it('handles missing payload fields gracefully', function (): void {
        $command = SlashCommand::fromPayload([]);

        expect($command->command())->toBe('')
            ->and($command->text())->toBe('')
            ->and($command->userId())->toBe('')
            ->and($command->channelId())->toBe('')
            ->and($command->args())->toBe([]);
    });
});
