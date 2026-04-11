<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SearchAllChannels
 *
 * Returns all private and open type channels where 'term' matches on the name, display name, or
 * purpose of
 * the channel.
 *
 * Configured 'default' channels (ex Town Square and Off-Topic) can be
 * excluded from the results
 * with the `exclude_default_channels` boolean parameter.
 *
 * Channels that are
 * associated (via GroupChannel records) to a given group can be excluded from the results
 * with the
 * `not_associated_to_group` parameter and a group id string.
 */
class SearchAllChannels extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/channels/search';
    }

    /**
     * @param  null|bool  $systemConsole  Is the request from system_console. If this is set to true, it filters channels by the logged in user.
     */
    public function __construct(
        protected ?bool $systemConsole = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['system_console' => $this->systemConsole]);
    }
}
