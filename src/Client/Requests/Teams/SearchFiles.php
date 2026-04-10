<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SearchFiles
 *
 * Search for files in a team based on file name, extention and file content (if file content
 * extraction is enabled and supported for the files).
 * __Minimum server version__: 5.34
 * #####
 * Permissions
 * Must be authenticated and have the `view_team` permission.
 */
class SearchFiles extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/files/search";
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function __construct(
		protected string $teamId,
	) {
	}
}
