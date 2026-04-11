<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Emoji;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteEmoji
 *
 * Delete a custom emoji.
 * ##### Permissions
 * Must have the `manage_team` or `manage_system` permissions
 * or be the user who created the emoji.
 */
class DeleteEmoji extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/api/v4/emoji/{$this->emojiId}";
    }

    /**
     * @param  string  $emojiId  Emoji GUID
     */
    public function __construct(
        protected string $emojiId,
    ) {}
}
