<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Emoji;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetEmojiByName
 *
 * Get some metadata for a custom emoji using its name.
 * ##### Permissions
 * Must be
 * authenticated.
 *
 * __Minimum server version__: 4.7
 */
class GetEmojiByName extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/emoji/name/{$this->emojiName}";
    }

    /**
     * @param  string  $emojiName  Emoji name
     */
    public function __construct(
        protected string $emojiName,
    ) {}
}
