<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Reactions;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SaveReaction
 *
 * Create a reaction.
 * ##### Permissions
 * Must have `read_channel` permission for the channel the post is
 * in.
 *
 * Auto-gen gap: the generator emitted no body parameters. The Mattermost OpenAPI spec
 * defines `user_id`, `post_id`, and `emoji_name` for `POST /api/v4/reactions`, so they
 * are wired up here for the bot framework's `react()` helper.
 */
class SaveReaction extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/reactions';
    }

    /**
     * @param  string|null  $userId  ID of the user reacting.
     * @param  string|null  $postId  ID of the post being reacted to.
     * @param  string|null  $emojiName  Emoji short name, e.g. `eyes`, `+1`.
     */
    public function __construct(
        protected ?string $userId = null,
        protected ?string $postId = null,
        protected ?string $emojiName = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter(
            [
                'user_id' => $this->userId,
                'post_id' => $this->postId,
                'emoji_name' => $this->emojiName,
            ],
            static fn (?string $v): bool => $v !== null,
        );
    }
}
