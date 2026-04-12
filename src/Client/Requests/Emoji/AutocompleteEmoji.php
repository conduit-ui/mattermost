<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Emoji;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * AutocompleteEmoji
 *
 * Get a list of custom emoji with names starting with or matching the provided name. Returns a maximum
 * of 100 results.
 * ##### Permissions
 * Must be authenticated.
 *
 * __Minimum server version__: 4.7
 */
class AutocompleteEmoji extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/emoji/autocomplete';
    }

    /**
     * @param  string  $name  The emoji name to search.
     */
    public function __construct(
        protected string $name,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['name' => $this->name]);
    }
}
