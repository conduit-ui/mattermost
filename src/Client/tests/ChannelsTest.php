<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Mattermost;
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
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

beforeEach(function (): void {
    $this->mattermost = new Mattermost(
        bearerToken: 'replace'
    );
});

it('calls the getAllChannels method in the Channels resource', function (): void {
    Saloon::fake([
        GetAllChannels::class => MockResponse::fixture('channels.getAllChannels'),
    ]);

    $response = $this->mattermost->channels()->getAllChannels(
        notAssociatedToGroup: 'test string',
        page: 123,
        excludeDefaultChannels: true,
        includeDeleted: true,
        includeTotalCount: true,
        excludePolicyConstrained: true
    );

    Saloon::assertSent(GetAllChannels::class);

    expect($response->status())->toBe(200);
});

it('calls the createChannel method in the Channels resource', function (): void {
    Saloon::fake([
        CreateChannel::class => MockResponse::fixture('channels.createChannel'),
    ]);

    $response = $this->mattermost->channels()->createChannel(

    );

    Saloon::assertSent(CreateChannel::class);

    expect($response->status())->toBe(200);
});

it('calls the createDirectChannel method in the Channels resource', function (): void {
    Saloon::fake([
        CreateDirectChannel::class => MockResponse::fixture('channels.createDirectChannel'),
    ]);

    $response = $this->mattermost->channels()->createDirectChannel(

    );

    Saloon::assertSent(CreateDirectChannel::class);

    expect($response->status())->toBe(200);
});

it('calls the createGroupChannel method in the Channels resource', function (): void {
    Saloon::fake([
        CreateGroupChannel::class => MockResponse::fixture('channels.createGroupChannel'),
    ]);

    $response = $this->mattermost->channels()->createGroupChannel(

    );

    Saloon::assertSent(CreateGroupChannel::class);

    expect($response->status())->toBe(200);
});

it('calls the searchGroupChannels method in the Channels resource', function (): void {
    Saloon::fake([
        SearchGroupChannels::class => MockResponse::fixture('channels.searchGroupChannels'),
    ]);

    $response = $this->mattermost->channels()->searchGroupChannels(

    );

    Saloon::assertSent(SearchGroupChannels::class);

    expect($response->status())->toBe(200);
});

it('calls the viewChannel method in the Channels resource', function (): void {
    Saloon::fake([
        ViewChannel::class => MockResponse::fixture('channels.viewChannel'),
    ]);

    $response = $this->mattermost->channels()->viewChannel(
        userId: 'test string'
    );

    Saloon::assertSent(ViewChannel::class);

    expect($response->status())->toBe(200);
});

it('calls the searchAllChannels method in the Channels resource', function (): void {
    Saloon::fake([
        SearchAllChannels::class => MockResponse::fixture('channels.searchAllChannels'),
    ]);

    $response = $this->mattermost->channels()->searchAllChannels(
        systemConsole: true
    );

    Saloon::assertSent(SearchAllChannels::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannel method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannel::class => MockResponse::fixture('channels.getChannel'),
    ]);

    $response = $this->mattermost->channels()->getChannel(
        channelId: 'test string'
    );

    Saloon::assertSent(GetChannel::class);

    expect($response->status())->toBe(200);
});

it('calls the updateChannel method in the Channels resource', function (): void {
    Saloon::fake([
        UpdateChannel::class => MockResponse::fixture('channels.updateChannel'),
    ]);

    $response = $this->mattermost->channels()->updateChannel(
        channelId: 'test string'
    );

    Saloon::assertSent(UpdateChannel::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteChannel method in the Channels resource', function (): void {
    Saloon::fake([
        DeleteChannel::class => MockResponse::fixture('channels.deleteChannel'),
    ]);

    $response = $this->mattermost->channels()->deleteChannel(
        channelId: 'test string'
    );

    Saloon::assertSent(DeleteChannel::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelMemberCountsByGroup method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelMemberCountsByGroup::class => MockResponse::fixture('channels.getChannelMemberCountsByGroup'),
    ]);

    $response = $this->mattermost->channels()->getChannelMemberCountsByGroup(
        channelId: 'test string',
        includeTimezones: true
    );

    Saloon::assertSent(GetChannelMemberCountsByGroup::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelMembers method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelMembers::class => MockResponse::fixture('channels.getChannelMembers'),
    ]);

    $response = $this->mattermost->channels()->getChannelMembers(
        channelId: 'test string',
        page: 123
    );

    Saloon::assertSent(GetChannelMembers::class);

    expect($response->status())->toBe(200);
});

