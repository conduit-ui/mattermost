<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Reactions\DeleteReaction;
use ConduitUI\Mattermost\Client\Requests\Reactions\GetBulkReactions;
use ConduitUI\Mattermost\Client\Requests\Reactions\GetReactions;
use ConduitUI\Mattermost\Client\Requests\Reactions\SaveReaction;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Reactions extends BaseResource
{
    public function getBulkReactions(): Response
    {
        return $this->connector->send(new GetBulkReactions);
    }

    /**
     * @param  string  $postId  ID of a post
     */
    public function getReactions(string $postId): Response
    {
        return $this->connector->send(new GetReactions($postId));
    }

    public function saveReaction(): Response
    {
        return $this->connector->send(new SaveReaction);
    }

    /**
     * @param  string  $userId  ID of the user
     * @param  string  $postId  ID of the post
     * @param  string  $emojiName  emoji name
     */
    public function deleteReaction(string $userId, string $postId, string $emojiName): Response
    {
        return $this->connector->send(new DeleteReaction($userId, $postId, $emojiName));
    }
}
