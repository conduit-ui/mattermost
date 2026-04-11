<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetFlaggedPostsForUser
 *
 * Get a page of flagged posts of a user provided user id string. Selects from a channel, team, or all
 * flagged posts by a user. Will only return posts from channels in which the user is member.
 * #####
 * Permissions
 * Must be user or have `manage_system` permission.
 */
class GetFlaggedPostsForUser extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/posts/flagged";
    }

    /**
     * @param  string  $userId  ID of the user
     * @param  null|string  $teamId  Team ID
     * @param  null|string  $channelId  Channel ID
     * @param  null|int  $page  The page to select
     */
    public function __construct(
        protected string $userId,
        protected ?string $teamId = null,
        protected ?string $channelId = null,
        protected ?int $page = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['team_id' => $this->teamId, 'channel_id' => $this->channelId, 'page' => $this->page]);
    }
}
