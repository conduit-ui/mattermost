<?php

namespace ConduitUI\Mattermost\Client\Requests\System;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetNotices
 *
 * Will return appropriate product notices for current user in the team specified by teamId
 * parameter.
 * __Minimum server version__: 5.26
 * ##### Permissions
 * Must be logged in.
 */
class GetNotices extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/system/notices/{$this->teamId}";
	}


	/**
	 * @param string $teamId ID of the team
	 * @param string $clientVersion Version of the client (desktop/mobile/web) that issues the request
	 * @param null|string $locale Client locale
	 * @param string $client Client type (web/mobile-ios/mobile-android/desktop)
	 */
	public function __construct(
		protected string $teamId,
		protected string $clientVersion,
		protected ?string $locale = null,
		protected string $client,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['clientVersion' => $this->clientVersion, 'locale' => $this->locale, 'client' => $this->client]);
	}
}
