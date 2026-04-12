<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetIncomingWebhooks
 *
 * Get a page of a list of incoming webhooks. Optionally filter for a specific team using query
 * parameters.
 * ##### Permissions
 * `manage_webhooks` for the system or `manage_webhooks` for the specific
 * team.
 */
class GetIncomingWebhooks extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/hooks/incoming';
    }

    /**
     * @param  null|int  $page  The page to select.
     * @param  null|string  $teamId  The ID of the team to get hooks for.
     */
    public function __construct(
        protected ?int $page = null,
        protected ?string $teamId = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page, 'team_id' => $this->teamId]);
    }
}
