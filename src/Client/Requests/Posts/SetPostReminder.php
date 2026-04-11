<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SetPostReminder
 *
 * Set a reminder for the user for the post.
 * ##### Permissions
 * Must have `read_channel` permission for
 * the channel the post is in.
 *
 * __Minimum server version__: 7.2
 */
class SetPostReminder extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/posts/{$this->postId}/reminder";
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $postId  Post GUID
     */
    public function __construct(
        protected string $userId,
        protected string $postId,
    ) {}
}
