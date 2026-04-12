<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Emoji;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetEmojiList
 *
 * Get a page of metadata for custom emoji on the system. Since server version 4.7, sort using the
 * `sort` query parameter.
 * ##### Permissions
 * Must be authenticated.
 */
class GetEmojiList extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/emoji';
    }

    /**
     * @param  null|int  $page  The page to select.
     * @param  null|string  $sort  Either blank for no sorting or "name" to sort by emoji names. Minimum server version for sorting is 4.7.
     */
    public function __construct(
        protected ?int $page = null,
        protected ?string $sort = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page, 'sort' => $this->sort]);
    }
}