it('calls the addChannelMember method in the Channels resource', function (): void {
    Saloon::fake([
        AddChannelMember::class => MockResponse::fixture('channels.addChannelMember'),
    ]);

    $response = $this->mattermost->channels()->addChannelMember(
        channelId: 'test string'
    );

    Saloon::assertSent(AddChannelMember::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelMembersByIds method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelMembersByIds::class => MockResponse::fixture('channels.getChannelMembersByIds'),
    ]);

    $response = $this->mattermost->channels()->getChannelMembersByIds(
        channelId: 'test string'
    );

    Saloon::assertSent(GetChannelMembersByIds::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelMember method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelMember::class => MockResponse::fixture('channels.getChannelMember'),
    ]);

    $response = $this->mattermost->channels()->getChannelMember(
        channelId: 'test string',
        userId: 'test string'
    );

    Saloon::assertSent(GetChannelMember::class);

    expect($response->status())->toBe(200);
});

it('calls the removeUserFromChannel method in the Channels resource', function (): void {
    Saloon::fake([
        RemoveUserFromChannel::class => MockResponse::fixture('channels.removeUserFromChannel'),
    ]);

    $response = $this->mattermost->channels()->removeUserFromChannel(
        channelId: 'test string',
        userId: 'test string'
    );

    Saloon::assertSent(RemoveUserFromChannel::class);

    expect($response->status())->toBe(200);
});

it('calls the updateChannelNotifyProps method in the Channels resource', function (): void {
    Saloon::fake([
        UpdateChannelNotifyProps::class => MockResponse::fixture('channels.updateChannelNotifyProps'),
    ]);

    $response = $this->mattermost->channels()->updateChannelNotifyProps(
        channelId: 'test string',
        userId: 'test string'
    );

    Saloon::assertSent(UpdateChannelNotifyProps::class);

    expect($response->status())->toBe(200);
});

it('calls the updateChannelRoles method in the Channels resource', function (): void {
    Saloon::fake([
        UpdateChannelRoles::class => MockResponse::fixture('channels.updateChannelRoles'),
    ]);

    $response = $this->mattermost->channels()->updateChannelRoles(
        channelId: 'test string',
        userId: 'test string'
    );

    Saloon::assertSent(UpdateChannelRoles::class);

    expect($response->status())->toBe(200);
});

it('calls the updateChannelMemberSchemeRoles method in the Channels resource', function (): void {
    Saloon::fake([
        UpdateChannelMemberSchemeRoles::class => MockResponse::fixture('channels.updateChannelMemberSchemeRoles'),
    ]);

    $response = $this->mattermost->channels()->updateChannelMemberSchemeRoles(
        channelId: 'test string',
        userId: 'test string'
    );

    Saloon::assertSent(UpdateChannelMemberSchemeRoles::class);

    expect($response->status())->toBe(200);
});

it('calls the channelMembersMinusGroupMembers method in the Channels resource', function (): void {
    Saloon::fake([
        ChannelMembersMinusGroupMembers::class => MockResponse::fixture('channels.channelMembersMinusGroupMembers'),
    ]);

    $response = $this->mattermost->channels()->channelMembersMinusGroupMembers(
        channelId: 'test string',
        groupIds: 'test string',
        page: 123
    );

    Saloon::assertSent(ChannelMembersMinusGroupMembers::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelModerations method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelModerations::class => MockResponse::fixture('channels.getChannelModerations'),
    ]);

    $response = $this->mattermost->channels()->getChannelModerations(
        channelId: 'test string'
    );

    Saloon::assertSent(GetChannelModerations::class);

    expect($response->status())->toBe(200);
});

it('calls the patchChannelModerations method in the Channels resource', function (): void {
    Saloon::fake([
        PatchChannelModerations::class => MockResponse::fixture('channels.patchChannelModerations'),
    ]);

    $response = $this->mattermost->channels()->patchChannelModerations(
        channelId: 'test string'
    );

    Saloon::assertSent(PatchChannelModerations::class);

    expect($response->status())->toBe(200);
});

