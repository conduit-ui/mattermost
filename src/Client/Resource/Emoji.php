<?php

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Emoji\AutocompleteEmoji;
use ConduitUI\Mattermost\Client\Requests\Emoji\CreateEmoji;
use ConduitUI\Mattermost\Client\Requests\Emoji\DeleteEmoji;
use ConduitUI\Mattermost\Client\Requests\Emoji\GetEmoji;
use ConduitUI\Mattermost\Client\Requests\Emoji\GetEmojiByName;
use ConduitUI\Mattermost\Client\Requests\Emoji\GetEmojiImage;
use ConduitUI\Mattermost\Client\Requests\Emoji\GetEmojiList;
use ConduitUI\Mattermost\Client\Requests\Emoji\SearchEmoji;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Emoji extends BaseResource
{
	/**
	 * @param int $page The page to select.
	 * @param string $sort Either blank for no sorting or "name" to sort by emoji names. Minimum server version for sorting is 4.7.
	 */
	public function getEmojiList(?int $page = null, ?string $sort = null): Response
	{
		return $this->connector->send(new GetEmojiList($page, $sort));
	}


	public function createEmoji(): Response
	{
		return $this->connector->send(new CreateEmoji());
	}


	/**
	 * @param string $name The emoji name to search.
	 */
	public function autocompleteEmoji(string $name): Response
	{
		return $this->connector->send(new AutocompleteEmoji($name));
	}


	/**
	 * @param string $emojiName Emoji name
	 */
	public function getEmojiByName(string $emojiName): Response
	{
		return $this->connector->send(new GetEmojiByName($emojiName));
	}


	public function searchEmoji(): Response
	{
		return $this->connector->send(new SearchEmoji());
	}


	/**
	 * @param string $emojiId Emoji GUID
	 */
	public function getEmoji(string $emojiId): Response
	{
		return $this->connector->send(new GetEmoji($emojiId));
	}


	/**
	 * @param string $emojiId Emoji GUID
	 */
	public function deleteEmoji(string $emojiId): Response
	{
		return $this->connector->send(new DeleteEmoji($emojiId));
	}


	/**
	 * @param string $emojiId Emoji GUID
	 */
	public function getEmojiImage(string $emojiId): Response
	{
		return $this->connector->send(new GetEmojiImage($emojiId));
	}
}
