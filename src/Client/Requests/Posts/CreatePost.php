<?php

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreatePost
 *
 * Create a new post in a channel. To create the post as a comment on another post, provide
 * `root_id`.
 * ##### Permissions
 * Must have `create_post` permission for the channel the post is being
 * created in.
 */
class CreatePost extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/posts";
	}


	/**
	 * @param null|bool $setOnline Whether to set the user status as online or not.
	 */
	public function __construct(
		protected ?bool $setOnline = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['set_online' => $this->setOnline]);
	}
}