it('calls the moveChannel method in the Channels resource', function (): void {
    Saloon::fake([
        MoveChannel::class => MockResponse::fixture('channels.moveChannel'),
    ]);

    $response = $this->mattermost->channels()->moveChannel(
        channelId: 'test string'
    );

    Saloon::assertSent(MoveChannel::class);

    expect($response->status())->toBe(200);
});

it('calls the patchChannel method in the Channels resource', function (): void {
    Saloon::fake([
        PatchChannel::class => MockResponse::fixture('channels.patchChannel'),
    ]);

    $response = $this->mattermost->channels()->patchChannel(
        channelId: 'test string'
    );

    Saloon::assertSent(PatchChannel::class);

    expect($response->status())->toBe(200);
});

it('calls the getPinnedPosts method in the Channels resource', function (): void {
    Saloon::fake([
        GetPinnedPosts::class => MockResponse::fixture('channels.getPinnedPosts'),
    ]);

    $response = $this->mattermost->channels()->getPinnedPosts(
        channelId: 'test string'
    );

    Saloon::assertSent(GetPinnedPosts::class);

    expect($response->status())->toBe(200);
});

it('calls the updateChannelPrivacy method in the Channels resource', function (): void {
    Saloon::fake([
        UpdateChannelPrivacy::class => MockResponse::fixture('channels.updateChannelPrivacy'),
    ]);

    $response = $this->mattermost->channels()->updateChannelPrivacy(
        channelId: 'test string'
    );

    Saloon::assertSent(UpdateChannelPrivacy::class);

    expect($response->status())->toBe(200);
});

it('calls the restoreChannel method in the Channels resource', function (): void {
    Saloon::fake([
        RestoreChannel::class => MockResponse::fixture('channels.restoreChannel'),
    ]);

    $response = $this->mattermost->channels()->restoreChannel(
        channelId: 'test string'
    );

    Saloon::assertSent(RestoreChannel::class);

    expect($response->status())->toBe(200);
});

it('calls the updateChannelScheme method in the Channels resource', function (): void {
    Saloon::fake([
        UpdateChannelScheme::class => MockResponse::fixture('channels.updateChannelScheme'),
    ]);

    $response = $this->mattermost->channels()->updateChannelScheme(
        channelId: 'test string'
    );

    Saloon::assertSent(UpdateChannelScheme::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelStats method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelStats::class => MockResponse::fixture('channels.getChannelStats'),
    ]);

    $response = $this->mattermost->channels()->getChannelStats(
        channelId: 'test string'
    );

    Saloon::assertSent(GetChannelStats::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelMembersTimezones method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelMembersTimezones::class => MockResponse::fixture('channels.getChannelMembersTimezones'),
    ]);

    $response = $this->mattermost->channels()->getChannelMembersTimezones(
        channelId: 'test string'
    );

    Saloon::assertSent(GetChannelMembersTimezones::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelByNameForTeamName method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelByNameForTeamName::class => MockResponse::fixture('channels.getChannelByNameForTeamName'),
    ]);

    $response = $this->mattermost->channels()->getChannelByNameForTeamName(
        teamName: 'test string',
        channelName: 'test string',
        includeDeleted: true
    );

    Saloon::assertSent(GetChannelByNameForTeamName::class);

    expect($response->status())->toBe(200);
});

it('calls the getPublicChannelsForTeam method in the Channels resource', function (): void {
    Saloon::fake([
        GetPublicChannelsForTeam::class => MockResponse::fixture('channels.getPublicChannelsForTeam'),
    ]);

    $response = $this->mattermost->channels()->getPublicChannelsForTeam(
        teamId: 'test string',
        page: 123
    );

    Saloon::assertSent(GetPublicChannelsForTeam::class);

    expect($response->status())->toBe(200);
});

it('calls the autocompleteChannelsForTeam method in the Channels resource', function (): void {
    Saloon::fake([
        AutocompleteChannelsForTeam::class => MockResponse::fixture('channels.autocompleteChannelsForTeam'),
    ]);

    $response = $this->mattermost->channels()->autocompleteChannelsForTeam(
        teamId: 'test string',
        name: 'test string'
    );

    Saloon::assertSent(AutocompleteChannelsForTeam::class);

    expect($response->status())->toBe(200);
});

