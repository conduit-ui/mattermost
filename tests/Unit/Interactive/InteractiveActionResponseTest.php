<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Interactive\InteractiveActionResponse;

describe('InteractiveActionResponse', function (): void {
    it('builds an empty response by default', function (): void {
        $response = InteractiveActionResponse::make();

        expect($response->toArray())->toBe([]);
    });

    it('builds an update response with message text', function (): void {
        $response = InteractiveActionResponse::make()->update('Approved!');

        expect($response->toArray())->toBe([
            'update' => ['message' => 'Approved!'],
        ]);
    });

    it('builds an update response with props', function (): void {
        $response = InteractiveActionResponse::make()
            ->update('Done')
            ->props(['attachments' => []]);

        expect($response->toArray())->toBe([
            'update' => [
                'message' => 'Done',
                'props' => ['attachments' => []],
            ],
        ]);
    });

    it('builds a props-only update without message', function (): void {
        $response = InteractiveActionResponse::make()
            ->props(['attachments' => [['text' => 'Updated']]]);

        expect($response->toArray())->toBe([
            'update' => [
                'props' => ['attachments' => [['text' => 'Updated']]],
            ],
        ]);
    });

    it('builds an ephemeral response', function (): void {
        $response = InteractiveActionResponse::make()->ephemeral('Only you can see this');

        expect($response->toArray())->toBe([
            'ephemeral_text' => 'Only you can see this',
        ]);
    });

    it('combines update and ephemeral in one response', function (): void {
        $response = InteractiveActionResponse::make()
            ->update('Post updated')
            ->ephemeral('Action recorded');

        expect($response->toArray())->toBe([
            'update' => ['message' => 'Post updated'],
            'ephemeral_text' => 'Action recorded',
        ]);
    });

    it('is chainable via fluent methods', function (): void {
        $response = InteractiveActionResponse::make()
            ->update('text')
            ->props(['key' => 'value'])
            ->ephemeral('note');

        expect($response)->toBeInstanceOf(InteractiveActionResponse::class);
    });
});
