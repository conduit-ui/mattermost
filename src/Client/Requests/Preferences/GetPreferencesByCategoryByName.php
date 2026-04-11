<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Preferences;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetPreferencesByCategoryByName
 *
 * Gets a single preference for the current user with the given category and name.
 * #####
 * Permissions
 * Must be logged in as the user being updated or have the `edit_other_users` permission.
 */
class GetPreferencesByCategoryByName extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/preferences/{$this->category}/name/{$this->preferenceName}";
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $category  The category of a group of preferences
     * @param  string  $preferenceName  The name of the preference
     */
    public function __construct(
        protected string $userId,
        protected string $category,
        protected string $preferenceName,
    ) {}
}