it('calls the getDeletedChannelsForTeam method in the Channels resource', function (): void {
    Saloon::fake([
        GetDeletedChannelsForTeam::class => MockResponse::fixture('channels.getDeletedChannelsForTeam'),
    ]);

    $response = $this->mattermost->channels()->getDeletedChannelsForTeam(
        teamId: 'test string',
        page: 123
    );

    Saloon::assertSent(GetDeletedChannelsForTeam::class);

    expect($response->status())->toBe(200);
});

it('calls the getPublicChannelsByIdsForTeam method in the Channels resource', function (): void {
    Saloon::fake([
        GetPublicChannelsByIdsForTeam::class => MockResponse::fixture('channels.getPublicChannelsByIdsForTeam'),
    ]);

    $response = $this->mattermost->channels()->getPublicChannelsByIdsForTeam(
        teamId: 'test string'
    );

    Saloon::assertSent(GetPublicChannelsByIdsForTeam::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelByName method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelByName::class => MockResponse::fixture('channels.getChannelByName'),
    ]);

    $response = $this->mattermost->channels()->getChannelByName(
        teamId: 'test string',
        channelName: 'test string',
        includeDeleted: true
    );

    Saloon::assertSent(GetChannelByName::class);

    expect($response->status())->toBe(200);
});

it('calls the getPrivateChannelsForTeam method in the Channels resource', function (): void {
    Saloon::fake([
        GetPrivateChannelsForTeam::class => MockResponse::fixture('channels.getPrivateChannelsForTeam'),
    ]);

    $response = $this->mattermost->channels()->getPrivateChannelsForTeam(
        teamId: 'test string',
        page: 123
    );

    Saloon::assertSent(GetPrivateChannelsForTeam::class);

    expect($response->status())->toBe(200);
});

it('calls the searchChannels method in the Channels resource', function (): void {
    Saloon::fake([
        SearchChannels::class => MockResponse::fixture('channels.searchChannels'),
    ]);

    $response = $this->mattermost->channels()->searchChannels(
        teamId: 'test string'
    );

    Saloon::assertSent(SearchChannels::class);

    expect($response->status())->toBe(200);
});

it('calls the searchArchivedChannels method in the Channels resource', function (): void {
    Saloon::fake([
        SearchArchivedChannels::class => MockResponse::fixture('channels.searchArchivedChannels'),
    ]);

    $response = $this->mattermost->channels()->searchArchivedChannels(
        teamId: 'test string'
    );

    Saloon::assertSent(SearchArchivedChannels::class);

    expect($response->status())->toBe(200);
});

