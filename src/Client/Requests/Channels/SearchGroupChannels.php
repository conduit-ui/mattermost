<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SearchGroupChannels
 *
 * Get a list of group channels for a user which members' usernames match the search term.
 *
 * __Minimum
 * server version__: 5.14
 */
class SearchGroupChannels extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/group/search";
	}


	public function __construct()
	{
	}
}
