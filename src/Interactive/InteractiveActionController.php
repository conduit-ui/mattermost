<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Interactive;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * HTTP controller for receiving Mattermost interactive action webhooks.
 *
 * Mattermost POSTs a JSON payload when a user clicks a button or selects
 * a menu option on an interactive message. This controller parses the
 * payload, dispatches it through the {@see InteractiveActionRouter}, and
 * returns the JSON response.
 */
class InteractiveActionController
{
    public function __construct(
        private readonly InteractiveActionRouter $router,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        /** @var array<string, mixed> $payload */
        $payload = $request->all();

        $action = InteractiveAction::fromPayload($payload);
        $response = $this->router->dispatch($action);

        if (! $response instanceof InteractiveActionResponse) {
            return new JsonResponse([
                'ephemeral_text' => sprintf('No handler registered for action: %s', $action->actionId()),
            ]);
        }

        return new JsonResponse($response->toArray());
    }
}
