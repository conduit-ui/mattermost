<?php

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Teams\AddTeamMember;
use ConduitUI\Mattermost\Client\Requests\Teams\AddTeamMemberFromInvite;
use ConduitUI\Mattermost\Client\Requests\Teams\AddTeamMembers;
use ConduitUI\Mattermost\Client\Requests\Teams\CreateTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\GetAllTeams;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamByName;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamIcon;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamInviteInfo;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamMember;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamMembers;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamMembersByIds;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamMembersForUser;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamStats;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamUnread;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamsForUser;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamsUnreadForUser;
use ConduitUI\Mattermost\Client\Requests\Teams\ImportTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\InvalidateEmailInvites;
use ConduitUI\Mattermost\Client\Requests\Teams\InviteGuestsToTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\InviteUsersToTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\PatchTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\RegenerateTeamInviteId;
use ConduitUI\Mattermost\Client\Requests\Teams\RemoveTeamIcon;
use ConduitUI\Mattermost\Client\Requests\Teams\RemoveTeamMember;
use ConduitUI\Mattermost\Client\Requests\Teams\RestoreTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\SearchFiles;
use ConduitUI\Mattermost\Client\Requests\Teams\SearchTeams;
use ConduitUI\Mattermost\Client\Requests\Teams\SetTeamIcon;
use ConduitUI\Mattermost\Client\Requests\Teams\SoftDeleteTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\TeamExists;
use ConduitUI\Mattermost\Client\Requests\Teams\TeamMembersMinusGroupMembers;
use ConduitUI\Mattermost\Client\Requests\Teams\UpdateTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\UpdateTeamMemberRoles;
use ConduitUI\Mattermost\Client\Requests\Teams\UpdateTeamMemberSchemeRoles;
use ConduitUI\Mattermost\Client\Requests\Teams\UpdateTeamPrivacy;
use ConduitUI\Mattermost\Client\Requests\Teams\UpdateTeamScheme;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Teams extends BaseResource
{
	/**
	 * @param int $page The page to select.
	 * @param bool $includeTotalCount Appends a total count of returned teams inside the response object - ex: `{ "teams": [], "total_count" : 0 }`.
	 * @param bool $excludePolicyConstrained If set to true, teams which are part of a data retention policy will be excluded. The `sysconsole_read_compliance` permission is required to use this parameter.
	 * __Minimum server version__: 5.35
	 */
	public function getAllTeams(
		?int $page = null,
		?bool $includeTotalCount = null,
		?bool $excludePolicyConstrained = null,
	): Response
	{
		return $this->connector->send(new GetAllTeams($page, $includeTotalCount, $excludePolicyConstrained));
	}


	public function createTeam(): Response
	{
		return $this->connector->send(new CreateTeam());
	}


	/**
	 * @param string $inviteId Invite id for a team
	 */
	public function getTeamInviteInfo(string $inviteId): Response
	{
		return $this->connector->send(new GetTeamInviteInfo($inviteId));
	}


	public function invalidateEmailInvites(): Response
	{
		return $this->connector->send(new InvalidateEmailInvites());
	}


	/**
	 * @param string $token Token id from the invitation
	 */
	public function addTeamMemberFromInvite(string $token): Response
	{
		return $this->connector->send(new AddTeamMemberFromInvite($token));
	}


	/**
	 * @param string $name Team Name
	 */
	public function getTeamByName(string $name): Response
	{
		return $this->connector->send(new GetTeamByName($name));
	}


	/**
	 * @param string $name Team Name
	 */
	public function teamExists(string $name): Response
	{
		return $this->connector->send(new TeamExists($name));
	}


	public function searchTeams(): Response
	{
		return $this->connector->send(new SearchTeams());
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function getTeam(string $teamId): Response
	{
		return $this->connector->send(new GetTeam($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function updateTeam(string $teamId): Response
	{
		return $this->connector->send(new UpdateTeam($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 * @param bool $permanent Permanently delete the team, to be used for compliance reasons only. As of server version 5.0, `ServiceSettings.EnableAPITeamDeletion` must be set to `true` in the server's configuration.
	 */
	public function softDeleteTeam(string $teamId, ?bool $permanent = null): Response
	{
		return $this->connector->send(new SoftDeleteTeam($teamId, $permanent));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function searchFiles(string $teamId): Response
	{
		return $this->connector->send(new SearchFiles($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function getTeamIcon(string $teamId): Response
	{
		return $this->connector->send(new GetTeamIcon($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function setTeamIcon(string $teamId): Response
	{
		return $this->connector->send(new SetTeamIcon($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function removeTeamIcon(string $teamId): Response
	{
		return $this->connector->send(new RemoveTeamIcon($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function importTeam(string $teamId): Response
	{
		return $this->connector->send(new ImportTeam($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function inviteGuestsToTeam(string $teamId): Response
	{
		return $this->connector->send(new InviteGuestsToTeam($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function inviteUsersToTeam(string $teamId): Response
	{
		return $this->connector->send(new InviteUsersToTeam($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 * @param int $page The page to select.
	 */
	public function getTeamMembers(string $teamId, ?int $page = null): Response
	{
		return $this->connector->send(new GetTeamMembers($teamId, $page));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function addTeamMember(string $teamId): Response
	{
		return $this->connector->send(new AddTeamMember($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 * @param bool $graceful Instead of aborting the operation if a user cannot be added, return an arrray that will contain both the success and added members and the ones with error, in form of `[{"member": {...}, "user_id", "...", "error": {...}}]`
	 */
	public function addTeamMembers(string $teamId, ?bool $graceful = null): Response
	{
		return $this->connector->send(new AddTeamMembers($teamId, $graceful));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function getTeamMembersByIds(string $teamId): Response
	{
		return $this->connector->send(new GetTeamMembersByIds($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 * @param string $userId User GUID
	 */
	public function getTeamMember(string $teamId, string $userId): Response
	{
		return $this->connector->send(new GetTeamMember($teamId, $userId));
	}


	/**
	 * @param string $teamId Team GUID
	 * @param string $userId User GUID
	 */
	public function removeTeamMember(string $teamId, string $userId): Response
	{
		return $this->connector->send(new RemoveTeamMember($teamId, $userId));
	}


	/**
	 * @param string $teamId Team GUID
	 * @param string $userId User GUID
	 */
	public function updateTeamMemberRoles(string $teamId, string $userId): Response
	{
		return $this->connector->send(new UpdateTeamMemberRoles($teamId, $userId));
	}


	/**
	 * @param string $teamId Team GUID
	 * @param string $userId User GUID
	 */
	public function updateTeamMemberSchemeRoles(string $teamId, string $userId): Response
	{
		return $this->connector->send(new UpdateTeamMemberSchemeRoles($teamId, $userId));
	}


	/**
	 * @param string $teamId Team GUID
	 * @param string $groupIds A comma-separated list of group ids.
	 * @param int $page The page to select.
	 */
	public function teamMembersMinusGroupMembers(string $teamId, string $groupIds, ?int $page = null): Response
	{
		return $this->connector->send(new TeamMembersMinusGroupMembers($teamId, $groupIds, $page));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function patchTeam(string $teamId): Response
	{
		return $this->connector->send(new PatchTeam($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function updateTeamPrivacy(string $teamId): Response
	{
		return $this->connector->send(new UpdateTeamPrivacy($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function regenerateTeamInviteId(string $teamId): Response
	{
		return $this->connector->send(new RegenerateTeamInviteId($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function restoreTeam(string $teamId): Response
	{
		return $this->connector->send(new RestoreTeam($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function updateTeamScheme(string $teamId): Response
	{
		return $this->connector->send(new UpdateTeamScheme($teamId));
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function getTeamStats(string $teamId): Response
	{
		return $this->connector->send(new GetTeamStats($teamId));
	}


	/**
	 * @param string $userId User GUID
	 */
	public function getTeamsForUser(string $userId): Response
	{
		return $this->connector->send(new GetTeamsForUser($userId));
	}


	/**
	 * @param string $userId User GUID
	 */
	public function getTeamMembersForUser(string $userId): Response
	{
		return $this->connector->send(new GetTeamMembersForUser($userId));
	}


	/**
	 * @param string $userId User GUID
	 * @param string $excludeTeam Optional team id to be excluded from the results
	 * @param bool $includeCollapsedThreads Boolean to determine whether the collapsed threads should be included or not
	 */
	public function getTeamsUnreadForUser(
		string $userId,
		string $excludeTeam,
		?bool $includeCollapsedThreads = null,
	): Response
	{
		return $this->connector->send(new GetTeamsUnreadForUser($userId, $excludeTeam, $includeCollapsedThreads));
	}


	/**
	 * @param string $userId User GUID
	 * @param string $teamId Team GUID
	 */
	public function getTeamUnread(string $userId, string $teamId): Response
	{
		return $this->connector->send(new GetTeamUnread($userId, $teamId));
	}
}
