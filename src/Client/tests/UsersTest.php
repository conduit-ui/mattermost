<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Mattermost;
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
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

beforeEach(function (): void {
    $this->mattermost = new Mattermost(
        bearerToken: 'replace'
    );
});

it('calls the getUsers method in the Users resource', function (): void {
    Saloon::fake([
        GetUsers::class => MockResponse::fixture('users.getUsers'),
    ]);

    $response = $this->mattermost->users()->getUsers(
        page: 123,
        inTeam: 'test string',
        notInTeam: 'test string',
        inChannel: 'test string',
        notInChannel: 'test string',
        inGroup: 'test string',
        groupConstrained: true,
        withoutTeam: true,
        active: true,
        inactive: true,
        role: 'test string',
        sort: 'test string',
        roles: 'test string',
        channelRoles: 'test string',
        teamRoles: 'test string'
    );

    Saloon::assertSent(GetUsers::class);

    expect($response->status())->toBe(200);
});

it('calls the createUser method in the Users resource', function (): void {
    Saloon::fake([
        CreateUser::class => MockResponse::fixture('users.createUser'),
    ]);

    $response = $this->mattermost->users()->createUser(
        t: 'test string',
        iid: 'test string'
    );

    Saloon::assertSent(CreateUser::class);

    expect($response->status())->toBe(200);
});

it('calls the permanentDeleteAllUsers method in the Users resource', function (): void {
    Saloon::fake([
        PermanentDeleteAllUsers::class => MockResponse::fixture('users.permanentDeleteAllUsers'),
    ]);

    $response = $this->mattermost->users()->permanentDeleteAllUsers(

    );

    Saloon::assertSent(PermanentDeleteAllUsers::class);

    expect($response->status())->toBe(200);
});

it('calls the autocompleteUsers method in the Users resource', function (): void {
    Saloon::fake([
        AutocompleteUsers::class => MockResponse::fixture('users.autocompleteUsers'),
    ]);

    $response = $this->mattermost->users()->autocompleteUsers(
        teamId: 'test string',
        channelId: 'test string',
        name: 'test string',
        limit: 123
    );

    Saloon::assertSent(AutocompleteUsers::class);

    expect($response->status())->toBe(200);
});

it('calls the verifyUserEmail method in the Users resource', function (): void {
    Saloon::fake([
        VerifyUserEmail::class => MockResponse::fixture('users.verifyUserEmail'),
    ]);

    $response = $this->mattermost->users()->verifyUserEmail(

    );

    Saloon::assertSent(VerifyUserEmail::class);

    expect($response->status())->toBe(200);
});

it('calls the sendVerificationEmail method in the Users resource', function (): void {
    Saloon::fake([
        SendVerificationEmail::class => MockResponse::fixture('users.sendVerificationEmail'),
    ]);

    $response = $this->mattermost->users()->sendVerificationEmail(

    );

    Saloon::assertSent(SendVerificationEmail::class);

    expect($response->status())->toBe(200);
});

it('calls the getUserByEmail method in the Users resource', function (): void {
    Saloon::fake([
        GetUserByEmail::class => MockResponse::fixture('users.getUserByEmail'),
    ]);

    $response = $this->mattermost->users()->getUserByEmail(
        email: 'test string'
    );

    Saloon::assertSent(GetUserByEmail::class);

    expect($response->status())->toBe(200);
});

it('calls the getUsersByGroupChannelIds method in the Users resource', function (): void {
    Saloon::fake([
        GetUsersByGroupChannelIds::class => MockResponse::fixture('users.getUsersByGroupChannelIds'),
    ]);

    $response = $this->mattermost->users()->getUsersByGroupChannelIds(

    );

    Saloon::assertSent(GetUsersByGroupChannelIds::class);

    expect($response->status())->toBe(200);
});

it('calls the getUsersByIds method in the Users resource', function (): void {
    Saloon::fake([
        GetUsersByIds::class => MockResponse::fixture('users.getUsersByIds'),
    ]);

    $response = $this->mattermost->users()->getUsersByIds(
        since: 123
    );

    Saloon::assertSent(GetUsersByIds::class);

    expect($response->status())->toBe(200);
});

it('calls the getKnownUsers method in the Users resource', function (): void {
    Saloon::fake([
        GetKnownUsers::class => MockResponse::fixture('users.getKnownUsers'),
    ]);

    $response = $this->mattermost->users()->getKnownUsers(

    );

    Saloon::assertSent(GetKnownUsers::class);

    expect($response->status())->toBe(200);
});

