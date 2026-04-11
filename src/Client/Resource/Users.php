<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Users\AttachDeviceId;
use ConduitUI\Mattermost\Client\Requests\Users\AutocompleteUsers;
use ConduitUI\Mattermost\Client\Requests\Users\CheckUserMfa;
use ConduitUI\Mattermost\Client\Requests\Users\CreateUser;
use ConduitUI\Mattermost\Client\Requests\Users\CreateUserAccessToken;
use ConduitUI\Mattermost\Client\Requests\Users\DeleteUser;
use ConduitUI\Mattermost\Client\Requests\Users\DemoteUserToGuest;
use ConduitUI\Mattermost\Client\Requests\Users\DisableUserAccessToken;
use ConduitUI\Mattermost\Client\Requests\Users\EnableUserAccessToken;
use ConduitUI\Mattermost\Client\Requests\Users\GenerateMfaSecret;
use ConduitUI\Mattermost\Client\Requests\Users\GetChannelMembersWithTeamDataForUser;
use ConduitUI\Mattermost\Client\Requests\Users\GetKnownUsers;
use ConduitUI\Mattermost\Client\Requests\Users\GetSessions;
use ConduitUI\Mattermost\Client\Requests\Users\GetTotalUsersStats;
use ConduitUI\Mattermost\Client\Requests\Users\GetTotalUsersStatsFiltered;
use ConduitUI\Mattermost\Client\Requests\Users\GetUploadsForUser;
use ConduitUI\Mattermost\Client\Requests\Users\GetUser;
use ConduitUI\Mattermost\Client\Requests\Users\GetUserAccessToken;
use ConduitUI\Mattermost\Client\Requests\Users\GetUserAccessTokens;
use ConduitUI\Mattermost\Client\Requests\Users\GetUserAccessTokensForUser;
use ConduitUI\Mattermost\Client\Requests\Users\GetUserAudits;
use ConduitUI\Mattermost\Client\Requests\Users\GetUserByEmail;
use ConduitUI\Mattermost\Client\Requests\Users\GetUserByUsername;
use ConduitUI\Mattermost\Client\Requests\Users\GetUsers;
use ConduitUI\Mattermost\Client\Requests\Users\GetUsersByGroupChannelIds;
use ConduitUI\Mattermost\Client\Requests\Users\GetUsersByIds;
use ConduitUI\Mattermost\Client\Requests\Users\GetUsersByUsernames;
use ConduitUI\Mattermost\Client\Requests\Users\GetUserTermsOfService;
use ConduitUI\Mattermost\Client\Requests\Users\Login;
use ConduitUI\Mattermost\Client\Requests\Users\LoginByCwsToken;
use ConduitUI\Mattermost\Client\Requests\Users\Logout;
use ConduitUI\Mattermost\Client\Requests\Users\MigrateAuthToLdap;
use ConduitUI\Mattermost\Client\Requests\Users\MigrateAuthToSaml;
use ConduitUI\Mattermost\Client\Requests\Users\PatchUser;
use ConduitUI\Mattermost\Client\Requests\Users\PermanentDeleteAllUsers;
use ConduitUI\Mattermost\Client\Requests\Users\PromoteGuestToUser;
use ConduitUI\Mattermost\Client\Requests\Users\PublishUserTyping;
use ConduitUI\Mattermost\Client\Requests\Users\RegisterTermsOfServiceAction;
use ConduitUI\Mattermost\Client\Requests\Users\ResetPassword;
use ConduitUI\Mattermost\Client\Requests\Users\RevokeAllSessions;
use ConduitUI\Mattermost\Client\Requests\Users\RevokeSession;
use ConduitUI\Mattermost\Client\Requests\Users\RevokeSessionsFromAllUsers;
use ConduitUI\Mattermost\Client\Requests\Users\RevokeUserAccessToken;
use ConduitUI\Mattermost\Client\Requests\Users\SearchUserAccessTokens;
use ConduitUI\Mattermost\Client\Requests\Users\SearchUsers;
use ConduitUI\Mattermost\Client\Requests\Users\SendPasswordResetEmail;
use ConduitUI\Mattermost\Client\Requests\Users\SendVerificationEmail;
use ConduitUI\Mattermost\Client\Requests\Users\SwitchAccountType;
use ConduitUI\Mattermost\Client\Requests\Users\UpdateUser;
use ConduitUI\Mattermost\Client\Requests\Users\UpdateUserActive;
use ConduitUI\Mattermost\Client\Requests\Users\UpdateUserAuth;
use ConduitUI\Mattermost\Client\Requests\Users\UpdateUserMfa;
use ConduitUI\Mattermost\Client\Requests\Users\UpdateUserPassword;
use ConduitUI\Mattermost\Client\Requests\Users\UpdateUserRoles;
use ConduitUI\Mattermost\Client\Requests\Users\VerifyUserEmail;
use ConduitUI\Mattermost\Client\Requests\Users\VerifyUserEmailWithoutToken;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Users extends BaseResource
{
    /**
     * @param  int  $page  The page to select.
     * @param  string  $inTeam  The ID of the team to get users for.
     * @param  string  $notInTeam  The ID of the team to exclude users for. Must not be used with "in_team" query parameter.
     * @param  string  $inChannel  The ID of the channel to get users for.
     * @param  string  $notInChannel  The ID of the channel to exclude users for. Must be used with "in_channel" query parameter.
     * @param  string  $inGroup  The ID of the group to get users for. Must have `manage_system` permission.
     * @param  bool  $groupConstrained  When used with `not_in_channel` or `not_in_team`, returns only the users that are allowed to join the channel or team based on its group constrains.
     * @param  bool  $withoutTeam  Whether or not to list users that are not on any team. This option takes precendence over `in_team`, `in_channel`, and `not_in_channel`.
     * @param  bool  $active  Whether or not to list only users that are active. This option cannot be used along with the `inactive` option.
     * @param  bool  $inactive  Whether or not to list only users that are deactivated. This option cannot be used along with the `active` option.
     * @param  string  $role  Returns users that have this role.
     * @param  string  $sort  Sort is only available in conjunction with certain options below. The paging parameter is also always available.
     *
     * ##### `in_team`
     * Can be "", "last_activity_at" or "create_at".
     * When left blank, sorting is done by username.
     * __Minimum server version__: 4.0
     * ##### `in_channel`
     * Can be "", "status".
     * When left blank, sorting is done by username. `status` will sort by User's current status (Online, Away, DND, Offline), then by Username.
     * __Minimum server version__: 4.7
     * ##### `in_group`
     * Can be "", "display_name".
     * When left blank, sorting is done by username. `display_name` will sort alphabetically by user's display name.
     * __Minimum server version__: 7.7
     * @param  string  $roles  Comma separated string used to filter users based on any of the specified system roles
     *
     * Example: `?roles=system_admin,system_user` will return users that are either system admins or system users
     *
     * __Minimum server version__: 5.26
     * @param  string  $channelRoles  Comma separated string used to filter users based on any of the specified channel roles, can only be used in conjunction with `in_channel`
     *
     * Example: `?in_channel=4eb6axxw7fg3je5iyasnfudc5y&channel_roles=channel_user` will return users that are only channel users and not admins or guests
     *
     * __Minimum server version__: 5.26
     * @param  string  $teamRoles  Comma separated string used to filter users based on any of the specified team roles, can only be used in conjunction with `in_team`
     *
     * Example: `?in_team=4eb6axxw7fg3je5iyasnfudc5y&team_roles=team_user` will return users that are only team users and not admins or guests
     *
     * __Minimum server version__: 5.26
     */
    public function getUsers(
        ?int $page = null,
        ?string $inTeam = null,
        ?string $notInTeam = null,
        ?string $inChannel = null,
        ?string $notInChannel = null,
        ?string $inGroup = null,
        ?bool $groupConstrained = null,
        ?bool $withoutTeam = null,
        ?bool $active = null,
        ?bool $inactive = null,
        ?string $role = null,
        ?string $sort = null,
        ?string $roles = null,
        ?string $channelRoles = null,
        ?string $teamRoles = null,
    ): Response {
        return $this->connector->send(new GetUsers($page, $inTeam, $notInTeam, $inChannel, $notInChannel, $inGroup, $groupConstrained, $withoutTeam, $active, $inactive, $role, $sort, $roles, $channelRoles, $teamRoles));
    }

    /**
     * @param  string  $t  Token id from an email invitation
     * @param  string  $iid  Token id from an invitation link
     */
    public function createUser(?string $t = null, ?string $iid = null): Response
    {
        return $this->connector->send(new CreateUser($t, $iid));
    }

    public function permanentDeleteAllUsers(): Response
    {
        return $this->connector->send(new PermanentDeleteAllUsers);
    }

    /**
     * @param  string  $teamId  Team ID
     * @param  string  $channelId  Channel ID
     * @param  string  $name  Username, nickname first name or last name
     * @param  int  $limit  The maximum number of users to return in each subresult
     *
     * __Available as of server version 5.6. Defaults to `100` if not provided or on an earlier server version.__
     */
    public function autocompleteUsers(
        ?string $teamId,
        ?string $channelId,
        string $name,
        ?int $limit = null,
    ): Response {
        return $this->connector->send(new AutocompleteUsers($teamId, $channelId, $name, $limit));
    }

    public function verifyUserEmail(): Response
    {
        return $this->connector->send(new VerifyUserEmail);
    }

    public function sendVerificationEmail(): Response
    {
        return $this->connector->send(new SendVerificationEmail);
    }

    /**
     * @param  string  $email  User Email
     */
    public function getUserByEmail(string $email): Response
    {
        return $this->connector->send(new GetUserByEmail($email));
    }

    public function getUsersByGroupChannelIds(): Response
    {
        return $this->connector->send(new GetUsersByGroupChannelIds);
    }

    /**
     * @param  int  $since  Only return users that have been modified since the given Unix timestamp (in milliseconds).
     *
     * __Minimum server version__: 5.14
     */
    public function getUsersByIds(?int $since = null): Response
    {
        return $this->connector->send(new GetUsersByIds($since));
    }

    public function getKnownUsers(): Response
    {
        return $this->connector->send(new GetKnownUsers);
    }

    public function login(): Response
    {
        return $this->connector->send(new Login);
    }

    public function loginByCwsToken(): Response
    {
        return $this->connector->send(new LoginByCwsToken);
    }

    public function switchAccountType(): Response
    {
        return $this->connector->send(new SwitchAccountType);
    }

    public function logout(): Response
    {
        return $this->connector->send(new Logout);
    }

    public function checkUserMfa(): Response
    {
        return $this->connector->send(new CheckUserMfa);
    }

    public function migrateAuthToLdap(): Response
    {
        return $this->connector->send(new MigrateAuthToLdap);
    }

    public function migrateAuthToSaml(): Response
    {
        return $this->connector->send(new MigrateAuthToSaml);
    }

    public function resetPassword(): Response
    {
        return $this->connector->send(new ResetPassword);
    }

    public function sendPasswordResetEmail(): Response
    {
        return $this->connector->send(new SendPasswordResetEmail);
    }

    public function searchUsers(): Response
    {
        return $this->connector->send(new SearchUsers);
    }

    public function attachDeviceId(): Response
    {
        return $this->connector->send(new AttachDeviceId);
    }

    public function revokeSessionsFromAllUsers(): Response
    {
        return $this->connector->send(new RevokeSessionsFromAllUsers);
    }

    public function getTotalUsersStats(): Response
    {
        return $this->connector->send(new GetTotalUsersStats);
    }

    /**
     * @param  string  $inTeam  The ID of the team to get user stats for.
     * @param  string  $inChannel  The ID of the channel to get user stats for.
     * @param  bool  $includeDeleted  If deleted accounts should be included in the count.
     * @param  bool  $includeBots  If bot accounts should be included in the count.
     * @param  string  $roles  Comma separated string used to filter users based on any of the specified system roles
     *
     * Example: `?roles=system_admin,system_user` will include users that are either system admins or system users
     * @param  string  $channelRoles  Comma separated string used to filter users based on any of the specified channel roles, can only be used in conjunction with `in_channel`
     *
     * Example: `?in_channel=4eb6axxw7fg3je5iyasnfudc5y&channel_roles=channel_user` will include users that are only channel users and not admins or guests
     * @param  string  $teamRoles  Comma separated string used to filter users based on any of the specified team roles, can only be used in conjunction with `in_team`
     *
     * Example: `?in_team=4eb6axxw7fg3je5iyasnfudc5y&team_roles=team_user` will include users that are only team users and not admins or guests
     */
    public function getTotalUsersStatsFiltered(
        ?string $inTeam = null,
        ?string $inChannel = null,
        ?bool $includeDeleted = null,
        ?bool $includeBots = null,
        ?string $roles = null,
        ?string $channelRoles = null,
        ?string $teamRoles = null,
    ): Response {
        return $this->connector->send(new GetTotalUsersStatsFiltered($inTeam, $inChannel, $includeDeleted, $includeBots, $roles, $channelRoles, $teamRoles));
    }

    /**
     * @param  int  $page  The page to select.
     */
    public function getUserAccessTokens(?int $page = null): Response
    {
        return $this->connector->send(new GetUserAccessTokens($page));
    }

    public function disableUserAccessToken(): Response
    {
        return $this->connector->send(new DisableUserAccessToken);
    }

    public function enableUserAccessToken(): Response
    {
        return $this->connector->send(new EnableUserAccessToken);
    }

    public function revokeUserAccessToken(): Response
    {
        return $this->connector->send(new RevokeUserAccessToken);
    }

    public function searchUserAccessTokens(): Response
    {
        return $this->connector->send(new SearchUserAccessTokens);
    }

    /**
     * @param  string  $tokenId  User access token GUID
     */
    public function getUserAccessToken(string $tokenId): Response
    {
        return $this->connector->send(new GetUserAccessToken($tokenId));
    }

    /**
     * @param  string  $username  Username
     */
    public function getUserByUsername(string $username): Response
    {
        return $this->connector->send(new GetUserByUsername($username));
    }

    public function getUsersByUsernames(): Response
    {
        return $this->connector->send(new GetUsersByUsernames);
    }

    /**
     * @param  string  $userId  User GUID. This can also be "me" which will point to the current user.
     */
    public function getUser(string $userId): Response
    {
        return $this->connector->send(new GetUser($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function updateUser(string $userId): Response
    {
        return $this->connector->send(new UpdateUser($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function deleteUser(string $userId): Response
    {
        return $this->connector->send(new DeleteUser($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function updateUserActive(string $userId): Response
    {
        return $this->connector->send(new UpdateUserActive($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function getUserAudits(string $userId): Response
    {
        return $this->connector->send(new GetUserAudits($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function updateUserAuth(string $userId): Response
    {
        return $this->connector->send(new UpdateUserAuth($userId));
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  int  $page  Page specifies which part of the results to return, by PageSize.
     * @param  int  $pageSize  PageSize specifies the size of the returned chunk of results.
     */
    public function getChannelMembersWithTeamDataForUser(
        string $userId,
        ?int $page = null,
        ?int $pageSize = null,
    ): Response {
        return $this->connector->send(new GetChannelMembersWithTeamDataForUser($userId, $page, $pageSize));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function demoteUserToGuest(string $userId): Response
    {
        return $this->connector->send(new DemoteUserToGuest($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function verifyUserEmailWithoutToken(string $userId): Response
    {
        return $this->connector->send(new VerifyUserEmailWithoutToken($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function updateUserMfa(string $userId): Response
    {
        return $this->connector->send(new UpdateUserMfa($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function generateMfaSecret(string $userId): Response
    {
        return $this->connector->send(new GenerateMfaSecret($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function updateUserPassword(string $userId): Response
    {
        return $this->connector->send(new UpdateUserPassword($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function patchUser(string $userId): Response
    {
        return $this->connector->send(new PatchUser($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function promoteGuestToUser(string $userId): Response
    {
        return $this->connector->send(new PromoteGuestToUser($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function updateUserRoles(string $userId): Response
    {
        return $this->connector->send(new UpdateUserRoles($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function getSessions(string $userId): Response
    {
        return $this->connector->send(new GetSessions($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function revokeSession(string $userId): Response
    {
        return $this->connector->send(new RevokeSession($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function revokeAllSessions(string $userId): Response
    {
        return $this->connector->send(new RevokeAllSessions($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function getUserTermsOfService(string $userId): Response
    {
        return $this->connector->send(new GetUserTermsOfService($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function registerTermsOfServiceAction(string $userId): Response
    {
        return $this->connector->send(new RegisterTermsOfServiceAction($userId));
    }

    /**
     * @param  string  $userId  User GUID
     * @param  int  $page  The page to select.
     */
    public function getUserAccessTokensForUser(string $userId, ?int $page = null): Response
    {
        return $this->connector->send(new GetUserAccessTokensForUser($userId, $page));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function createUserAccessToken(string $userId): Response
    {
        return $this->connector->send(new CreateUserAccessToken($userId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function publishUserTyping(string $userId): Response
    {
        return $this->connector->send(new PublishUserTyping($userId));
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     */
    public function getUploadsForUser(string $userId): Response
    {
        return $this->connector->send(new GetUploadsForUser($userId));
    }
}
