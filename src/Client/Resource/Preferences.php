<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Preferences\DeletePreferences;
use ConduitUI\Mattermost\Client\Requests\Preferences\GetPreferences;
use ConduitUI\Mattermost\Client\Requests\Preferences\GetPreferencesByCategory;
use ConduitUI\Mattermost\Client\Requests\Preferences\GetPreferencesByCategoryByName;
use ConduitUI\Mattermost\Client\Requests\Preferences\UpdatePreferences;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Preferences extends BaseResource
{
    /**
     * @param  string  $userId  User GUID
     */
    public function getPreferences(string $userId): Response
    {
        return $this->connector->send(new GetPreferences($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function updatePreferences(string $userId): Response
    {
        return $this->connector->send(new UpdatePreferences($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function deletePreferences(string $userId): Response
    {
        return $this->connector->send(new DeletePreferences($userId));
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $category  The category of a group of preferences
     */
    public function getPreferencesByCategory(string $userId, string $category): Response
    {
        return $this->connector->send(new GetPreferencesByCategory($userId, $category));
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $category  The category of a group of preferences
     * @param  string  $preferenceName  The name of the preference
     */
    public function getPreferencesByCategoryByName(string $userId, string $category, string $preferenceName): Response
    {
        return $this->connector->send(new GetPreferencesByCategoryByName($userId, $category, $preferenceName));
    }
}