it('calls the login method in the Users resource', function (): void {
    Saloon::fake([
        Login::class => MockResponse::fixture('users.login'),
    ]);

    $response = $this->mattermost->users()->login(

    );

    Saloon::assertSent(Login::class);

    expect($response->status())->toBe(200);
});

it('calls the loginByCwsToken method in the Users resource', function (): void {
    Saloon::fake([
        LoginByCwsToken::class => MockResponse::fixture('users.loginByCwsToken'),
    ]);

    $response = $this->mattermost->users()->loginByCwsToken(

    );

    Saloon::assertSent(LoginByCwsToken::class);

    expect($response->status())->toBe(200);
});

it('calls the switchAccountType method in the Users resource', function (): void {
    Saloon::fake([
        SwitchAccountType::class => MockResponse::fixture('users.switchAccountType'),
    ]);

    $response = $this->mattermost->users()->switchAccountType(

    );

    Saloon::assertSent(SwitchAccountType::class);

    expect($response->status())->toBe(200);
});

it('calls the logout method in the Users resource', function (): void {
    Saloon::fake([
        Logout::class => MockResponse::fixture('users.logout'),
    ]);

    $response = $this->mattermost->users()->logout(

    );

    Saloon::assertSent(Logout::class);

    expect($response->status())->toBe(200);
});

it('calls the checkUserMfa method in the Users resource', function (): void {
    Saloon::fake([
        CheckUserMfa::class => MockResponse::fixture('users.checkUserMfa'),
    ]);

    $response = $this->mattermost->users()->checkUserMfa(

    );

    Saloon::assertSent(CheckUserMfa::class);

    expect($response->status())->toBe(200);
});

it('calls the migrateAuthToLdap method in the Users resource', function (): void {
    Saloon::fake([
        MigrateAuthToLdap::class => MockResponse::fixture('users.migrateAuthToLdap'),
    ]);

    $response = $this->mattermost->users()->migrateAuthToLdap(

    );

    Saloon::assertSent(MigrateAuthToLdap::class);

    expect($response->status())->toBe(200);
});

it('calls the migrateAuthToSaml method in the Users resource', function (): void {
    Saloon::fake([
        MigrateAuthToSaml::class => MockResponse::fixture('users.migrateAuthToSaml'),
    ]);

    $response = $this->mattermost->users()->migrateAuthToSaml(

    );

    Saloon::assertSent(MigrateAuthToSaml::class);

    expect($response->status())->toBe(200);
});

it('calls the resetPassword method in the Users resource', function (): void {
    Saloon::fake([
        ResetPassword::class => MockResponse::fixture('users.resetPassword'),
    ]);

    $response = $this->mattermost->users()->resetPassword(

    );

    Saloon::assertSent(ResetPassword::class);

    expect($response->status())->toBe(200);
});

it('calls the sendPasswordResetEmail method in the Users resource', function (): void {
    Saloon::fake([
        SendPasswordResetEmail::class => MockResponse::fixture('users.sendPasswordResetEmail'),
    ]);

    $response = $this->mattermost->users()->sendPasswordResetEmail(

    );

    Saloon::assertSent(SendPasswordResetEmail::class);

    expect($response->status())->toBe(200);
});

it('calls the searchUsers method in the Users resource', function (): void {
    Saloon::fake([
        SearchUsers::class => MockResponse::fixture('users.searchUsers'),
    ]);

    $response = $this->mattermost->users()->searchUsers(

    );

    Saloon::assertSent(SearchUsers::class);

    expect($response->status())->toBe(200);
});

it('calls the attachDeviceId method in the Users resource', function (): void {
    Saloon::fake([
        AttachDeviceId::class => MockResponse::fixture('users.attachDeviceId'),
    ]);

    $response = $this->mattermost->users()->attachDeviceId(

    );

    Saloon::assertSent(AttachDeviceId::class);

    expect($response->status())->toBe(200);
});

it('calls the revokeSessionsFromAllUsers method in the Users resource', function (): void {
    Saloon::fake([
        RevokeSessionsFromAllUsers::class => MockResponse::fixture('users.revokeSessionsFromAllUsers'),
    ]);

    $response = $this->mattermost->users()->revokeSessionsFromAllUsers(

    );

    Saloon::assertSent(RevokeSessionsFromAllUsers::class);

    expect($response->status())->toBe(200);
});

