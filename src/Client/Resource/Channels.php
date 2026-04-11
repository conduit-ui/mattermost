<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Channels\AddChannelMember;
use ConduitUI\Mattermost\Client\Requests\Channels\AutocompleteChannelsForTeam;
use ConduitUI\Mattermost\Client\Requests\Channels\AutocompleteChannelsForTeamForSearch;
use ConduitUI\Mattermost\Client\Requests\Channels\ChannelMembersMinusGroupMembers;
use ConduitUI\Mattermost\Client\Requests\Channels\CreateChannel;
use ConduitUI\Mattermost\Client\Requests\Channels\CreateDirectChannel;
use ConduitUI\Mattermost\Client\Requests\Channels\CreateGroupChannel;
use ConduitUI\Mattermost\Client\Requests\Channels\CreateSidebarCategoryForTeamForUser;
use ConduitUI\Mattermost\Client\Requests\Channels\DeleteChannel;
use ConduitUI\Mattermost\Client\Requests\Channels\GetAllChannels;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannel;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelByName;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelByNameForTeamName;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelMember;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelMemberCountsByGroup;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelMembers;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelMembersByIds;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelMembersForUser;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelMembersTimezones;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelModerations;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelsForTeamForUser;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelsForUser;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelStats;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelUnread;
use ConduitUI\Mattermost\Client\Requests\Channels\GetDeletedChannelsForTeam;
use ConduitUI\Mattermost\Client\Requests\Channels\GetPinnedPosts;
use ConduitUI\Mattermost\Client\Requests\Channels\GetPrivateChannelsForTeam;
use ConduitUI\Mattermost\Client\Requests\Channels\GetPublicChannelsByIdsForTeam;
use ConduitUI\Mattermost\Client\Requests\Channels\GetPublicChannelsForTeam;
use ConduitUI\Mattermost\Client\Requests\Channels\GetSidebarCategoriesForTeamForUser;
use ConduitUI\Mattermost\Client\Requests\Channels\GetSidebarCategoryForTeamForUser;
use ConduitUI\Mattermost\Client\Requests\Channels\GetSidebarCategoryOrderForTeamForUser;
use ConduitUI\Mattermost\Client\Requests\Channels\MoveChannel;
use ConduitUI\Mattermost\Client\Requests\Channels\PatchChannel;
use ConduitUI\Mattermost\Client\Requests\Channels\PatchChannelModerations;
use ConduitUI\Mattermost\Client\Requests\Channels\RemoveSidebarCategoryForTeamForUser;
use ConduitUI\Mattermost\Client\Requests\Channels\RemoveUserFromChannel;
use ConduitUI\Mattermost\Client\Requests\Channels\RestoreChannel;
use ConduitUI\Mattermost\Client\Requests\Channels\SearchAllChannels;
use ConduitUI\Mattermost\Client\Requests\Channels\SearchArchivedChannels;
use ConduitUI\Mattermost\Client\Requests\Channels\SearchChannels;
use ConduitUI\Mattermost\Client\Requests\Channels\SearchGroupChannels;
use ConduitUI\Mattermost\Client\Requests\Channels\UpdateChannel;
use ConduitUI\Mattermost\Client\Requests\Channels\UpdateChannelMemberSchemeRoles;
use ConduitUI\Mattermost\Client\Requests\Channels\UpdateChannelNotifyProps;
use ConduitUI\Mattermost\Client\Requests\Channels\UpdateChannelPrivacy;
use ConduitUI\Mattermost\Client\Requests\Channels\UpdateChannelRoles;
use ConduitUI\Mattermost\Client\Requests\Channels\UpdateChannelScheme;
use ConduitUI\Mattermost\Client\Requests\Channels\UpdateSidebarCategoriesForTeamForUser;
use ConduitUI\Mattermost\Client\Requests\Channels\UpdateSidebarCategoryForTeamForUser;
use ConduitUI\Mattermost\Client\Requests\Channels\UpdateSidebarCategoryOrderForTeamForUser;
use ConduitUI\Mattermost\Client\Requests\Channels\ViewChannel;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Channels extends BaseResource
{
    /**
     * @param  string  $notAssociatedToGroup  A group id to exclude channels that are associated with that group via GroupChannel records. This can also be left blank with `not_associated_to_group=`.
     * @param  int  $page  The page to select.
     * @param  bool  $excludeDefaultChannels  Whether to exclude default channels (ex Town Square, Off-Topic) from the results.
     * @param  bool  $includeDeleted  Include channels that have been archived. This correlates to the `DeleteAt` flag being set in the database.
     * @param  bool  $includeTotalCount  Appends a total count of returned channels inside the response object - ex: `{ "channels": [], "total_count" : 0 }`.
     * @param  bool  $excludePolicyConstrained  If set to true, channels which are part of a data retention policy will be excluded. The `sysconsole_read_compliance` permission is required to use this parameter.
     *                                          __Minimum server version__: 5.35
     */
    public function getAllChannels(
        ?string $notAssociatedToGroup = null,
        ?int $page = null,
        ?bool $excludeDefaultChannels = null,
        ?bool $includeDeleted = null,
        ?bool $includeTotalCount = null,
        ?bool $excludePolicyConstrained = null,
    ): Response {
        return $this->connector->send(new GetAllChannels($notAssociatedToGroup, $page, $excludeDefaultChannels, $includeDeleted, $includeTotalCount, $excludePolicyConstrained));
    }

    public function createChannel(): Response
    {
        return $this->connector->send(new CreateChannel);
    }

    public function createDirectChannel(): Response
    {
        return $this->connector->send(new CreateDirectChannel);
    }

    public function createGroupChannel(): Response
    {
        return $this->connector->send(new CreateGroupChannel);
    }

    public function searchGroupChannels(): Response
    {
        return $this->connector->send(new SearchGroupChannels);
    }

    /**
     * @param  string  $userId  User ID to perform the view action for
     */
    public function viewChannel(string $userId): Response
    {
        return $this->connector->send(new ViewChannel($userId));
    }

    /**
     * @param  bool  $systemConsole  Is the request from system_console. If this is set to true, it filters channels by the logged in user.
     */
    public function searchAllChannels(?bool $systemConsole = null): Response
    {
        return $this->connector->send(new SearchAllChannels($systemConsole));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function getChannel(string $channelId): Response
    {
        return $this->connector->send(new GetChannel($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function updateChannel(string $channelId): Response
    {
        return $this->connector->send(new UpdateChannel($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function deleteChannel(string $channelId): Response
    {
        return $this->connector->send(new DeleteChannel($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     * @param  bool  $includeTimezones  Defines if member timezone counts should be returned or not
     */
    public function getChannelMemberCountsByGroup(string $channelId, ?bool $includeTimezones = null): Response
    {
        return $this->connector->send(new GetChannelMemberCountsByGroup($channelId, $includeTimezones));
    }

    /**
     * @param  string  $channelId  Channel GUID
     * @param  int  $page  The page to select.
     */
    public function getChannelMembers(string $channelId, ?int $page = null): Response
    {
        return $this->connector->send(new GetChannelMembers($channelId, $page));
    }

    /**
     * @param  string  $channelId  The channel ID
     */
    public function addChannelMember(string $channelId): Response
    {
        return $this->connector->send(new AddChannelMember($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function getChannelMembersByIds(string $channelId): Response
    {
        return $this->connector->send(new GetChannelMembersByIds($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     * @param  string  $userId  User GUID
     */
    public function getChannelMember(string $channelId, string $userId): Response
    {
        return $this->connector->send(new GetChannelMember($channelId, $userId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     * @param  string  $userId  User GUID
     */
    public function removeUserFromChannel(string $channelId, string $userId): Response
    {
        return $this->connector->send(new RemoveUserFromChannel($channelId, $userId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     * @param  string  $userId  User GUID
     */
    public function updateChannelNotifyProps(string $channelId, string $userId): Response
    {
        return $this->connector->send(new UpdateChannelNotifyProps($channelId, $userId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     * @param  string  $userId  User GUID
     */
    public function updateChannelRoles(string $channelId, string $userId): Response
    {
        return $this->connector->send(new UpdateChannelRoles($channelId, $userId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     * @param  string  $userId  User GUID
     */
    public function updateChannelMemberSchemeRoles(string $channelId, string $userId): Response
    {
        return $this->connector->send(new UpdateChannelMemberSchemeRoles($channelId, $userId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     * @param  string  $groupIds  A comma-separated list of group ids.
     * @param  int  $page  The page to select.
     */
    public function channelMembersMinusGroupMembers(string $channelId, string $groupIds, ?int $page = null): Response
    {
        return $this->connector->send(new ChannelMembersMinusGroupMembers($channelId, $groupIds, $page));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function getChannelModerations(string $channelId): Response
    {
        return $this->connector->send(new GetChannelModerations($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function patchChannelModerations(string $channelId): Response
    {
        return $this->connector->send(new PatchChannelModerations($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function moveChannel(string $channelId): Response
    {
        return $this->connector->send(new MoveChannel($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function patchChannel(string $channelId): Response
    {
        return $this->connector->send(new PatchChannel($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function getPinnedPosts(string $channelId): Response
    {
        return $this->connector->send(new GetPinnedPosts($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function updateChannelPrivacy(string $channelId): Response
    {
        return $this->connector->send(new UpdateChannelPrivacy($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function restoreChannel(string $channelId): Response
    {
        return $this->connector->send(new RestoreChannel($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function updateChannelScheme(string $channelId): Response
    {
        return $this->connector->send(new UpdateChannelScheme($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function getChannelStats(string $channelId): Response
    {
        return $this->connector->send(new GetChannelStats($channelId));
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function getChannelMembersTimezones(string $channelId): Response
    {
        return $this->connector->send(new GetChannelMembersTimezones($channelId));
    }

    /**
     * @param  string  $teamName  Team Name
     * @param  string  $channelName  Channel Name
     * @param  bool  $includeDeleted  Defines if deleted channels should be returned or not (Mattermost Server 5.26.0+)
     */
    public function getChannelByNameForTeamName(
        string $teamName,
        string $channelName,
        ?bool $includeDeleted = null,
    ): Response {
        return $this->connector->send(new GetChannelByNameForTeamName($teamName, $channelName, $includeDeleted));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  int  $page  The page to select.
     */
    public function getPublicChannelsForTeam(string $teamId, ?int $page = null): Response
    {
        return $this->connector->send(new GetPublicChannelsForTeam($teamId, $page));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $name  Name or display name
     */
    public function autocompleteChannelsForTeam(string $teamId, string $name): Response
    {
        return $this->connector->send(new AutocompleteChannelsForTeam($teamId, $name));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  int  $page  The page to select.
     */
    public function getDeletedChannelsForTeam(string $teamId, ?int $page = null): Response
    {
        return $this->connector->send(new GetDeletedChannelsForTeam($teamId, $page));
    }

    /**
     * @param  string  $teamId  Team GUID
     */
    public function getPublicChannelsByIdsForTeam(string $teamId): Response
    {
        return $this->connector->send(new GetPublicChannelsByIdsForTeam($teamId));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $channelName  Channel Name
     * @param  bool  $includeDeleted  Defines if deleted channels should be returned or not (Mattermost Server 5.26.0+)
     */
    public function getChannelByName(string $teamId, string $channelName, ?bool $includeDeleted = null): Response
    {
        return $this->connector->send(new GetChannelByName($teamId, $channelName, $includeDeleted));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  int  $page  The page to select.
     */
    public function getPrivateChannelsForTeam(string $teamId, ?int $page = null): Response
    {
        return $this->connector->send(new GetPrivateChannelsForTeam($teamId, $page));
    }

    /**
     * @param  string  $teamId  Team GUID
     */
    public function searchChannels(string $teamId): Response
    {
        return $this->connector->send(new SearchChannels($teamId));
    }

    /**
     * @param  string  $teamId  Team GUID
     */
    public function searchArchivedChannels(string $teamId): Response
    {
        return $this->connector->send(new SearchArchivedChannels($teamId));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $name  Name or display name
     */
    public function autocompleteChannelsForTeamForSearch(string $teamId, string $name): Response
    {
        return $this->connector->send(new AutocompleteChannelsForTeamForSearch($teamId, $name));
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  int  $lastDeleteAt  Filters the deleted channels by this time in epoch format. Does not have any effect if include_deleted is set to false.
     * @param  bool  $includeDeleted  Defines if deleted channels should be returned or not
     */
    public function getChannelsForUser(string $userId, ?int $lastDeleteAt = null, ?bool $includeDeleted = null): Response
    {
        return $this->connector->send(new GetChannelsForUser($userId, $lastDeleteAt, $includeDeleted));
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $channelId  Channel GUID
     */
    public function getChannelUnread(string $userId, string $channelId): Response
    {
        return $this->connector->send(new GetChannelUnread($userId, $channelId));
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $teamId  Team GUID
     * @param  bool  $includeDeleted  Defines if deleted channels should be returned or not
     * @param  int  $lastDeleteAt  Filters the deleted channels by this time in epoch format. Does not have any effect if include_deleted is set to false.
     */
    public function getChannelsForTeamForUser(
        string $userId,
        string $teamId,
        ?bool $includeDeleted = null,
        ?int $lastDeleteAt = null,
    ): Response {
        return $this->connector->send(new GetChannelsForTeamForUser($userId, $teamId, $includeDeleted, $lastDeleteAt));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $userId  User GUID
     */
    public function getSidebarCategoriesForTeamForUser(string $teamId, string $userId): Response
    {
        return $this->connector->send(new GetSidebarCategoriesForTeamForUser($teamId, $userId));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $userId  User GUID
     */
    public function updateSidebarCategoriesForTeamForUser(string $teamId, string $userId): Response
    {
        return $this->connector->send(new UpdateSidebarCategoriesForTeamForUser($teamId, $userId));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $userId  User GUID
     */
    public function createSidebarCategoryForTeamForUser(string $teamId, string $userId): Response
    {
        return $this->connector->send(new CreateSidebarCategoryForTeamForUser($teamId, $userId));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $userId  User GUID
     */
    public function getSidebarCategoryOrderForTeamForUser(string $teamId, string $userId): Response
    {
        return $this->connector->send(new GetSidebarCategoryOrderForTeamForUser($teamId, $userId));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $userId  User GUID
     */
    public function updateSidebarCategoryOrderForTeamForUser(string $teamId, string $userId): Response
    {
        return $this->connector->send(new UpdateSidebarCategoryOrderForTeamForUser($teamId, $userId));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $userId  User GUID
     * @param  string  $categoryId  Category GUID
     */
    public function getSidebarCategoryForTeamForUser(string $teamId, string $userId, string $categoryId): Response
    {
        return $this->connector->send(new GetSidebarCategoryForTeamForUser($teamId, $userId, $categoryId));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $userId  User GUID
     * @param  string  $categoryId  Category GUID
     */
    public function updateSidebarCategoryForTeamForUser(string $teamId, string $userId, string $categoryId): Response
    {
        return $this->connector->send(new UpdateSidebarCategoryForTeamForUser($teamId, $userId, $categoryId));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $userId  User GUID
     * @param  string  $categoryId  Category GUID
     */
    public function removeSidebarCategoryForTeamForUser(string $teamId, string $userId, string $categoryId): Response
    {
        return $this->connector->send(new RemoveSidebarCategoryForTeamForUser($teamId, $userId, $categoryId));
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $teamId  Team GUID
     */
    public function getChannelMembersForUser(string $userId, string $teamId): Response
    {
        return $this->connector->send(new GetChannelMembersForUser($userId, $teamId));
    }
}
