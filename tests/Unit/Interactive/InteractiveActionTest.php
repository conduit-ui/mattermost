<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Interactive\InteractiveAction;
use ConduitUI\Mattermost\Testing\MattermostFixtures;

describe('InteractiveAction', function (): void {
    it('parses action ID from payload', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve'));

        expect($action->actionId())->toBe('approve');
    });

    it('parses user ID from payload', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve', userId: 'user123'));

        expect($action->userId())->toBe('user123');
    });

    it('parses channel ID from payload', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve', channelId: 'chan123'));

        expect($action->channelId())->toBe('chan123');
    });

    it('parses post ID from payload', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve', postId: 'post123'));

        expect($action->postId())->toBe('post123');
    });

    it('parses type from payload', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve'));

        expect($action->type())->toBe('button');
    });

    it('parses context from payload', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve', context: ['env' => 'production']));

        expect($action->context())->toHaveKey('env', 'production')
            ->and($action->context())->toHaveKey('action', 'approve');
    });

    it('parses value from payload', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve', value: 'yes'));

        expect($action->value())->toBe('yes');
    });

    it('returns null value when not present', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve'));

        expect($action->value())->toBeNull();
    });

    it('parses team ID and domain from payload', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve'));

        expect($action->teamId())->not->toBeEmpty()
            ->and($action->teamDomain())->toBe('test-team');
    });

    it('parses trigger ID from payload', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve'));

        expect($action->triggerId())->not->toBeEmpty();
    });

    it('parses username from payload', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve'));

        expect($action->userName())->toBe('testuser');
    });

    it('parses channel name from payload', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve'));

        expect($action->channelName())->toBe('town-square');
    });

    it('parses data source from payload', function (): void {
        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve'));

        expect($action->dataSource())->toBe('');
    });

    it('returns the raw payload via toArray', function (): void {
        $payload = MattermostFixtures::fakeButtonClick('approve');
        $action = InteractiveAction::fromPayload($payload);

        expect($action->toArray())->toBe($payload);
    });

    it('returns empty strings for missing string fields', function (): void {
        $action = InteractiveAction::fromPayload([]);

        expect($action->actionId())->toBe('')
            ->and($action->userId())->toBe('')
            ->and($action->channelId())->toBe('')
            ->and($action->postId())->toBe('')
            ->and($action->type())->toBe('')
            ->and($action->teamId())->toBe('')
            ->and($action->triggerId())->toBe('');
    });

    it('returns empty array for missing context', function (): void {
        $action = InteractiveAction::fromPayload([]);

        expect($action->context())->toBe([]);
    });
});