it('calls the getTotalUsersStats method in the Users resource', function (): void {
    Saloon::fake([
        GetTotalUsersStats::class => MockResponse::fixture('users.getTotalUsersStats'),
    ]);

    $response = $this->mattermost->users()->getTotalUsersStats(

    );

    Saloon::assertSent(GetTotalUsersStats::class);

    expect($response->status())->toBe(200);
});

it('calls the getTotalUsersStatsFiltered method in the Users resource', function (): void {
    Saloon::fake([
        GetTotalUsersStatsFiltered::class => MockResponse::fixture('users.getTotalUsersStatsFiltered'),
    ]);

    $response = $this->mattermost->users()->getTotalUsersStatsFiltered(
        inTeam: 'test string',
        inChannel: 'test string',
        includeDeleted: true,
        includeBots: true,
        roles: 'test string',
        channelRoles: 'test string',
        teamRoles: 'test string'
    );

    Saloon::assertSent(GetTotalUsersStatsFiltered::class);

    expect($response->status())->toBe(200);
});

it('calls the getUserAccessTokens method in the Users resource', function (): void {
    Saloon::fake([
        GetUserAccessTokens::class => MockResponse::fixture('users.getUserAccessTokens'),
    ]);

    $response = $this->mattermost->users()->getUserAccessTokens(
        page: 123
    );

    Saloon::assertSent(GetUserAccessTokens::class);

    expect($response->status())->toBe(200);
});

it('calls the disableUserAccessToken method in the Users resource', function (): void {
    Saloon::fake([
        DisableUserAccessToken::class => MockResponse::fixture('users.disableUserAccessToken'),
    ]);

    $response = $this->mattermost->users()->disableUserAccessToken(

    );

    Saloon::assertSent(DisableUserAccessToken::class);

    expect($response->status())->toBe(200);
});

it('calls the enableUserAccessToken method in the Users resource', function (): void {
    Saloon::fake([
        EnableUserAccessToken::class => MockResponse::fixture('users.enableUserAccessToken'),
    ]);

    $response = $this->mattermost->users()->enableUserAccessToken(

    );

    Saloon::assertSent(EnableUserAccessToken::class);

    expect($response->status())->toBe(200);
});

it('calls the revokeUserAccessToken method in the Users resource', function (): void {
    Saloon::fake([
        RevokeUserAccessToken::class => MockResponse::fixture('users.revokeUserAccessToken'),
    ]);

    $response = $this->mattermost->users()->revokeUserAccessToken(

    );

    Saloon::assertSent(RevokeUserAccessToken::class);

    expect($response->status())->toBe(200);
});

it('calls the searchUserAccessTokens method in the Users resource', function (): void {
    Saloon::fake([
        SearchUserAccessTokens::class => MockResponse::fixture('users.searchUserAccessTokens'),
    ]);

    $response = $this->mattermost->users()->searchUserAccessTokens(

    );

    Saloon::assertSent(SearchUserAccessTokens::class);

    expect($response->status())->toBe(200);
});

it('calls the getUserAccessToken method in the Users resource', function (): void {
    Saloon::fake([
        GetUserAccessToken::class => MockResponse::fixture('users.getUserAccessToken'),
    ]);

    $response = $this->mattermost->users()->getUserAccessToken(
        tokenId: 'test string'
    );

    Saloon::assertSent(GetUserAccessToken::class);

    expect($response->status())->toBe(200);
});

it('calls the getUserByUsername method in the Users resource', function (): void {
    Saloon::fake([
        GetUserByUsername::class => MockResponse::fixture('users.getUserByUsername'),
    ]);

    $response = $this->mattermost->users()->getUserByUsername(
        username: 'test string'
    );

    Saloon::assertSent(GetUserByUsername::class);

    expect($response->status())->toBe(200);
});

it('calls the getUsersByUsernames method in the Users resource', function (): void {
    Saloon::fake([
        GetUsersByUsernames::class => MockResponse::fixture('users.getUsersByUsernames'),
    ]);

    $response = $this->mattermost->users()->getUsersByUsernames(

    );

    Saloon::assertSent(GetUsersByUsernames::class);

    expect($response->status())->toBe(200);
});

it('calls the getUser method in the Users resource', function (): void {
    Saloon::fake([
        GetUser::class => MockResponse::fixture('users.getUser'),
    ]);

    $response = $this->mattermost->users()->getUser(
        userId: 'test string'
    );

    Saloon::assertSent(GetUser::class);

    expect($response->status())->toBe(200);
});