it('calls the autocompleteChannelsForTeamForSearch method in the Channels resource', function (): void {
    Saloon::fake([
        AutocompleteChannelsForTeamForSearch::class => MockResponse::fixture('channels.autocompleteChannelsForTeamForSearch'),
    ]);

    $response = $this->mattermost->channels()->autocompleteChannelsForTeamForSearch(
        teamId: 'test string',
        name: 'test string'
    );

    Saloon::assertSent(AutocompleteChannelsForTeamForSearch::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelsForUser method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelsForUser::class => MockResponse::fixture('channels.getChannelsForUser'),
    ]);

    $response = $this->mattermost->channels()->getChannelsForUser(
        userId: 'test string',
        lastDeleteAt: 123,
        includeDeleted: true
    );

    Saloon::assertSent(GetChannelsForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelUnread method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelUnread::class => MockResponse::fixture('channels.getChannelUnread'),
    ]);

    $response = $this->mattermost->channels()->getChannelUnread(
        userId: 'test string',
        channelId: 'test string'
    );

    Saloon::assertSent(GetChannelUnread::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelsForTeamForUser method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelsForTeamForUser::class => MockResponse::fixture('channels.getChannelsForTeamForUser'),
    ]);

    $response = $this->mattermost->channels()->getChannelsForTeamForUser(
        userId: 'test string',
        teamId: 'test string',
        includeDeleted: true,
        lastDeleteAt: 123
    );

    Saloon::assertSent(GetChannelsForTeamForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the getSidebarCategoriesForTeamForUser method in the Channels resource', function (): void {
    Saloon::fake([
        GetSidebarCategoriesForTeamForUser::class => MockResponse::fixture('channels.getSidebarCategoriesForTeamForUser'),
    ]);

    $response = $this->mattermost->channels()->getSidebarCategoriesForTeamForUser(
        teamId: 'test string',
        userId: 'test string'
    );

    Saloon::assertSent(GetSidebarCategoriesForTeamForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the updateSidebarCategoriesForTeamForUser method in the Channels resource', function (): void {
    Saloon::fake([
        UpdateSidebarCategoriesForTeamForUser::class => MockResponse::fixture('channels.updateSidebarCategoriesForTeamForUser'),
    ]);

    $response = $this->mattermost->channels()->updateSidebarCategoriesForTeamForUser(
        teamId: 'test string',
        userId: 'test string'
    );

    Saloon::assertSent(UpdateSidebarCategoriesForTeamForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the createSidebarCategoryForTeamForUser method in the Channels resource', function (): void {
    Saloon::fake([
        CreateSidebarCategoryForTeamForUser::class => MockResponse::fixture('channels.createSidebarCategoryForTeamForUser'),
    ]);

    $response = $this->mattermost->channels()->createSidebarCategoryForTeamForUser(
        teamId: 'test string',
        userId: 'test string'
    );

    Saloon::assertSent(CreateSidebarCategoryForTeamForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the getSidebarCategoryOrderForTeamForUser method in the Channels resource', function (): void {
    Saloon::fake([
        GetSidebarCategoryOrderForTeamForUser::class => MockResponse::fixture('channels.getSidebarCategoryOrderForTeamForUser'),
    ]);

    $response = $this->mattermost->channels()->getSidebarCategoryOrderForTeamForUser(
        teamId: 'test string',
        userId: 'test string'
    );

    Saloon::assertSent(GetSidebarCategoryOrderForTeamForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the updateSidebarCategoryOrderForTeamForUser method in the Channels resource', function (): void {
    Saloon::fake([
        UpdateSidebarCategoryOrderForTeamForUser::class => MockResponse::fixture('channels.updateSidebarCategoryOrderForTeamForUser'),
    ]);

    $response = $this->mattermost->channels()->updateSidebarCategoryOrderForTeamForUser(
        teamId: 'test string',
        userId: 'test string'
    );

    Saloon::assertSent(UpdateSidebarCategoryOrderForTeamForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the getSidebarCategoryForTeamForUser method in the Channels resource', function (): void {
    Saloon::fake([
        GetSidebarCategoryForTeamForUser::class => MockResponse::fixture('channels.getSidebarCategoryForTeamForUser'),
    ]);

    $response = $this->mattermost->channels()->getSidebarCategoryForTeamForUser(
        teamId: 'test string',
        userId: 'test string',
        categoryId: 'test string'
    );

    Saloon::assertSent(GetSidebarCategoryForTeamForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the updateSidebarCategoryForTeamForUser method in the Channels resource', function (): void {
    Saloon::fake([
        UpdateSidebarCategoryForTeamForUser::class => MockResponse::fixture('channels.updateSidebarCategoryForTeamForUser'),
    ]);

    $response = $this->mattermost->channels()->updateSidebarCategoryForTeamForUser(
        teamId: 'test string',
        userId: 'test string',
        categoryId: 'test string'
    );

    Saloon::assertSent(UpdateSidebarCategoryForTeamForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the removeSidebarCategoryForTeamForUser method in the Channels resource', function (): void {
    Saloon::fake([
        RemoveSidebarCategoryForTeamForUser::class => MockResponse::fixture('channels.removeSidebarCategoryForTeamForUser'),
    ]);

    $response = $this->mattermost->channels()->removeSidebarCategoryForTeamForUser(
        teamId: 'test string',
        userId: 'test string',
        categoryId: 'test string'
    );

    Saloon::assertSent(RemoveSidebarCategoryForTeamForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the getChannelMembersForUser method in the Channels resource', function (): void {
    Saloon::fake([
        GetChannelMembersForUser::class => MockResponse::fixture('channels.getChannelMembersForUser'),
    ]);

    $response = $this->mattermost->channels()->getChannelMembersForUser(
        userId: 'test string',
        teamId: 'test string'
    );

    Saloon::assertSent(GetChannelMembersForUser::class);

    expect($response->status())->toBe(200);
});
