<?php

namespace ConduitUI\Mattermost\Client\Requests\Emoji;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetEmojiImage
 *
 * Get the image for a custom emoji.
 * ##### Permissions
 * Must be authenticated.
 */
class GetEmojiImage extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/emoji/{$this->emojiId}/image";
	}


	/**
	 * @param string $emojiId Emoji GUID
	 */
	public function __construct(
		protected string $emojiId,
	) {
	}
}
