<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Requests\Teams\GetAllTeams;
use ConduitUI\Mattermost\Client\Requests\Teams\CreateTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamInviteInfo;
use ConduitUI\Mattermost\Client\Requests\Teams\InvalidateEmailInvites;
use ConduitUI\Mattermost\Client\Requests\Teams\AddTeamMemberFromInvite;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamByName;
use ConduitUI\Mattermost\Client\Requests\Teams\TeamExists;
use ConduitUI\Mattermost\Client\Requests\Teams\SearchTeams;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\UpdateTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\SoftDeleteTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\SearchFiles;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamIcon;
use ConduitUI\Mattermost\Client\Requests\Teams\SetTeamIcon;
use ConduitUI\Mattermost\Client\Requests\Teams\RemoveTeamIcon;
use ConduitUI\Mattermost\Client\Requests\Teams\ImportTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\InviteGuestsToTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\InviteUsersToTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamMembers;
use ConduitUI\Mattermost\Client\Requests\Teams\AddTeamMember;
use ConduitUI\Mattermost\Client\Requests\Teams\AddTeamMembers;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamMembersByIds;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamMember;
use ConduitUI\Mattermost\Client\Requests\Teams\RemoveTeamMember;
use ConduitUI\Mattermost\Client\Requests\Teams\UpdateTeamMemberRoles;
use ConduitUI\Mattermost\Client\Requests\Teams\UpdateTeamMemberSchemeRoles;
use ConduitUI\Mattermost\Client\Requests\Teams\TeamMembersMinusGroupMembers;
use ConduitUI\Mattermost\Client\Requests\Teams\PatchTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\UpdateTeamPrivacy;
use ConduitUI\Mattermost\Client\Requests\Teams\RegenerateTeamInviteId;
use ConduitUI\Mattermost\Client\Requests\Teams\RestoreTeam;
use ConduitUI\Mattermost\Client\Requests\Teams\UpdateTeamScheme;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamStats;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamsForUser;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamMembersForUser;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamsUnreadForUser;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamUnread;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Spatie\LaravelData\DataCollection;

beforeEach(function () {
    $this->mattermost = new ConduitUI\Mattermost\Client\Mattermost(
		bearerToken: 'replace'
	);
});


it('calls the getAllTeams method in the Teams resource', function () {
    Saloon::fake([
        GetAllTeams::class => MockResponse::fixture('teams.getAllTeams'),
    ]);

    $response = $this->mattermost->teams()->getAllTeams(
		page: 123,
		includeTotalCount: true,
		excludePolicyConstrained: true
	);

    Saloon::assertSent(GetAllTeams::class);

    expect($response->status())->toBe(200);
});


