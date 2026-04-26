<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\SlashCommands;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * HTTP controller for receiving Mattermost slash command webhooks.
 *
 * Mattermost POSTs form-encoded data when a user triggers a custom slash
 * command. This controller parses the payload, dispatches it through the
 * {@see SlashCommandRouter}, and returns the JSON response.
 */
class SlashCommandController
{
    public function __construct(
        private readonly SlashCommandRouter $router,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        /** @var array<string, mixed> $payload */
        $payload = $request->all();

        $command = SlashCommand::fromPayload($payload);
        $response = $this->router->dispatch($command);

        if (! $response instanceof SlashCommandResponse) {
            return new JsonResponse([
                'response_type' => 'ephemeral',
                'text' => sprintf('Unknown command: %s', $command->command()),
            ]);
        }

        return new JsonResponse($response->toArray());
    }
}