it('calls the updateUser method in the Users resource', function (): void {
    Saloon::fake([
        UpdateUser::class => MockResponse::fixture('users.updateUser'),
    ]);

    $response = $this->mattermost->users()->updateUser(
        userId: 'test string'
    );

    Saloon::assertSent(UpdateUser::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteUser method in the Users resource', function (): void {
    Saloon::fake([
        DeleteUser::class => MockResponse::fixture('users.deleteUser'),
    ]);

    $response = $this->mattermost->users()->deleteUser(
        userId: 'test string'
    );

    Saloon::assertSent(DeleteUser::class);

    expect($response->status())->toBe(200);
});

it('calls the updateUserActive method in the Users resource', function (): void {
    Saloon::fake([
        UpdateUserActive::class => MockResponse::fixture('users.updateUserActive'),
    ]);

    $response = $this->mattermost->users()->updateUserActive(
        userId: 'test string'
    );

    Saloon::assertSent(UpdateUserActive::class);

    expect($response->status())->toBe(200);
});

it('calls the getUserAudits method in the Users resource', function (): void {
    Saloon::fake([
        GetUserAudits::class => MockResponse::fixture('users.getUserAudits'),
    ]);

    $response = $this->mattermost->users()->getUserAudits(
        userId: 'test string'
    );

    Saloon::assertSent(GetUserAudits::class);

    expect($response->status())->toBe(200);
});

it('calls the updateUserAuth method in the Users resource', function (): void {
    Saloon::fake([
        UpdateUserAuth::class => MockResponse::fixture('users.updateUserAuth'),
    ]);

    $response = $this->mattermost->users()->updateUserAuth(
        userId: 'test string'
    );

    Saloon::assertSent(UpdateUserAuth::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelMembersWithTeamDataForUser method in the Users resource', function (): void {
    Saloon::fake([
        GetChannelMembersWithTeamDataForUser::class => MockResponse::fixture('users.getChannelMembersWithTeamDataForUser'),
    ]);

    $response = $this->mattermost->users()->getChannelMembersWithTeamDataForUser(
        userId: 'test string',
        page: 123,
        pageSize: 123
    );

    Saloon::assertSent(GetChannelMembersWithTeamDataForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the demoteUserToGuest method in the Users resource', function (): void {
    Saloon::fake([
        DemoteUserToGuest::class => MockResponse::fixture('users.demoteUserToGuest'),
    ]);

    $response = $this->mattermost->users()->demoteUserToGuest(
        userId: 'test string'
    );

    Saloon::assertSent(DemoteUserToGuest::class);

    expect($response->status())->toBe(200);
});

it('calls the verifyUserEmailWithoutToken method in the Users resource', function (): void {
    Saloon::fake([
        VerifyUserEmailWithoutToken::class => MockResponse::fixture('users.verifyUserEmailWithoutToken'),
    ]);

    $response = $this->mattermost->users()->verifyUserEmailWithoutToken(
        userId: 'test string'
    );

    Saloon::assertSent(VerifyUserEmailWithoutToken::class);

    expect($response->status())->toBe(200);
});

it('calls the updateUserMfa method in the Users resource', function (): void {
    Saloon::fake([
        UpdateUserMfa::class => MockResponse::fixture('users.updateUserMfa'),
    ]);

    $response = $this->mattermost->users()->updateUserMfa(
        userId: 'test string'
    );

    Saloon::assertSent(UpdateUserMfa::class);

    expect($response->status())->toBe(200);
});

it('calls the generateMfaSecret method in the Users resource', function (): void {
    Saloon::fake([
        GenerateMfaSecret::class => MockResponse::fixture('users.generateMfaSecret'),
    ]);

    $response = $this->mattermost->users()->generateMfaSecret(
        userId: 'test string'
    );

    Saloon::assertSent(GenerateMfaSecret::class);

    expect($response->status())->toBe(200);
});

it('calls the updateUserPassword method in the Users resource', function (): void {
    Saloon::fake([
        UpdateUserPassword::class => MockResponse::fixture('users.updateUserPassword'),
    ]);

    $response = $this->mattermost->users()->updateUserPassword(
        userId: 'test string'
    );

    Saloon::assertSent(UpdateUserPassword::class);

    expect($response->status())->toBe(200);
});

it('calls the patchUser method in the Users resource', function (): void {
    Saloon::fake([
        PatchUser::class => MockResponse::fixture('users.patchUser'),
    ]);

    $response = $this->mattermost->users()->patchUser(
        userId: 'test string'
    );

    Saloon::assertSent(PatchUser::class);

    expect($response->status())->toBe(200);
});

it('calls the promoteGuestToUser method in the Users resource', function (): void {
    Saloon::fake([
        PromoteGuestToUser::class => MockResponse::fixture('users.promoteGuestToUser'),
    ]);

    $response = $this->mattermost->users()->promoteGuestToUser(
        userId: 'test string'
    );

    Saloon::assertSent(PromoteGuestToUser::class);

    expect($response->status())->toBe(200);
});

it('calls the updateUserRoles method in the Users resource', function (): void {
    Saloon::fake([
        UpdateUserRoles::class => MockResponse::fixture('users.updateUserRoles'),
    ]);

    $response = $this->mattermost->users()->updateUserRoles(
        userId: 'test string'
    );

    Saloon::assertSent(UpdateUserRoles::class);

    expect($response->status())->toBe(200);
});

it('calls the getSessions method in the Users resource', function (): void {
    Saloon::fake([
        GetSessions::class => MockResponse::fixture('users.getSessions'),
    ]);

    $response = $this->mattermost->users()->getSessions(
        userId: 'test string'
    );

    Saloon::assertSent(GetSessions::class);

    expect($response->status())->toBe(200);
});

it('calls the revokeSession method in the Users resource', function (): void {
    Saloon::fake([
        RevokeSession::class => MockResponse::fixture('users.revokeSession'),
    ]);

    $response = $this->mattermost->users()->revokeSession(
        userId: 'test string'
    );

    Saloon::assertSent(RevokeSession::class);

    expect($response->status())->toBe(200);
});

it('calls the revokeAllSessions method in the Users resource', function (): void {
    Saloon::fake([
        RevokeAllSessions::class => MockResponse::fixture('users.revokeAllSessions'),
    ]);

    $response = $this->mattermost->users()->revokeAllSessions(
        userId: 'test string'
    );

    Saloon::assertSent(RevokeAllSessions::class);

    expect($response->status())->toBe(200);
});

it('calls the getUserTermsOfService method in the Users resource', function (): void {
    Saloon::fake([
        GetUserTermsOfService::class => MockResponse::fixture('users.getUserTermsOfService'),
    ]);

    $response = $this->mattermost->users()->getUserTermsOfService(
        userId: 'test string'
    );

    Saloon::assertSent(GetUserTermsOfService::class);

    expect($response->status())->toBe(200);
});

it('calls the registerTermsOfServiceAction method in the Users resource', function (): void {
    Saloon::fake([
        RegisterTermsOfServiceAction::class => MockResponse::fixture('users.registerTermsOfServiceAction'),
    ]);

    $response = $this->mattermost->users()->registerTermsOfServiceAction(
        userId: 'test string'
    );

    Saloon::assertSent(RegisterTermsOfServiceAction::class);

    expect($response->status())->toBe(200);
});

it('calls the getUserAccessTokensForUser method in the Users resource', function (): void {
    Saloon::fake([
        GetUserAccessTokensForUser::class => MockResponse::fixture('users.getUserAccessTokensForUser'),
    ]);

    $response = $this->mattermost->users()->getUserAccessTokensForUser(
        userId: 'test string',
        page: 123
    );

    Saloon::assertSent(GetUserAccessTokensForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the createUserAccessToken method in the Users resource', function (): void {
    Saloon::fake([
        CreateUserAccessToken::class => MockResponse::fixture('users.createUserAccessToken'),
    ]);

    $response = $this->mattermost->users()->createUserAccessToken(
        userId: 'test string'
    );

    Saloon::assertSent(CreateUserAccessToken::class);

    expect($response->status())->toBe(200);
});

it('calls the publishUserTyping method in the Users resource', function (): void {
    Saloon::fake([
        PublishUserTyping::class => MockResponse::fixture('users.publishUserTyping'),
    ]);

    $response = $this->mattermost->users()->publishUserTyping(
        userId: 'test string'
    );

    Saloon::assertSent(PublishUserTyping::class);

    expect($response->status())->toBe(200);
});

it('calls the getUploadsForUser method in the Users resource', function (): void {
    Saloon::fake([
        GetUploadsForUser::class => MockResponse::fixture('users.getUploadsForUser'),
    ]);

    $response = $this->mattermost->users()->getUploadsForUser(
        userId: 'test string'
    );

    Saloon::assertSent(GetUploadsForUser::class);

    expect($response->status())->toBe(200);
});