it('calls the createTeam method in the Teams resource', function () {
    Saloon::fake([
        CreateTeam::class => MockResponse::fixture('teams.createTeam'),
    ]);

    $response = $this->mattermost->teams()->createTeam(
		
	);

    Saloon::assertSent(CreateTeam::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeamInviteInfo method in the Teams resource', function () {
    Saloon::fake([
        GetTeamInviteInfo::class => MockResponse::fixture('teams.getTeamInviteInfo'),
    ]);

    $response = $this->mattermost->teams()->getTeamInviteInfo(
		inviteId: 'test string'
	);

    Saloon::assertSent(GetTeamInviteInfo::class);

    expect($response->status())->toBe(200);
});


it('calls the invalidateEmailInvites method in the Teams resource', function () {
    Saloon::fake([
        InvalidateEmailInvites::class => MockResponse::fixture('teams.invalidateEmailInvites'),
    ]);

    $response = $this->mattermost->teams()->invalidateEmailInvites(
		
	);

    Saloon::assertSent(InvalidateEmailInvites::class);

    expect($response->status())->toBe(200);
});


it('calls the addTeamMemberFromInvite method in the Teams resource', function () {
    Saloon::fake([
        AddTeamMemberFromInvite::class => MockResponse::fixture('teams.addTeamMemberFromInvite'),
    ]);

    $response = $this->mattermost->teams()->addTeamMemberFromInvite(
		token: 'test string'
	);

    Saloon::assertSent(AddTeamMemberFromInvite::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeamByName method in the Teams resource', function () {
    Saloon::fake([
        GetTeamByName::class => MockResponse::fixture('teams.getTeamByName'),
    ]);

    $response = $this->mattermost->teams()->getTeamByName(
		name: 'test string'
	);

    Saloon::assertSent(GetTeamByName::class);

    expect($response->status())->toBe(200);
});


it('calls the teamExists method in the Teams resource', function () {
    Saloon::fake([
        TeamExists::class => MockResponse::fixture('teams.teamExists'),
    ]);

    $response = $this->mattermost->teams()->teamExists(
		name: 'test string'
	);

    Saloon::assertSent(TeamExists::class);

    expect($response->status())->toBe(200);
});


it('calls the searchTeams method in the Teams resource', function () {
    Saloon::fake([
        SearchTeams::class => MockResponse::fixture('teams.searchTeams'),
    ]);

    $response = $this->mattermost->teams()->searchTeams(
		
	);

    Saloon::assertSent(SearchTeams::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeam method in the Teams resource', function () {
    Saloon::fake([
        GetTeam::class => MockResponse::fixture('teams.getTeam'),
    ]);

    $response = $this->mattermost->teams()->getTeam(
		teamId: 'test string'
	);

    Saloon::assertSent(GetTeam::class);

    expect($response->status())->toBe(200);
});


it('calls the updateTeam method in the Teams resource', function () {
    Saloon::fake([
        UpdateTeam::class => MockResponse::fixture('teams.updateTeam'),
    ]);

    $response = $this->mattermost->teams()->updateTeam(
		teamId: 'test string'
	);

    Saloon::assertSent(UpdateTeam::class);

    expect($response->status())->toBe(200);
});


it('calls the softDeleteTeam method in the Teams resource', function () {
    Saloon::fake([
        SoftDeleteTeam::class => MockResponse::fixture('teams.softDeleteTeam'),
    ]);

    $response = $this->mattermost->teams()->softDeleteTeam(
		teamId: 'test string',
		permanent: true
	);

    Saloon::assertSent(SoftDeleteTeam::class);

    expect($response->status())->toBe(200);
});


it('calls the searchFiles method in the Teams resource', function () {
    Saloon::fake([
        SearchFiles::class => MockResponse::fixture('teams.searchFiles'),
    ]);

    $response = $this->mattermost->teams()->searchFiles(
		teamId: 'test string'
	);

    Saloon::assertSent(SearchFiles::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeamIcon method in the Teams resource', function () {
    Saloon::fake([
        GetTeamIcon::class => MockResponse::fixture('teams.getTeamIcon'),
    ]);

    $response = $this->mattermost->teams()->getTeamIcon(
		teamId: 'test string'
	);

    Saloon::assertSent(GetTeamIcon::class);

    expect($response->status())->toBe(200);
});


it('calls the setTeamIcon method in the Teams resource', function () {
    Saloon::fake([
        SetTeamIcon::class => MockResponse::fixture('teams.setTeamIcon'),
    ]);

    $response = $this->mattermost->teams()->setTeamIcon(
		teamId: 'test string'
	);

    Saloon::assertSent(SetTeamIcon::class);

    expect($response->status())->toBe(200);
});


it('calls the removeTeamIcon method in the Teams resource', function () {
    Saloon::fake([
        RemoveTeamIcon::class => MockResponse::fixture('teams.removeTeamIcon'),
    ]);

    $response = $this->mattermost->teams()->removeTeamIcon(
		teamId: 'test string'
	);

    Saloon::assertSent(RemoveTeamIcon::class);

    expect($response->status())->toBe(200);
});


it('calls the importTeam method in the Teams resource', function () {
    Saloon::fake([
        ImportTeam::class => MockResponse::fixture('teams.importTeam'),
    ]);

    $response = $this->mattermost->teams()->importTeam(
		teamId: 'test string'
	);

    Saloon::assertSent(ImportTeam::class);

    expect($response->status())->toBe(200);
});


it('calls the inviteGuestsToTeam method in the Teams resource', function () {
    Saloon::fake([
        InviteGuestsToTeam::class => MockResponse::fixture('teams.inviteGuestsToTeam'),
    ]);

    $response = $this->mattermost->teams()->inviteGuestsToTeam(
		teamId: 'test string'
	);

    Saloon::assertSent(InviteGuestsToTeam::class);

    expect($response->status())->toBe(200);
});


it('calls the inviteUsersToTeam method in the Teams resource', function () {
    Saloon::fake([
        InviteUsersToTeam::class => MockResponse::fixture('teams.inviteUsersToTeam'),
    ]);

    $response = $this->mattermost->teams()->inviteUsersToTeam(
		teamId: 'test string'
	);

    Saloon::assertSent(InviteUsersToTeam::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeamMembers method in the Teams resource', function () {
    Saloon::fake([
        GetTeamMembers::class => MockResponse::fixture('teams.getTeamMembers'),
    ]);

    $response = $this->mattermost->teams()->getTeamMembers(
		teamId: 'test string',
		page: 123
	);

    Saloon::assertSent(GetTeamMembers::class);

    expect($response->status())->toBe(200);
});


it('calls the addTeamMember method in the Teams resource', function () {
    Saloon::fake([
        AddTeamMember::class => MockResponse::fixture('teams.addTeamMember'),
    ]);

    $response = $this->mattermost->teams()->addTeamMember(
		teamId: 'test string'
	);

    Saloon::assertSent(AddTeamMember::class);

    expect($response->status())->toBe(200);
});


it('calls the addTeamMembers method in the Teams resource', function () {
    Saloon::fake([
        AddTeamMembers::class => MockResponse::fixture('teams.addTeamMembers'),
    ]);

    $response = $this->mattermost->teams()->addTeamMembers(
		teamId: 'test string',
		graceful: true
	);

    Saloon::assertSent(AddTeamMembers::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeamMembersByIds method in the Teams resource', function () {
    Saloon::fake([
        GetTeamMembersByIds::class => MockResponse::fixture('teams.getTeamMembersByIds'),
    ]);

    $response = $this->mattermost->teams()->getTeamMembersByIds(
		teamId: 'test string'
	);

    Saloon::assertSent(GetTeamMembersByIds::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeamMember method in the Teams resource', function () {
    Saloon::fake([
        GetTeamMember::class => MockResponse::fixture('teams.getTeamMember'),
    ]);

    $response = $this->mattermost->teams()->getTeamMember(
		teamId: 'test string',
		userId: 'test string'
	);

    Saloon::assertSent(GetTeamMember::class);

    expect($response->status())->toBe(200);
});


it('calls the removeTeamMember method in the Teams resource', function () {
    Saloon::fake([
        RemoveTeamMember::class => MockResponse::fixture('teams.removeTeamMember'),
    ]);

    $response = $this->mattermost->teams()->removeTeamMember(
		teamId: 'test string',
		userId: 'test string'
	);

    Saloon::assertSent(RemoveTeamMember::class);

    expect($response->status())->toBe(200);
});


it('calls the updateTeamMemberRoles method in the Teams resource', function () {
    Saloon::fake([
        UpdateTeamMemberRoles::class => MockResponse::fixture('teams.updateTeamMemberRoles'),
    ]);

    $response = $this->mattermost->teams()->updateTeamMemberRoles(
		teamId: 'test string',
		userId: 'test string'
	);

    Saloon::assertSent(UpdateTeamMemberRoles::class);

    expect($response->status())->toBe(200);
});


it('calls the updateTeamMemberSchemeRoles method in the Teams resource', function () {
    Saloon::fake([
        UpdateTeamMemberSchemeRoles::class => MockResponse::fixture('teams.updateTeamMemberSchemeRoles'),
    ]);

    $response = $this->mattermost->teams()->updateTeamMemberSchemeRoles(
		teamId: 'test string',
		userId: 'test string'
	);

    Saloon::assertSent(UpdateTeamMemberSchemeRoles::class);

    expect($response->status())->toBe(200);
});


it('calls the teamMembersMinusGroupMembers method in the Teams resource', function () {
    Saloon::fake([
        TeamMembersMinusGroupMembers::class => MockResponse::fixture('teams.teamMembersMinusGroupMembers'),
    ]);

    $response = $this->mattermost->teams()->teamMembersMinusGroupMembers(
		teamId: 'test string',
		groupIds: 'test string',
		page: 123
	);

    Saloon::assertSent(TeamMembersMinusGroupMembers::class);

    expect($response->status())->toBe(200);
});


it('calls the patchTeam method in the Teams resource', function () {
    Saloon::fake([
        PatchTeam::class => MockResponse::fixture('teams.patchTeam'),
    ]);

    $response = $this->mattermost->teams()->patchTeam(
		teamId: 'test string'
	);

    Saloon::assertSent(PatchTeam::class);

    expect($response->status())->toBe(200);
});


it('calls the updateTeamPrivacy method in the Teams resource', function () {
    Saloon::fake([
        UpdateTeamPrivacy::class => MockResponse::fixture('teams.updateTeamPrivacy'),
    ]);

    $response = $this->mattermost->teams()->updateTeamPrivacy(
		teamId: 'test string'
	);

    Saloon::assertSent(UpdateTeamPrivacy::class);

    expect($response->status())->toBe(200);
});


it('calls the regenerateTeamInviteId method in the Teams resource', function () {
    Saloon::fake([
        RegenerateTeamInviteId::class => MockResponse::fixture('teams.regenerateTeamInviteId'),
    ]);

    $response = $this->mattermost->teams()->regenerateTeamInviteId(
		teamId: 'test string'
	);

    Saloon::assertSent(RegenerateTeamInviteId::class);

    expect($response->status())->toBe(200);
});


it('calls the restoreTeam method in the Teams resource', function () {
    Saloon::fake([
        RestoreTeam::class => MockResponse::fixture('teams.restoreTeam'),
    ]);

    $response = $this->mattermost->teams()->restoreTeam(
		teamId: 'test string'
	);

    Saloon::assertSent(RestoreTeam::class);

    expect($response->status())->toBe(200);
});


it('calls the updateTeamScheme method in the Teams resource', function () {
    Saloon::fake([
        UpdateTeamScheme::class => MockResponse::fixture('teams.updateTeamScheme'),
    ]);

    $response = $this->mattermost->teams()->updateTeamScheme(
		teamId: 'test string'
	);

    Saloon::assertSent(UpdateTeamScheme::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeamStats method in the Teams resource', function () {
    Saloon::fake([
        GetTeamStats::class => MockResponse::fixture('teams.getTeamStats'),
    ]);

    $response = $this->mattermost->teams()->getTeamStats(
		teamId: 'test string'
	);

    Saloon::assertSent(GetTeamStats::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeamsForUser method in the Teams resource', function () {
    Saloon::fake([
        GetTeamsForUser::class => MockResponse::fixture('teams.getTeamsForUser'),
    ]);

    $response = $this->mattermost->teams()->getTeamsForUser(
		userId: 'test string'
	);

    Saloon::assertSent(GetTeamsForUser::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeamMembersForUser method in the Teams resource', function () {
    Saloon::fake([
        GetTeamMembersForUser::class => MockResponse::fixture('teams.getTeamMembersForUser'),
    ]);

    $response = $this->mattermost->teams()->getTeamMembersForUser(
		userId: 'test string'
	);

    Saloon::assertSent(GetTeamMembersForUser::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeamsUnreadForUser method in the Teams resource', function () {
    Saloon::fake([
        GetTeamsUnreadForUser::class => MockResponse::fixture('teams.getTeamsUnreadForUser'),
    ]);

    $response = $this->mattermost->teams()->getTeamsUnreadForUser(
		userId: 'test string',
		excludeTeam: 'test string',
		includeCollapsedThreads: true
	);

    Saloon::assertSent(GetTeamsUnreadForUser::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeamUnread method in the Teams resource', function () {
    Saloon::fake([
        GetTeamUnread::class => MockResponse::fixture('teams.getTeamUnread'),
    ]);

    $response = $this->mattermost->teams()->getTeamUnread(
		userId: 'test string',
		teamId: 'test string'
	);

    Saloon::assertSent(GetTeamUnread::class);

    expect($response->status())->toBe(200);
});
