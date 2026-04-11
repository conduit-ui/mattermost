<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Preferences;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetPreferencesByCategory
 *
 * Lists the current user's stored preferences in the given category.
 * ##### Permissions
 * Must be logged
 * in as the user being updated or have the `edit_other_users` permission.
 */
class GetPreferencesByCategory extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/preferences/{$this->category}";
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $category  The category of a group of preferences
     */
    public function __construct(
        protected string $userId,
        protected string $category,
    ) {}
}
