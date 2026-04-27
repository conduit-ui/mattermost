<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Interactive\InteractiveAction;
use ConduitUI\Mattermost\Interactive\InteractiveActionResponse;
use ConduitUI\Mattermost\Interactive\InteractiveActionRouter;
use ConduitUI\Mattermost\Testing\MattermostFixtures;

describe('InteractiveActionController', function (): void {
    it('routes a webhook POST to the registered handler and returns JSON', function (): void {
        /** @var InteractiveActionRouter $router */
        $router = app(InteractiveActionRouter::class);
        $router->register('approve', fn (InteractiveAction $a): InteractiveActionResponse => InteractiveActionResponse::make()->update('Approved!'));

        $payload = MattermostFixtures::fakeButtonClick('approve');

        $response = $this->postJson('mattermost/interactive', $payload);

        $response->assertOk();
        $response->assertJson([
            'update' => ['message' => 'Approved!'],
        ]);
    });

    it('returns an ephemeral fallback for unregistered actions', function (): void {
        $payload = MattermostFixtures::fakeButtonClick('unknown');

        $response = $this->postJson('mattermost/interactive', $payload);

        $response->assertOk();
        $response->assertJson([
            'ephemeral_text' => 'No handler registered for action: unknown',
        ]);
    });

    it('passes context through to the handler', function (): void {
        /** @var InteractiveActionRouter $router */
        $router = app(InteractiveActionRouter::class);
        $router->register('deploy', fn (InteractiveAction $a): InteractiveActionResponse => InteractiveActionResponse::make()->ephemeral('Deploying to '.$a->context()['env']));

        $payload = MattermostFixtures::fakeButtonClick('deploy', context: ['env' => 'production']);

        $response = $this->postJson('mattermost/interactive', $payload);

        $response->assertOk();
        $response->assertJson([
            'ephemeral_text' => 'Deploying to production',
        ]);
    });

    it('supports update with props response', function (): void {
        /** @var InteractiveActionRouter $router */
        $router = app(InteractiveActionRouter::class);
        $router->register('clear', fn (InteractiveAction $a): InteractiveActionResponse => InteractiveActionResponse::make()->update('Cleared')->props(['attachments' => []]));

        $payload = MattermostFixtures::fakeButtonClick('clear');

        $response = $this->postJson('mattermost/interactive', $payload);

        $response->assertOk();
        $response->assertJson([
            'update' => [
                'message' => 'Cleared',
                'props' => ['attachments' => []],
            ],
        ]);
    });
});
